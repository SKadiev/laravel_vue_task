<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tasks_status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDescendingExperation(Builder $query, $from, $to)
    {
        return $query->orderBy('expiration', 'DESC');
    }
}
