<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state', 'user_id'];

    protected $casts = [
        'state' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($model) {
    //         if (self::where('name', $model->name)->where('user_id', $model->user_id)->exists()) {
    //             throw new \Exception('Task with the same name already exists for this user.');
    //         }
    //     });
    // }
}
