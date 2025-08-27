<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCardSetting extends Model
{
    protected $fillable = [
        'organization_name',
        'organization_name_en',
        'organization_name_font_size',
        'organization_logo',
        'organization_logo_width',
        'organization_logo_height',
        'authority_name',
        'authority_signature',
        'back_footer',
    ];
}

