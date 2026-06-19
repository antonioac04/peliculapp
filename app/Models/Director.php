<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Hidden(['updated_at', 'created_at'])]
class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'birthdate',
    ];

    public function films(): HasMany
    {
        return $this->hasMany(Film::class);
    }
}
