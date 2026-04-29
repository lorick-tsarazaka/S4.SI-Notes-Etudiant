<?php

namespace App\Controllers;

use App\Libraries\NoteCalculator;
use App\Models\EtudiantModel;
use App\Models\GroupeOptionnelModel;
use App\Models\MatiereModel;
use App\Models\NoteModel;
use App\Models\SemestreModel;

class NoteController extends BaseController
{
    public function form()
    {
        $etudiantModel = new EtudiantModel();
        $matiereModel = new MatiereModel();

        return view('note/form', [
            'title' => 'SysInfo — Ajouter une note',
            'etudiants' => $etudiantModel->findAll(),
            'matieres' => $matiereModel->getMatieresWithSemestre(),
        ]);
    }

    public function index()
    {
        $noteModel = new NoteModel();

        $perPage = 10;
        $notes = $noteModel->getPagedWithRelations($perPage);

        return view('note/index', [
            'title' => 'SysInfo — Notes',
            'notes' => $notes,
            'pager' => $noteModel->pager,
        ]);
    }

    public function store()
    {
        $etudiantId = (int) $this->request->getPost('etudiant_id');
        $matieres = (array) $this->request->getPost('matiere_id');
        $notes = (array) $this->request->getPost('note_valeur');

        if ($etudiantId === 0 || empty($matieres)) {
            return redirect()->back()->with('error', 'Veuillez renseigner toutes les notes.')->withInput();
        }

        $matiereModel = new MatiereModel();
        $noteModel = new NoteModel();

        $matiereRows = $matiereModel->getMatieresWithSemestre();
        $matiereMap = [];
        foreach ($matiereRows as $matiere) {
            $matiereMap[(int) $matiere['id']] = (int) $matiere['id_semestre'];
        }

        $inserted = 0;
        foreach ($matieres as $index => $matiereId) {
            $matiereId = (int) $matiereId;
            if ($matiereId === 0 || !isset($matiereMap[$matiereId])) {
                continue;
            }

            $valeur = isset($notes[$index]) ? (float) $notes[$index] : null;
            if ($valeur === null || $valeur < 0 || $valeur > 20) {
                continue;
            }

            $noteModel->insert([
                'id_etudiant' => $etudiantId,
                'id_matiere' => $matiereId,
                'id_semestre' => $matiereMap[$matiereId],
                'valeur' => $valeur,
            ]);
            $inserted++;
        }

        if ($inserted === 0) {
            return redirect()->back()->with('error', 'Aucune note valide n\'a ete ajoutee.')->withInput();
        }

        return redirect()->to('/notes')->with('success', 'Notes ajoutees avec succes.');
    }

    public function edit(int $id)
    {
        $noteModel = new NoteModel();
        $etudiantModel = new EtudiantModel();
        $matiereModel = new MatiereModel();

        $note = $noteModel->getByIdWithRelations($id);
        if ($note === null) {
            return redirect()->to('/notes')->with('error', 'Note introuvable.');
        }

        return view('note/edit', [
            'title' => 'SysInfo — Modifier une note',
            'note' => $note,
            'etudiants' => $etudiantModel->findAll(),
            'matieres' => $matiereModel->getMatieresWithSemestre(),
        ]);
    }

    public function update(int $id)
    {
        $noteModel = new NoteModel();
        $etudiantId = (int) $this->request->getPost('etudiant_id');
        $matiereId = (int) $this->request->getPost('matiere_id');
        $valeur = $this->request->getPost('note_valeur');

        if ($etudiantId === 0 || $matiereId === 0 || $valeur === null) {
            return redirect()->back()->with('error', 'Veuillez renseigner tous les champs.')->withInput();
        }

        $valeur = (float) $valeur;
        if ($valeur < 0 || $valeur > 20) {
            return redirect()->back()->with('error', 'La note doit etre entre 0 et 20.')->withInput();
        }

        $matiereModel = new MatiereModel();
        $matiereRows = $matiereModel->getMatieresWithSemestre();
        $matiereMap = [];
        foreach ($matiereRows as $matiere) {
            $matiereMap[(int) $matiere['id']] = (int) $matiere['id_semestre'];
        }

        if (!isset($matiereMap[$matiereId])) {
            return redirect()->back()->with('error', 'Matiere introuvable.')->withInput();
        }

        $updated = $noteModel->update($id, [
            'id_etudiant' => $etudiantId,
            'id_matiere' => $matiereId,
            'id_semestre' => $matiereMap[$matiereId],
            'valeur' => $valeur,
        ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Mise a jour impossible.')->withInput();
        }

        return redirect()->to('/notes')->with('success', 'Note mise a jour.');
    }

    public function delete(int $id)
    {
        $noteModel = new NoteModel();
        $noteModel->delete($id);

        return redirect()->to('/notes')->with('success', 'Note supprimee.');
    }

    public function details()
    {
        $etudiantId = (int) $this->request->getGet('etudiant');
        $scopeCode = (string) $this->request->getGet('scope');

        $etudiantModel = new EtudiantModel();
        $semestreModel = new SemestreModel();
        $matiereModel = new MatiereModel();
        $noteModel = new NoteModel();
        $groupeModel = new GroupeOptionnelModel();

        $etudiant = $etudiantId > 0 ? $etudiantModel->getById($etudiantId) : null;
        if (!$etudiant) {
            return view('note/details', [
                'title' => 'SysInfo — Note details',
                'error' => 'Etudiant introuvable',
            ]);
        }

        $scope = null;
        $scopeList = NoteCalculator::getScopesFromSemestres($semestreModel->getAllWithOptionAndClasse());
        foreach ($scopeList as $item) {
            if ($item['code'] === $scopeCode) {
                $scope = $item;
                break;
            }
        }

        if ($scope === null) {
            return view('note/details', [
                'title' => 'SysInfo — Note details',
                'error' => 'Detail non disponible',
            ]);
        }

        $semestreRows = $semestreModel->getByNames($scope['semestres']);
        $semestreMap = [];
        $semestreIds = [];
        foreach ($semestreRows as $row) {
            $semestreMap[$row['nom']] = $row;
            $semestreIds[] = $row['id'];
        }

        $matiereRows = $matiereModel->getMatieresBySemestreIds($semestreIds);
        $matieresBySemestre = [];
        foreach ($matiereRows as $matiere) {
            $matieresBySemestre[$matiere['id_semestre']][] = $matiere;
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

        $detailsSemestres = [];
        $summaryList = [];
        foreach ($scope['semestres'] as $nomSemestre) {
            if (!isset($semestreMap[$nomSemestre])) {
                continue;
            }

            $semestre = $semestreMap[$nomSemestre];
            $matiereList = $matieresBySemestre[$semestre['id']] ?? [];
            $matiereIds = array_column($matiereList, 'id');
            $bestNotes = $noteModel->getMaxNotesByEtudiantAndMatieres((int) $etudiantId, $matiereIds);
            $optionalGroups = $optionalGroupsBySemestre[$semestre['id']] ?? [];
            $summary = NoteCalculator::computeSemestreSummary($matiereList, $bestNotes, $optionalGroups);

            $summaryList[] = $summary;
            $detailsSemestres[] = [
                'nom' => $nomSemestre,
                'titre' => $this->formatSemestreTitle($nomSemestre, $scope['label']),
                'summary' => $summary,
            ];
        }

        $classeSummary = null;
        if ($scope['type'] === 'classe') {
            $classeSummary = NoteCalculator::computeClasseSummary($summaryList);
        }

        return view('note/details', [
            'title' => 'SysInfo — Note details',
            'etudiant' => (array) $etudiant,
            'scope' => $scope,
            'details_semestres' => $detailsSemestres,
            'classe_summary' => $classeSummary,
        ]);
    }

    private function formatSemestreTitle(string $nom, string $scopeLabel): string
    {
        $optionSuffix = $this->extractOptionSuffix($scopeLabel);

        if ($nom === 'S3') {
            return $optionSuffix === '' ? 'SEMESTRE 3' : 'SEMESTRE 3 - option ' . $optionSuffix;
        }
        if (strpos($nom, 'S4') === 0) {
            return $optionSuffix === '' ? 'SEMESTRE 4' : 'SEMESTRE 4 - option ' . $optionSuffix;
        }

        return $nom;
    }

    private function extractOptionSuffix(string $label): string
    {
        $pos = strpos($label, 'option ');
        if ($pos === false) {
            return '';
        }

        $suffix = substr($label, $pos + 7);
        $suffix = trim($suffix);
        $parenPos = strpos($suffix, '(');
        if ($parenPos !== false) {
            $suffix = trim(substr($suffix, 0, $parenPos));
        }

        return $suffix;
    }
}