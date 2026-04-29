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

    //  function to get notes with informations (etudiant, matiere, semestre)
    public function getNotesWithInfos($etudiant=null, $matiere=null, $semestre=null) {
        $builder = $this->select('notes.*, etudiants.num_inscription as etu, matieres.intitule as mat_intitule, semestres.nom as semestre')
                        ->join('etudiants', 'notes.id_etudiant = etudiants.id')
                        ->join('matieres', 'notes.id_matiere = matieres.id')
                        ->join('semestres', 'notes.id_semestre = semestres.id');

        if ($etudiant) {
            $builder->like('etudiants.num_inscription', $etudiant);
        }

        if ($matiere) {
            $builder->where('matieres.id', $matiere);
        }

        if ($semestre) {
            $builder->where('semestres.id', $semestre);
        }

        $notes = $builder->paginate(10);

        return $notes;
    }
}