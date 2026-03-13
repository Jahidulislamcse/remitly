<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorSetting extends Model
{
    use HasFactory;

    protected $fillable = ['body_color', 'header_color', 'footer_color', 'headings_color', 'label_color', 'paragraph_color', 'heading_background_color'];
}
