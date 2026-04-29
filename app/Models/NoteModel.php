<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model {
        protected $table = 'notes';
        protected $allowedFields = [
        'id_etudiant',
        'id_matiere',
        'id_semestre',
        'valeur',
        ];

    public function getNoteBySemestre($idEtudiant, $idSemestre) {
        $sql = 'SELECT n.id, n.valeur, m.intitule, m.ue, s.nom AS nom_semestre
                FROM notes n
                JOIN matieres m ON n.id_matiere = m.id
                JOIN semestres s ON n.id_semestre = s.id
                WHERE n.id_etudiant = ? AND s.id = ?';
        return $this->db->query($sql, [$idEtudiant, $idSemestre])->getResult();
    }

    public function getMaxNotesByEtudiantAndMatieres(int $idEtudiant, array $matiereIds): array
    {
        if (empty($matiereIds)) {
            return [];
        }

        $result = $this->db->table('notes')
            ->select('id_matiere, MAX(valeur) AS note_max')
            ->where('id_etudiant', $idEtudiant)
            ->whereIn('id_matiere', $matiereIds)
            ->groupBy('id_matiere')
            ->get()
            ->getResultArray();

        $map = [];
        foreach ($result as $row) {
            $map[(int) $row['id_matiere']] = $row['note_max'] === null ? null : (float) $row['note_max'];
        }

        return $map;
    }

    public function getAllWithRelations(): array
    {
        return $this->db->table('notes n')
            ->select('n.id, n.valeur, n.id_etudiant, n.id_matiere, e.nom AS etudiant_nom, e.prenom AS etudiant_prenom, e.num_inscription, m.ue, m.intitule, s.nom AS semestre_nom')
            ->join('etudiants e', 'e.id = n.id_etudiant', 'left')
            ->join('matieres m', 'm.id = n.id_matiere', 'left')
            ->join('semestres s', 's.id = n.id_semestre', 'left')
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->orderBy('s.nom', 'ASC')
            ->orderBy('m.ue', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getByIdWithRelations(int $id): ?array
    {
        $row = $this->db->table('notes n')
            ->select('n.id, n.valeur, n.id_etudiant, n.id_matiere, e.nom AS etudiant_nom, e.prenom AS etudiant_prenom, e.num_inscription, m.ue, m.intitule, s.nom AS semestre_nom')
            ->join('etudiants e', 'e.id = n.id_etudiant', 'left')
            ->join('matieres m', 'm.id = n.id_matiere', 'left')
            ->join('semestres s', 's.id = n.id_semestre', 'left')
            ->where('n.id', $id)
            ->get()
            ->getRowArray();

        return $row ?: null;
    }

    public function getPagedWithRelations(int $perPage = 10, string $group = 'notes'): array
    {
        return $this->select('notes.id, notes.valeur, notes.id_etudiant, notes.id_matiere, e.nom AS etudiant_nom, e.prenom AS etudiant_prenom, e.num_inscription, m.ue, m.intitule, s.nom AS semestre_nom')
            ->join('etudiants e', 'e.id = notes.id_etudiant', 'left')
            ->join('matieres m', 'm.id = notes.id_matiere', 'left')
            ->join('semestres s', 's.id = notes.id_semestre', 'left')
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->orderBy('s.nom', 'ASC')
            ->orderBy('m.ue', 'ASC')
            ->paginate($perPage, $group);
    }

    public function insert($row = null, bool $returnID = true)
    {
        if ($row === null) {
            return $returnID ? 0 : false;
        }

        $builder = $this->db->table($this->table);
        $result = $builder->insert($row);

        if (!$result) {
            return $returnID ? 0 : false;
        }

        return $returnID ? (int) $this->db->insertID() : true;
    }

    public function update($id = null, $row = null): bool
    {
        if ($id === null || $row === null) {
            return false;
        }

        return $this->db->table($this->table)
            ->where('id', $id)
            ->update($row);
    }

    public function delete($id = null, bool $purge = false)
    {
        if ($id === null) {
            return false;
        }

        return $this->db->table($this->table)
            ->where('id', $id)
            ->delete();
    }
}

?>