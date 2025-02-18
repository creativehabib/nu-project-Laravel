<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NuSmartCard extends Model
{
    protected $fillable = [
        'name', 'department', 'designation', 'pf_number', 'birth_date',
        'prl_date', 'mobile_number', 'blood_id', 'present_address',
        'emergency_contact', 'image', 'signature'
    ];

    /**
     * @return BelongsTo
     */
    public function blood(): BelongsTo
    {
        return $this->belongsTo('App\Models\BloodGroup', 'blood_id');
    }
}
