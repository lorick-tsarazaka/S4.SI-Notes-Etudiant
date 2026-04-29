<?php

namespace App\Controllers;

use Config\Database;
use App\Models\NoteModel;

class NoteController extends BaseController
{
    public function form()
    {
        return view('note/form', [
            'title' => 'SysInfo — Formulaire utilisateur'
        ]);
    }
}