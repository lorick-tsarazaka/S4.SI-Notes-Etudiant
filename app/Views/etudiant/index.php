<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <div class="page-header">
        <div>
            <h2>Liste des utilisateurs</h2>
            <div class="breadcrumb">Accueil / <span>Utilisateurs</span></div>
        </div>
        <div style="display:flex;gap:10px">
            <button class="btn btn-secondary btn-sm">
            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Exporter
            </button>
            <a href="form.html" class="btn btn-primary btn-sm">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvel utilisateur
            </a>
        </div>
    </div>

    <!-- Toolbar filtres -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="search-box">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="Rechercher un utilisateur…" />
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
        <button class="btn btn-ghost btn-sm">
            <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            Filtres avancés
        </button>
    </div>

    <!-- Tableau -->
    <div class="table-card">
    <table>
        <thead>
        <tr>
            <th class="td-check"><input type="checkbox" /></th>
            <th class="sortable">Utilisateur ▲</th>
            <th class="sortable">Matricule</th>
            <th class="sortable">Rôle</th>
            <th>Département</th>
            <th class="sortable">Dernière connexion</th>
            <th class="sortable">Statut</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td><input type="checkbox" /></td>
            <td>
            <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar-sm">AR</div>
                <div>
                <div style="font-weight:600">Andry Rakoto</div>
                <div style="font-size:11px;color:var(--c-muted)">andry.rakoto@si.mg</div>
                </div>
            </div>
            </td>
            <td style="color:var(--c-muted);font-family:monospace">USR-0041</td>
            <td><span class="badge badge-blue">Administrateur</span></td>
            <td>DSI</td>
            <td>2026-04-29 08:12</td>
            <td><span class="badge badge-green">Actif</span></td>
            <td>
            <div class="td-actions">
                <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
            </div>
            </td>
        </tr>

        <tr>
            <td><input type="checkbox" /></td>
            <td>
            <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar-sm" style="background:linear-gradient(135deg,#8b5cf6,#ec4899)">FR</div>
                <div>
                <div style="font-weight:600">Fanja Razafy</div>
                <div style="font-size:11px;color:var(--c-muted)">fanja.razafy@si.mg</div>
                </div>
            </div>
            </td>
            <td style="color:var(--c-muted);font-family:monospace">USR-0042</td>
            <td><span class="badge badge-amber">Gestionnaire</span></td>
            <td>Finance</td>
            <td>2026-04-28 17:45</td>
            <td><span class="badge badge-green">Actif</span></td>
            <td>
            <div class="td-actions">
                <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
            </div>
            </td>
        </tr>

        <tr>
            <td><input type="checkbox" /></td>
            <td>
            <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar-sm" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">HR</div>
                <div>
                <div style="font-weight:600">Hery Ranaivo</div>
                <div style="font-size:11px;color:var(--c-muted)">hery.ranaivo@si.mg</div>
                </div>
            </div>
            </td>
            <td style="color:var(--c-muted);font-family:monospace">USR-0043</td>
            <td><span class="badge badge-gray">Auditeur</span></td>
            <td>RH</td>
            <td>2026-04-25 10:00</td>
            <td><span class="badge badge-amber">Inactif</span></td>
            <td>
            <div class="td-actions">
                <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
            </div>
            </td>
        </tr>

        <tr>
            <td><input type="checkbox" /></td>
            <td>
            <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar-sm" style="background:linear-gradient(135deg,#22c55e,#06b6d4)">LR</div>
                <div>
                <div style="font-weight:600">Lalao Rabenja</div>
                <div style="font-size:11px;color:var(--c-muted)">lalao.rabenja@si.mg</div>
                </div>
            </div>
            </td>
            <td style="color:var(--c-muted);font-family:monospace">USR-0044</td>
            <td><span class="badge badge-gray">Opérateur</span></td>
            <td>Commercial</td>
            <td>2026-04-29 09:30</td>
            <td><span class="badge badge-green">Actif</span></td>
            <td>
            <div class="td-actions">
                <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
            </div>
            </td>
        </tr>

        <tr>
            <td><input type="checkbox" /></td>
            <td>
            <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar-sm" style="background:linear-gradient(135deg,#ef4444,#8b5cf6)">MT</div>
                <div>
                <div style="font-weight:600">Miora Tsarafidy</div>
                <div style="font-size:11px;color:var(--c-muted)">miora.tsarafidy@si.mg</div>
                </div>
            </div>
            </td>
            <td style="color:var(--c-muted);font-family:monospace">USR-0045</td>
            <td><span class="badge badge-amber">Gestionnaire</span></td>
            <td>DSI</td>
            <td>—</td>
            <td><span class="badge badge-red">Suspendu</span></td>
            <td>
            <div class="td-actions">
                <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
            </div>
            </td>
        </tr>

        <tr>
            <td><input type="checkbox" /></td>
            <td>
            <div style="display:flex;align-items:center;gap:10px">
                <div class="avatar-sm" style="background:linear-gradient(135deg,#06b6d4,#22c55e)">RN</div>
                <div>
                <div style="font-weight:600">Rodin Nomenjanahary</div>
                <div style="font-size:11px;color:var(--c-muted)">rodin.n@si.mg</div>
                </div>
            </div>
            </td>
            <td style="color:var(--c-muted);font-family:monospace">USR-0046</td>
            <td><span class="badge badge-blue">Administrateur</span></td>
            <td>DSI</td>
            <td>2026-04-29 07:55</td>
            <td><span class="badge badge-green">Actif</span></td>
            <td>
            <div class="td-actions">
                <button class="action-btn" title="Voir"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
                <a href="form.html" class="action-btn" title="Modifier"><svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <button class="action-btn del" title="Supprimer"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
            </div>
            </td>
        </tr>

        </tbody>
    </table>

    <div class="pagination">
        <span>Affichage de <strong>1–6</strong> sur <strong>284</strong> entrées</span>
        <div class="page-btns">
        <button class="page-btn">‹</button>
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">…</button>
        <button class="page-btn">48</button>
        <button class="page-btn">›</button>
        </div>
    </div>

    </div><!-- /table-card -->

</div><!-- /content -->

<?= $this->endSection() ?>