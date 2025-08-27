<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCardSetting extends Model
{
    protected $fillable = [
        'organization_name',
        'organization_logo',
        'authority_name',
        'authority_logo',
    ];
}

