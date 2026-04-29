<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <div class="page-header">
        <div>
            <h2>Ajouter des notes</h2>
            <div class="breadcrumb">Accueil / Notes / <span>Ajout</span></div>
        </div>
        <a href="<?= base_url('/notes') ?>" class="btn btn-secondary btn-sm">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Retour
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-info">
            <span><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
    <?php endif; ?>

    <?php
        $etudiantsList = $etudiants ?? [];
        $matieresList = $matieres ?? [];
        $matieresBySemestre = [];
        foreach ($matieresList as $matiere) {
            $semestreNom = $matiere['semestre_nom'] ?? 'Semestre';
            $matieresBySemestre[$semestreNom][] = $matiere;
        }
        $selectedEtudiant = old('etudiant_id');
        $defaultEtudiantId = '';
        foreach ($etudiantsList as $etudiant) {
            $row = (array) $etudiant;
            $defaultEtudiantId = (string) ($row['id'] ?? '');
            break;
        }
    ?>

    <form method="post" action="<?= base_url('/note/store') ?>">
        <?= csrf_field() ?>

        <div class="form-card section-gap">
            <div class="form-section-title">1. Etudiant</div>
            <div class="form-grid">
                <div>
                    <label class="field-label">Etudiant <span class="required">*</span></label>
                    <select name="etudiant_id" required>
                        <option value="">— Selectionner —</option>
                        <?php foreach ($etudiantsList as $etudiant): ?>
                            <?php $row = (array) $etudiant; ?>
                            <?php
                                $etudiantId = (string) $row['id'];
                                $isSelected = $selectedEtudiant !== ''
                                    ? $selectedEtudiant === $etudiantId
                                    : $defaultEtudiantId === $etudiantId;
                            ?>
                            <option value="<?= esc($etudiantId) ?>" <?= $isSelected ? 'selected' : '' ?>>
                                <?= esc($row['num_inscription']) ?> — <?= esc($row['nom']) ?> <?= esc($row['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card section-gap">
            <div class="form-section-title">2. Notes</div>
            <div class="field-hint">Vous pouvez ajouter plusieurs notes pour le meme etudiant.</div>

            <div class="table-card" style="margin-top:14px;">
                <table id="notes-table">
                    <thead>
                        <tr>
                            <th>Matiere</th>
                            <th style="width:160px;">Note /20</th>
                            <th style="width:72px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="note-row">
                            <td>
                                <select name="matiere_id[]" required>
                                    <option value="">— Selectionner —</option>
                                    <?php foreach ($matieresBySemestre as $semestreNom => $matieresItems): ?>
                                        <optgroup label="<?= esc($semestreNom) ?>">
                                            <?php foreach ($matieresItems as $matiere): ?>
                                                <option value="<?= esc($matiere['id']) ?>">
                                                    <?= esc($matiere['ue']) ?> — <?= esc($matiere['intitule']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="note_valeur[]" min="0" max="20" step="0.25" value="10" required />
                            </td>
                            <td style="text-align:center;">
                                <button class="action-btn remove-note" type="button" title="Supprimer">
                                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:12px;display:flex;gap:10px;">
                <button type="button" class="btn btn-secondary btn-sm" id="add-note">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Ajouter une note
                </button>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Enregistrer
            </button>
        </div>
    </form>

    <script>
        const notesTable = document.getElementById('notes-table');
        const addButton = document.getElementById('add-note');

        const bindRemoveButtons = () => {
            notesTable.querySelectorAll('.remove-note').forEach((button) => {
                button.onclick = () => {
                    const rows = notesTable.querySelectorAll('.note-row');
                    if (rows.length <= 1) {
                        return;
                    }
                    const row = button.closest('.note-row');
                    if (row) {
                        row.remove();
                    }
                };
            });
        };

        bindRemoveButtons();

        if (addButton) {
            addButton.addEventListener('click', () => {
            const row = notesTable.querySelector('.note-row');
            if (!row) {
                return;
            }

            const clone = row.cloneNode(true);
            const select = clone.querySelector('select');
            const input = clone.querySelector('input');
            if (select) {
                select.selectedIndex = 0;
            }
            if (input) {
                input.value = '10';
            }
            const tbody = notesTable.querySelector('tbody');
            if (tbody) {
                tbody.appendChild(clone);
            }
            bindRemoveButtons();
            });
        }
    </script>

<?= $this->endSection() ?>