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

    public function findAll() {
        $sql = 'select * from etudiants';
        return $this->db->query($sql)->getResult();
    }

    public function getById($id) {
        $sql = 'select * from etudiants where id = ?';
        return $this->db->query($sql, [$id])->getRow();
    }

}