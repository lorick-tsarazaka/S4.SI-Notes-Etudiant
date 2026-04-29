<?php

namespace App\Controllers;

use App\Libraries\NoteCalculator;
use App\Models\EtudiantModel;
use App\Models\GroupeOptionnelModel;
use App\Models\MatiereModel;
use App\Models\NoteModel;
use App\Models\SemestreModel;

class EtudiantController extends BaseController
{
    public function index()
    {
        return $this->listes();
    }

    public function listes()
    {
        $etudiantModel = new EtudiantModel();
        $semestreModel = new SemestreModel();
        $matiereModel = new MatiereModel();
        $noteModel = new NoteModel();
        $groupeModel = new GroupeOptionnelModel();

        $scopes = NoteCalculator::getScopesFromSemestres($semestreModel->getAllWithOptionAndClasse());
        $semestreNames = [];
        foreach ($scopes as $scope) {
            foreach ($scope['semestres'] as $nomSemestre) {
                $semestreNames[$nomSemestre] = true;
            }
        }

        $semestreRows = $semestreModel->getByNames(array_keys($semestreNames));
        $semestreMap = [];
        $semestreIds = [];
        foreach ($semestreRows as $row) {
            $semestreMap[$row['nom']] = $row;
            $semestreIds[] = $row['id'];
        }

        $matieres = $matiereModel->getMatieresBySemestreIds($semestreIds);
        $matieresBySemestre = [];
        $allMatiereIds = [];
        foreach ($matieres as $matiere) {
            $matieresBySemestre[$matiere['id_semestre']][] = $matiere;
            $allMatiereIds[] = $matiere['id'];
        }

        $groupRows = $groupeModel->getGroupsBySemestreIds($semestreIds);
        $groupIds = array_column($groupRows, 'id');
        $groupMatieresMap = $groupeModel->getGroupMatieresMap($groupIds);
        $optionalGroupsBySemestre = [];
        foreach ($groupRows as $group) {
            $semestreId = (int) $group['id_semestre'];
            $optionalGroupsBySemestre[$semestreId][] = [
                'id' => (int) $group['id'],
                'credits' => (int) $group['credits'],
                'matiere_ids' => $groupMatieresMap[(int) $group['id']] ?? [],
            ];
        }

        $etudiantsRaw = $etudiantModel->findAll();
        $etudiants = [];
        foreach ($etudiantsRaw as $etudiantRaw) {
            $etudiant = (array) $etudiantRaw;
            $bestNotes = $noteModel->getMaxNotesByEtudiantAndMatieres((int) $etudiant['id'], $allMatiereIds);
            $semestreSummaries = [];

            foreach ($semestreMap as $nom => $semestre) {
                $matiereList = $matieresBySemestre[$semestre['id']] ?? [];
                $optionalGroups = $optionalGroupsBySemestre[$semestre['id']] ?? [];
                $semestreSummaries[$nom] = NoteCalculator::computeSemestreSummary($matiereList, $bestNotes, $optionalGroups);
            }

            $notesResume = [];
            foreach ($scopes as $scope) {
                if ($scope['type'] === 'semestre') {
                    $summary = $semestreSummaries[$scope['semestres'][0]]
                        ?? NoteCalculator::computeSemestreSummary([], [], []);
                } else {
                    $summaryList = [];
                    foreach ($scope['semestres'] as $nomSemestre) {
                        $summaryList[] = $semestreSummaries[$nomSemestre]
                            ?? NoteCalculator::computeSemestreSummary([], [], []);
                    }
                    $summary = NoteCalculator::computeClasseSummary($summaryList);
                }

                $notesResume[] = [
                    'code' => $scope['code'],
                    'intitule' => $scope['label'],
                    'note' => $summary['moyenne'],
                    'resultat' => $summary['mention'],
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