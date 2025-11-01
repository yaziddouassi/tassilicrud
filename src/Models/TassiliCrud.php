<?php

namespace Tassili\Crud\Models;

use Illuminate\Database\Eloquent\Model;

class TassiliCrud extends Model
{

    protected $fillable = [
        'model',
        'label',
        'route',
        'icon',
        'active',
    ];
    
    protected $casts = [
        'active' => 'boolean',
    ];
}