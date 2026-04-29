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

    public function form()
    {
        return view('note/form', [
            'title' => 'SysInfo — Formulaire utilisateur'
        ]);
    }
}