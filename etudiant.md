- sur sidebar :
    - navigation :
        - ajoute lien etudiant -> liste-etudiants

- renomme etudiant/index.php en etudiant/listes.php et dedans:
    - div recherche :
        - input recherche (num_inscription , nom , prenom)
        - btn filtrer

    - tableau :
        - colonnes :
            - N* inscription
            - Nom et prenoms
            - Date et lieu naissance
            - action:
                - fleche deroulante 
        - si on clique sur une ligne de etudiant sur la table :
            - un accordions s'ouvre et dedans :
                la liste de ces notes (table col : intitule , notes , resulat , action : (voir + icone))
                    exemples :
                        S3
                        S4 option dev
                        S4 option bddres
                        S4 option web
                        L2 option dev (S3 & S4 option dev)
                        L2 option bddres (S3 & S4 option bddres)
                        L2 option web (S3 & S4 option web)


NB : pour l'instant fixe d'abord  dans controller les valeurs (n'utilise pas encore les models)