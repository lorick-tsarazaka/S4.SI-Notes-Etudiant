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
        'num_inscription',
        'id_classe_actuelle',
    ];

    public function findAll(?int $limit = null, int $offset = 0)
    {
        $builder = $this->db->table($this->table);
        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResult();
    }

    public function getById($id) {
        $sql = 'select * from etudiants where id = ?';
        return $this->db->query($sql, [$id])->getRow();
    }

}