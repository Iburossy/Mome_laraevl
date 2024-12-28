<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'categorie_id',
        'titre',
        // 'nom',
        'description',
        'images',
        'date',
        'lieu',
        'user_id',
        'statut'
    ];

    // Ajoutez cette section
    protected $casts = [
        'date' => 'date',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
