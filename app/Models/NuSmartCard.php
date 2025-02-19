<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class NuSmartCard extends Model
{
    public const IMAGE_UPLOAD_PATH = 'uploads/images/';
    public const SIGNATURE_UPLOAD_PATH = 'uploads/signature/';

    protected $fillable = [
        'name', 'department', 'designation', 'pf_number', 'birth_date',
        'prl_date', 'mobile_number', 'blood_id', 'present_address',
        'emergency_contact', 'image', 'signature'
    ];

    public function storeSmartCard(Request $request)
    {
        return self::query()->create($this->prepareData($request));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return bool
     */
    public function updateSmartCard(Request $request, Model $model): bool
    {
        return $model->update($this->prepareData($request, $model));
    }
    /**
     * @param Request $request
     * @param Model|NULL $model
     * @return array
     */
    public function prepareData(Request $request, Model|NULL $model = null): array
    {
        // Parse birth date and calculate PRL date
        $birthDate = Carbon::parse($request->birth_date);
        $prlDate = $birthDate->addYears(60); // Add 60 years

        $data = [
            'name'              => $request->input('name'),
            'department'        => $request->input('department'),
            'designation'       => $request->input('designation'),
            'pf_number'         => $request->input('pf_number'),
            'birth_date'        => $request->input('birth_date'),
            'prl_date'          => $prlDate,
            'mobile_number'     => $request->input('mobile_number'),
            'blood_id'          => $request->input('blood_id'),
            'present_address'   => $request->input('present_address'),
            'emergency_contact' => $request->input('emergency_contact'),
        ];
        // Handle image upload
        $data['image'] = $this->handleFileUpload($request, 'image', $model?->image ?? null, self::IMAGE_UPLOAD_PATH);
        // Handle signature upload
        $data['signature'] = $this->handleFileUpload($request, 'signature', $model?->signature ?? null, self::SIGNATURE_UPLOAD_PATH);
        return $data;
    }

    /**
     * @param Request $request
     * @param string $fileName
     * @param string $existingFile
     * @param string $uploadPath
     * @return string
     */
    private function handleFileUpload(Request $request, string $fileName, string $existingFile, string $uploadPath): string
    {
        if(!$request->hasFile($fileName)){
            return $existingFile; // Return existing file if new one isn't upload
        }
        $file = $request->file($fileName);
        // Delete old file/image if it exists
        if($existingFile){
            $oldFilePath = public_path($uploadPath . $existingFile);
            if(File::exists($oldFilePath)){
                File::delete($oldFilePath);
            }
        }
        // Generate new image/file name
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$extension;
        $file->move($uploadPath, $fileName); // Move file to destination
        return $fileName;
    }

    /**
     * @param Model $model
     * @return void
     */
    final public function deleteSmartCard(Model $model): void
    {
        $this->deleteFile($model->image, self::IMAGE_UPLOAD_PATH);
        $this->deleteFile($model->signature, self::SIGNATURE_UPLOAD_PATH);
        $model->delete();
    }

    /**
     * @param string|null $fileName
     * @param string $uploadPath
     * @return void
     */
    private function deleteFile(?string $fileName, string $uploadPath): void
    {
        if(!$fileName) return;
        $filePath = public_path($uploadPath . $fileName);
        if(File::exists($filePath)){
            File::delete($filePath);
        }
    }

    /**
     * @return BelongsTo
     */
    public function blood(): BelongsTo
    {
        return $this->belongsTo('App\Models\BloodGroup', 'blood_id');
    }
}
