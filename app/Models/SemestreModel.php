<?php

namespace App\Models;

use CodeIgniter\Model;

class SemestreModel extends Model
{
    protected $table = 'semestres';
    protected $allowedFields = [
        'nom',
        'id_option',
        'id_classe',
    ];

    public function getByNames(array $names): array
    {
        if (empty($names)) {
            return [];
        }

        return $this->db->table('semestres')
            ->whereIn('nom', $names)
            ->get()
            ->getResultArray();
    }

    public function getAllWithOptionAndClasse(): array
    {
        return $this->db->table('semestres s')
            ->select('s.id, s.nom, s.id_option, s.id_classe, o.nom AS option_nom, c.nom AS classe_nom')
            ->join('options o', 'o.id = s.id_option', 'left')
            ->join('classes c', 'c.id = s.id_classe', 'left')
            ->orderBy('s.nom', 'ASC')
            ->get()
            ->getResultArray();
    }
}
