<?php

namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table = 'etudiants';
    protected $allowedFields = [
        'nom', 
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'numero',
        'id_classe_actuelle',
    ];
}