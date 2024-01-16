<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'owner_id', 'status_id'];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
