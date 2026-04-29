<?php 
    namespace App\Models;

    use CodeIgniter\Model;

    class MatiereModel extends Model {
        protected $table = 'matieres';
        protected $allowedFields = [
            'id',
            'intitule',
            'ue',
            'credits',
            'id_semestre'
        ];

        public function findAll() {
            $sql = 'select * from matieres';
            return $this->db->query($sql)->getResult();
        }

        public function getById($id) {
            $sql = 'select * from matieres where id = ?';
            return $this->db->query($sql, [$id])->getRow();
        }

        public function getMatieresBySemestre($idSemestre) {
            $sql = 'SELECT * FROM matieres WHERE id_semestre = ?';
            return $this->db->query($sql, [$idSemestre])->getResult();
        }
    }
?>