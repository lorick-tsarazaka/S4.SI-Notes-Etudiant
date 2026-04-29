<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <div class="page-header">
        <div>
            <h2>Liste des Notes</h2>
            <div class="breadcrumb">Accueil / <span>Utilisateurs</span></div>
        </div>
        <div style="display:flex;gap:10px">
            <button class="btn btn-secondary btn-sm">
                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Exporter
            </button>
            <a href="form.html" class="btn btn-primary btn-sm">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nouvelle note
            </a>
        </div>
    </div>

    <!-- Toolbar filtres -->
    <form action="<?= base_url('/notes') ?>" method="get">
        <div class="toolbar">
            <?= csrf_field() ?>

            <div class="toolbar-left">
                <div class="search-box">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="etudiant" placeholder="Rechercher par numero inscription" value="<?= esc($_GET['etudiant'] ?? '') ?>" />
                </div>
                <select class="filter-select">
                    <option>Tous les rôles</option>
                    <option>Administrateur</option>
                    <option>Gestionnaire</option>
                    <option>Opérateur</option>
                    <option>Auditeur</option>
                </select>
                <select class="filter-select">
                    <option>Tous les statuts</option>
                    <option>Actif</option>
                    <option>Inactif</option>
                    <option>Suspendu</option>
                </select>
                <select class="filter-select">
                    <option>Département</option>
                    <option>DSI</option>
                    <option>Finance</option>
                    <option>RH</option>
                    <option>Commercial</option>
                </select>
            </div>
            <button type="submit" class="btn btn-ghost btn-sm">
                <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filtres avancés
            </button>
        </div>
    </form>

    <!-- Tableau -->
    <div class="table-card">
    <table>
        <thead>
            <tr>
                <th class="td-check"><input type="checkbox" /></th>
                <th class="sortable">Etudiant ▲</th>
                <th class="sortable">Semestre</th>
                <th class="sortable">Matière</th>
                <th class="sortable">Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($notes as $note) { ?>
                <tr>
                    <td><input type="checkbox" /></td>
                    <td style="color:var(--c-muted);font-family:monospace"><?= esc($note['etu']) ?></td>
                    <td><?= esc($note['semestre']) ?></td>
                    <td><?= esc($note['mat_intitule']) ?></td>
                    <td><?= esc($note['valeur']) ?></td>
                    <td>
                        <div class="td-actions">
                            <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                            <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
                        </div>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>

    <?= $pager->links('default', 'bootstrap_full') ?>

    </div><!-- /table-card -->

</div><!-- /content -->

<?= $this->endSection() ?>