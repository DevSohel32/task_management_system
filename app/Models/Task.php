<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
      protected $casts = [
    'due_date' => 'date',
];
protected $fillable = [
    'user_id',
    'title',
    'description',
    'status',
    'due_date',
];
public function user(){
    return $this->belongsTo(User::class);
}
}
