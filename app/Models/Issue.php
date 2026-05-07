<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'category',
        'status',
        'summary',
        'suggested_action',
        'escalation_required',
        'due_at',
    ];

    protected $casts = [
        'escalation_required' => 'boolean',
        'due_at' => 'datetime',
    ];
}