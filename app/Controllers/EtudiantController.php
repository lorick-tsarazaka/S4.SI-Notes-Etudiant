<?php

namespace App\Controllers;

class EtudiantController extends BaseController
{
    public function index()
    {
        return $this->listes();
    }

    public function listes()
    {
        $resumeBase = [
            ['intitule' => 'S3', 'note' => 11.24],
            ['intitule' => 'S4 option dev', 'note' => 12.35],
            ['intitule' => 'S4 option bddres', 'note' => 10.8],
            ['intitule' => 'S4 option web', 'note' => 13.1],
            ['intitule' => 'L2 option dev (S3 & S4 option dev)', 'note' => 12.05],
            ['intitule' => 'L2 option bddres (S3 & S4 option bddres)', 'note' => 11.4],
            ['intitule' => 'L2 option web (S3 & S4 option web)', 'note' => 12.8],
        ];

        $etudiantsBase = [
            [
                'num_inscription' => 'ETU002369',
                'nom' => 'Rakoto',
                'prenom' => 'Andry',
                'date_naissance' => '2004-05-12',
                'lieu_naissance' => 'Antananarivo',
            ],
            [
                'num_inscription' => 'ETU002587',
                'nom' => 'Razafy',
                'prenom' => 'Fanja',
                'date_naissance' => '2004-09-03',
                'lieu_naissance' => 'Antsirabe',
            ],
            [
                'num_inscription' => 'ETU002356',
                'nom' => 'Ranaivo',
                'prenom' => 'Hery',
                'date_naissance' => '2004-02-21',
                'lieu_naissance' => 'Toamasina',
            ],
            [
                'num_inscription' => 'ETU003122',
                'nom' => 'Rabenja',
                'prenom' => 'Lalao',
                'date_naissance' => '2004-11-18',
                'lieu_naissance' => 'Mahajanga',
            ],
            [
                'num_inscription' => 'ETU002467',
                'nom' => 'Tsarafidy',
                'prenom' => 'Miora',
                'date_naissance' => '2004-07-27',
                'lieu_naissance' => 'Fianarantsoa',
            ],
        ];

        $etudiants = [];
        foreach ($etudiantsBase as $index => $etudiant) {
            $notesResume = [];
            foreach ($resumeBase as $row) {
                $noteValue = round($row['note'] + ($index * 0.18), 2);
                $notesResume[] = [
                    'intitule' => $row['intitule'],
                    'note' => $noteValue,
                    'resultat' => $noteValue >= 10 ? 'Passable' : 'Non valide',
                ];
            }

            $etudiant['notes_resume'] = $notesResume;
            $etudiants[] = $etudiant;
        }

        return view('etudiant/listes', [
            'title' => 'SysInfo — Etudiants',
            'etudiants' => $etudiants,
        ]);
    }
}