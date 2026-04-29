<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model {
        protected $table = 'notes';
        protected $allowedFields = [
            
        ];

    public function getNoteBySemestre($idEtudiant, $idSemestre) {
        $sql = 'SELECT n.id, n.valeur, m.nom AS nom_matiere, s.nom AS nom_semestre
                FROM notes n
                JOIN matieres m ON n.id_matiere = m.id
                JOIN semestres s ON m.id_semestre = s.id
                WHERE n.id_etudiant = ? AND s.id = ?';
        return $this->db->query($sql, [$idEtudiant, $idSemestre])->getResult();
    }

    public function getNoteMaxMatiereOptionnel($idEtudiant, $idSemestre) {
        $sql = 'SELECT m.nom AS nom_matiere, MAX(n.valeur) AS note_max
                FROM notes n
                JOIN matieres m ON n.id_matiere = m.id
                JOIN semestres s ON m.id_semestre = s.id
                WHERE n.id_etudiant = ? AND s.id = ? AND m.optionnel = 1
                GROUP BY m.nom';
        return $this->db->query($sql, [$idEtudiant, $idSemestre])->getResult();
    }

    public function insert($data) {
        $sql = 'INSERT INTO notes (id_etudiant, id_matiere, valeur, id_semestre) VALUES (?, ?, ?, ?)';
        return $this->db->query($sql, [$data['id_etudiant'], $data['id_matiere'], $data['valeur'], $data['idSemestre']]);
    }

    public function update($id, $data) {
        $sql = 'UPDATE notes SET valeur = ? WHERE id = ?';
        return $this->db->query($sql, [$data['valeur'], $id]);
    }

    public function delete($id) {
        $sql = 'DELETE FROM notes WHERE id = ?';
        return $this->db->query($sql, [$id]);
    }
}

?>