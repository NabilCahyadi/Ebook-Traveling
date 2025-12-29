<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_type',
        'title',
        'description',
        'link',
        'icon_class',
        'is_active',
        'show_in_contact_page',
    ];
}
