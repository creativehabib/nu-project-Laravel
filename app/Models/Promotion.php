<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'post_name', 'pf_no', 'present_designation', 'department',
        'applicant_name', 'applicant_name_bn', 'father_name', 'father_name_bn',
        'mother_name', 'mother_name_bn', 'home_district',
        'present_address', 'present_address_bn', 'permanent_address', 'permanent_address_bn',
        'nid_number', 'b_day', 'b_month', 'b_year', 'gender', 'marital_status',
        'religion', 'nationality', 'current_job_duration', 'previous_job_duration',
        'total_job_duration', 'mobile_no', 'email', 'photo', 'signature', 'writ_petition',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $table = 'promotions';    
}
