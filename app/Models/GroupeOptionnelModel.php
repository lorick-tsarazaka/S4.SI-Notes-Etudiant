<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupeOptionnelModel extends Model
{
    protected $table = 'groupes_optionnels';
    protected $allowedFields = [
        'nom',
        'id_semestre',
        'credits',
    ];

    public function getGroupsBySemestreIds(array $semestreIds): array
    {
        if (empty($semestreIds)) {
            return [];
        }

        return $this->db->table('groupes_optionnels')
            ->whereIn('id_semestre', $semestreIds)
            ->get()
            ->getResultArray();
    }

    public function getGroupMatieresMap(array $groupIds): array
    {
        if (empty($groupIds)) {
            return [];
        }

        $rows = $this->db->table('groupes_optionnels_matieres')
            ->select('id_groupe, id_matiere')
            ->whereIn('id_groupe', $groupIds)
            ->get()
            ->getResultArray();

        $map = [];
        foreach ($rows as $row) {
            $groupId = (int) $row['id_groupe'];
            $map[$groupId][] = (int) $row['id_matiere'];
        }

        return $map;
    }
}
