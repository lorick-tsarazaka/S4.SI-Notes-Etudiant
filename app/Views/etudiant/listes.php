<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <div class="page-header">
        <div>
            <h2>Liste des etudiants</h2>
            <div class="breadcrumb">Accueil / <span>Etudiants</span></div>
        </div>
        <div style="display:flex;gap:10px">
            <button class="btn btn-secondary btn-sm">
            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Exporter
            </button>
        </div>
    </div>

    <div class="toolbar">
        <div class="toolbar-left" style="gap:12px;align-items:center">
            <div class="search-box">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="Rechercher par N inscription, nom, prenom" />
            </div>
            <button class="btn btn-primary btn-sm">Filtrer</button>
        </div>
    </div>

    <div class="table-card">
    <table>
        <thead>
        <tr>
            <th class="sortable">N inscription</th>
            <th class="sortable">Nom et prenoms</th>
            <th>Date et lieu naissance</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($etudiants as $index => $etudiant): ?>
        <tr class="etudiant-row" data-row="notes-<?= $index ?>">
            <td style="color:var(--c-muted);font-family:monospace"><?= esc($etudiant['num_inscription']) ?></td>
            <td>
            <div style="font-weight:600"><?= esc($etudiant['nom']) ?> <?= esc($etudiant['prenom']) ?></div>
            </td>
            <td>
            <div><?= esc($etudiant['date_naissance']) ?></div>
            <div style="font-size:11px;color:var(--c-muted)"><?= esc($etudiant['lieu_naissance']) ?></div>
            </td>
            <td>
            <button class="action-btn" type="button" data-toggle="notes-<?= $index ?>" title="Ouvrir">
                <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            </td>
        </tr>
        <tr class="etudiant-notes-row" id="notes-<?= $index ?>" style="display:none;">
            <td colspan="4">
            <div class="notes-table">
                <table>
                    <thead>
                    <tr>
                        <th>Intitule</th>
                        <th>Notes</th>
                        <th>Resultat</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($etudiant['notes_resume'] as $note): ?>
                    <?php
                        $noteValue = $note['note'];
                        $noteDisplay = $noteValue === null ? '-' : number_format($noteValue, 2);
                    ?>
                    <tr>
                        <td><?= esc($note['intitule']) ?></td>
                        <td><?= esc($noteDisplay) ?></td>
                        <td><?= esc($note['resultat']) ?></td>
                        <td>
                        <a class="action-btn action-link" href="<?= base_url('/note-details') ?>" title="Voir">
                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <style>
        .etudiant-row {
            cursor: pointer;
        }

        .etudiant-row.is-open {
            background: #f8fafc;
        }

        .etudiant-notes-row {
            background: #f8fafc;
        }

        .notes-table table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .notes-table th,
        .notes-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
    </style>

    <script>
        document.querySelectorAll('.etudiant-row').forEach((row) => {
            const targetId = row.getAttribute('data-row');
            const detailRow = document.getElementById(targetId);

            if (!detailRow) {
                return;
            }

            const toggle = () => {
                const isOpen = detailRow.style.display === 'table-row';
                detailRow.style.display = isOpen ? 'none' : 'table-row';
                row.classList.toggle('is-open', !isOpen);
            };

            row.addEventListener('click', (event) => {
                if (event.target.closest('button')) {
                    return;
                }
                toggle();
            });

            const button = row.querySelector('[data-toggle]');
            if (button) {
                button.addEventListener('click', (event) => {
                    event.stopPropagation();
                    toggle();
                });
            }
        });
    </script>

<?= $this->endSection() ?>