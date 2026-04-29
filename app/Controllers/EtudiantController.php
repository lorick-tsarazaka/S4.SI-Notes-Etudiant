<?php

namespace App\Controllers;

use Config\Database;
use App\Models\EtudiantModel;

class EtudiantController extends BaseController
{
    public function index()
    {
        return view('etudiant/index', [
            'title' => 'SysInfo — Etudiant'
        ]);
    }
}