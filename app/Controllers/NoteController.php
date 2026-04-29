<?php

namespace App\Controllers;

use Config\Database;
use App\Models\NoteModel;

class NoteController extends BaseController
{

    //  function to show page index
    public function index() {
        $noteModel = new NoteModel();

        $etudiant = $this->request->getGet('etudiant');
        $matiere = $this->request->getGet('matiere');
        $semestre = $this->request->getGet('semestre');        

        $notes = $noteModel->getNotesWithInfos($etudiant, $matiere, $semestre);
        $pager = $noteModel->pager;

        return view('note/index', [
            'title' => 'SysInfo — Note',
            'notes' => $notes,
            'pager'  => $pager,
            'etudiant' => $etudiant,
            'matiere' => $matiere,
            'semestre' => $semestre
        ]);
    }

    public function delete($id)
    {
        $noteModel = new NoteModel();

        // vérifier si note exist
        $note = $noteModel->find($id);

        if (!$note) {
            return redirect()->to('/notes')->with('error', 'Note introuvable');
        }

        $noteModel->delete($id);

        return redirect()->to('/notes')->with('success', 'Note supprimé avec succès');
    }

    public function form()
    {
        return view('note/form', [
            'title' => 'SysInfo — Formulaire utilisateur'
        ]);
    }
}