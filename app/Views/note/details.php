<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <div class="page-header">
        <div>
            <h2>Details de note</h2>
            <div class="breadcrumb">Accueil / Notes / <span>Details</span></div>
        </div>
    </div>

    <?php
        $formatNote = static function ($value) {
            if ($value === null) {
                return '-';
            }

            $formatted = number_format((float) $value, 2, ',', '');
            $formatted = rtrim($formatted, '0');
            $formatted = rtrim($formatted, ',');

            return $formatted;
        };
    ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-info">
            <span><?= esc($error) ?></span>
        </div>
    <?php else: ?>
        <div class="table-card" style="margin-bottom:16px;">
            <div style="padding:16px;display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                <div>
                    <div style="font-weight:600;"><?= esc($etudiant['nom'] ?? '') ?> <?= esc($etudiant['prenom'] ?? '') ?></div>
                    <div style="font-size:12px;color:var(--c-muted)">N inscription: <?= esc($etudiant['num_inscription'] ?? '') ?></div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:12px;color:var(--c-muted)">Detail</div>
                    <div style="font-weight:600;"><?= esc($scope['label']) ?></div>
                </div>
            </div>
        </div>

        <?php foreach ($details_semestres as $detail): ?>
            <div class="table-card" style="margin-bottom:18px;">
                <table>
                    <thead>
                        <tr>
                            <th>UE</th>
                            <th>Intitule</th>
                            <th>Credits</th>
                            <th>Note/20</th>
                            <th>Resultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail['summary']['matieres'] as $matiere): ?>
                            <?php
                                $noteDisplay = $formatNote($matiere['note']);
                                $resultDisplay = $matiere['resultat'] === '' ? '-' : $matiere['resultat'];
                            ?>
                            <tr>
                                <td><?= esc($matiere['ue']) ?></td>
                                <td><?= esc($matiere['intitule']) ?></td>
                                <td><?= esc($matiere['credits']) ?></td>
                                <td><?= esc($noteDisplay) ?></td>
                                <td><?= esc($resultDisplay) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php
                            $summary = $detail['summary'];
                            $moyenneDisplay = $formatNote($summary['moyenne']);
                            $mentionDisplay = $summary['mention'] === '' ? '-' : $summary['mention'];
                        ?>
                        <tr>
                            <td colspan="2" style="font-weight:600;">
                                <?= esc($detail['titre']) ?>
                            </td>
                            <td style="font-weight:600;">
                                <?= esc($summary['credits_total']) ?>
                            </td>
                            <td style="font-weight:600;">
                                <?= esc($moyenneDisplay) ?>
                            </td>
                            <td style="font-weight:600;">
                                <?= esc($mentionDisplay) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="padding:12px 16px;display:flex;gap:16px;flex-wrap:wrap;color:var(--c-muted);font-size:12px;">
                    <div>Credits gagnes: <strong><?= esc($summary['credits_gagnes']) ?></strong></div>
                    <div>Resultat semestre: <strong><?= esc($summary['resultat'] === '' ? '-' : $summary['resultat']) ?></strong></div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if ($classe_summary !== null): ?>
            <?php
                $moyenneDisplay = $formatNote($classe_summary['moyenne']);
                $mentionDisplay = $classe_summary['mention'] === '' ? '-' : $classe_summary['mention'];
                $resultatDisplay = $classe_summary['resultat'] === '' ? '-' : strtoupper($classe_summary['resultat']);
            ?>
            <div class="table-card">
                <div style="padding:16px;display:grid;gap:6px;max-width:420px;">
                    <div style="font-weight:600;">Resultat</div>
                    <div>Credits: <strong><?= esc($classe_summary['credits_total']) ?></strong></div>
                    <div>Moyenne generale: <strong><?= esc($moyenneDisplay) ?></strong></div>
                    <div>Mention: <strong><?= esc($mentionDisplay) ?></strong></div>
                    <div style="font-weight:700;letter-spacing:0.4px;">
                        <?= esc($resultatDisplay) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?= $this->endSection() ?>
