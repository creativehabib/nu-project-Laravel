<?php

namespace App\Models;

use App\Helpers\DateHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NuSmartCard extends Model
{
    public const IMAGE_UPLOAD_PATH = 'uploads/images/';
    public const SIGNATURE_UPLOAD_PATH = 'uploads/signature/';

    protected $fillable = [
        'name', 'department', 'designation', 'pf_number',
        'birth_date', 'prl_date', 'mobile_number', 'blood_id',
        'present_address', 'emergency_contact', 'image', 'signature'
    ];

    public function storeSmartCard(Request $request)
    {
        $data = $this->prepareData($request);
        return self::create($data);
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
    final public function prepareData(Request $request, Model|NULL $model = null): array
    {

        $data = [
            'name'              => $request->input('name'),
            'department'        => $request->input('department'),
            'designation'       => $request->input('designation'),
            'pf_number'         => $request->input('pf_number'),
            'birth_date'        => $request->input('birth_date'),
            'prl_date'          => DateHelpers::calculatePRLDate($request->input('birth_date')),
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
     * @param string|null $existingFile
     * @param string $uploadPath
     * @return string|null
     */
    private function handleFileUpload(Request $request, string $fileName, ?string $existingFile, string $uploadPath): ?string
    {
        if(!$request->hasFile($fileName)){
            return $existingFile; // Return existing file if new one isn't upload
        }
        $file = $request->file($fileName);
        // Delete old file/image if it exists
        if(!empty($existingFile)){
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
        DateHelpers::deleteFile($model->image, self::IMAGE_UPLOAD_PATH);
        DateHelpers::deleteFile($model->signature, self::SIGNATURE_UPLOAD_PATH);
        $model->delete();
    }

    /**
     * @return BelongsTo
     */
    public function blood(): BelongsTo
    {
        return $this->belongsTo('App\Models\BloodGroup', 'blood_id');
    }
}
