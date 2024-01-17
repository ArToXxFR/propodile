<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'owner_id', 'status_id'];

    public static $rules = [
        'title' => 'required|string|max:100',
        'description' => 'required|string|max:1080',
        'status' => 'required|exists:statuses,id',
    ];

    public static $messages = [
        'title.required' => "Le titre est requis.",
        'title.string' => 'Le titre doit être une chaîne de caractères.',
        'title.max' => 'Le titre doit avoir une longueur maximum de :max caractères',
        'description.required' => "La description est requise.",
        'description.string' => 'La description doit être une chaîne de caractères.',
        'description.max' => 'La description doit avoir une longueur maximum de :max caractères',
        'status.required' => 'Le status est requis.',
        'status.exists' => 'Le status doit exister.',
    ];

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
