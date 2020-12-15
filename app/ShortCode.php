<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortCode extends Model
{
    protected $table = 'shortcodes';

    protected $fillable = ['shortcode', 'url', 'user_id'];
}