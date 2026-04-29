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

        public function findAll(?int $limit = null, int $offset = 0)
        {
            $builder = $this->db->table($this->table);
            if ($limit !== null) {
                $builder->limit($limit, $offset);
            }

            return $builder->get()->getResult();
        }

        public function getById($id) {
            $sql = 'select * from matieres where id = ?';
            return $this->db->query($sql, [$id])->getRow();
        }

        public function getMatieresBySemestre($idSemestre) {
            $sql = 'SELECT * FROM matieres WHERE id_semestre = ?';
            return $this->db->query($sql, [$idSemestre])->getResult();
        }

        public function getMatieresBySemestreIds(array $semestreIds) {
            if (empty($semestreIds)) {
                return [];
            }

            return $this->db->table('matieres')
                ->whereIn('id_semestre', $semestreIds)
                ->get()
                ->getResultArray();
        }

        public function getMatieresWithSemestre(): array
        {
            return $this->db->table('matieres m')
                ->select('m.id, m.ue, m.intitule, m.id_semestre, m.credits, s.nom AS semestre_nom')
                ->join('semestres s', 's.id = m.id_semestre', 'left')
                ->orderBy('s.nom', 'ASC')
                ->orderBy('m.ue', 'ASC')
                ->get()
                ->getResultArray();
        }
    }
?>