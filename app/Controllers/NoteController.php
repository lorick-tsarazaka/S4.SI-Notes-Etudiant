<?php

namespace App\Controllers;

class NoteController extends BaseController
{
    public function form()
    {
        return view('note/form', [
            'title' => 'SysInfo — Formulaire utilisateur'
        ]);
    }

    public function details()
    {
        return view('note/details', [
            'title' => 'SysInfo — Note details'
        ]);
    }
}