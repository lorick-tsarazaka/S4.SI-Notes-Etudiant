<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <?php
        $matieresList = $matieres ?? [];
        $matieresBySemestre = [];
        foreach ($matieresList as $matiere) {
            $semestreNom = $matiere['semestre_nom'] ?? 'Semestre';
            $matieresBySemestre[$semestreNom][] = $matiere;
        }
    ?>

    <div class="page-header">
        <div>
            <h2>Modifier une note</h2>
            <div class="breadcrumb">Accueil / Notes / <span>Modification</span></div>
        </div>
        <a href="<?= base_url('/notes') ?>" class="btn btn-secondary btn-sm">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Retour
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <span><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('/note/update/' . $note['id']) ?>">
        <?= csrf_field() ?>

        <div class="form-card section-gap">
            <div class="form-section-title">1. Etudiant</div>
            <div class="form-grid">
                <div>
                    <label class="field-label">Etudiant <span class="required">*</span></label>
                    <select name="etudiant_id" required>
                        <option value="">— Selectionner —</option>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <?php $row = (array) $etudiant; ?>
                            <option value="<?= esc($row['id']) ?>" <?= (string) $note['id_etudiant'] === (string) $row['id'] ? 'selected' : '' ?>>
                                <?= esc($row['num_inscription']) ?> — <?= esc($row['nom']) ?> <?= esc($row['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-card section-gap">
            <div class="form-section-title">2. Matiere et note</div>
            <div class="form-grid">
                <div>
                    <label class="field-label">Matiere <span class="required">*</span></label>
                    <select name="matiere_id" required>
                        <option value="">— Selectionner —</option>
                        <?php foreach ($matieresBySemestre as $semestreNom => $matieresItems): ?>
                            <optgroup label="<?= esc($semestreNom) ?>">
                                <?php foreach ($matieresItems as $matiere): ?>
                                    <option value="<?= esc($matiere['id']) ?>" <?= (string) $note['id_matiere'] === (string) $matiere['id'] ? 'selected' : '' ?>>
                                        <?= esc($matiere['ue']) ?> — <?= esc($matiere['intitule']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="field-label">Note /20 <span class="required">*</span></label>
                    <input type="number" name="note_valeur" min="0" max="20" step="0.25" value="<?= esc($note['valeur']) ?>" required />
                </div>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Enregistrer
            </button>
        </div>
    </form>

<?= $this->endSection() ?>
