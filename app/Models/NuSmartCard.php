<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NuSmartCard extends Model
{
    protected $fillable = [
        'name', 'department', 'designation', 'pf_number', 'birth_date',
        'prl_date', 'mobile_number', 'blood_group', 'present_address',
        'emergency_contact', 'image', 'signature'
    ];
}
