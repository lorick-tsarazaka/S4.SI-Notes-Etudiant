<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'notes';
    protected $allowedFields = [
        'id_etudiant', 
        'id_matiere',
        'id_semestre',
        'valeur',
    ];
}