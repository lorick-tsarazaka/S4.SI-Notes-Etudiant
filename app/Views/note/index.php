<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

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

    <div class="page-header">
        <div>
            <h2>Liste des notes</h2>
            <div class="breadcrumb">Accueil / Notes / <span>Liste</span></div>
        </div>
        <a href="<?= base_url('/note/form') ?>" class="btn btn-primary btn-sm">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Ajouter
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

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Etudiant</th>
                    <th>Semestre</th>
                    <th>Matiere</th>
                    <th>Note/20</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($notes)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;color:var(--c-muted);padding:18px;">
                            Aucune note disponible.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($notes as $note): ?>
                        <?php
                            $etudiantLabel = trim(($note['num_inscription'] ?? '') . ' — ' . ($note['etudiant_nom'] ?? '') . ' ' . ($note['etudiant_prenom'] ?? ''));
                            $matiereLabel = trim(($note['ue'] ?? '') . ' — ' . ($note['intitule'] ?? ''));
                        ?>
                        <tr>
                            <td><?= esc($etudiantLabel) ?></td>
                            <td><?= esc($note['semestre_nom'] ?? '-') ?></td>
                            <td><?= esc($matiereLabel) ?></td>
                            <td><?= esc($formatNote($note['valeur'] ?? null)) ?></td>
                            <td>
                                <a class="action-btn action-link" href="<?= base_url('/note/edit/' . $note['id']) ?>" title="Modifier">
                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form method="post" action="<?= base_url('/note/delete/' . $note['id']) ?>" style="display:inline-flex;" onsubmit="return confirm('Supprimer cette note ?');">
                                    <?= csrf_field() ?>
                                    <button class="action-btn" type="submit" title="Supprimer">
                                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M8 6v-2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($pager)): ?>
        <div class="pager-wrap">
            <?= $pager->links('notes', 'default_full') ?>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>
