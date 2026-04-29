# Objectif : Gestiond des notes etudiants

>> 1 - Creer database:
   - Creer database tp_note:
    . table user (idU , nom, password, role)
    . classe (idC, nom)
    . Option (idO, nom)
    . Semestre (idS, nom, idC(foreign key classe.idC), idO(foreign key Option.idO)) 
    . Creer table etudiant(idE, nom, etu , prenom, date_naissance, lieu de naissance , idC(foreign key classe.idC) )
    . Creer table matiere(idM, nom, description, coefficient, credits, idS(foreign key Semestre.idS), )
    . note (idN, idE , idS , idM, valeur)
    . Resultat (idR, valeur, idE)

>> 2 - Creation element CodeIgniter :
   - Creation des models + methodes:
        . UserModel : 
            . Authentification()
        . EtudiantModel : 
            . findAll()
            . getById(idE) 
            

        . MatiereModel : 
            . findAll()
            . getById(id)
            . getMatiereParSemestre(idS)
            . getMatiereParClasse(idC)

        . NoteModel :
            . InsertNote(idE, note, idS, idM)
            . deleteNote(idNote)
            . updateNote(idNote, note)
            . getNoteByClasse(idE, idC)
            . getNoteByOption(idE, idS)
            . getNoteMaxParMatiereOptionnel(idO, idE)
            . CalculerMoyenneSemestre(idE, idS)
        
    - Creation des controllers:
        . AuthController 
        . EtudiantController
        . MatiereController
        . NoteController

>> 3 - Introduction du template :
   - Associer le template avec CodeIgniter

>> 4 - Creation du login :
   - Creer des inputs : nom + mdp
   - Creer bouton valider
   - Envoyer la requete vers AuthController

>> 5 -Creer pages note: 
   - Creer un crud pour note : 
        . Listes notes:
            - etudiant (etu & nom prenom)
            - semestre
            - matiere
            - notes
        . Create : (form)
            ajouter des inputs pour Etudiant + note + matiere + semestres
            ajouter un bouton inserer
        . Delete :
            ajouter des inputs pour Etudiant + note + matiere + semestres
            ajouter un bouton delete
        . Update : (form)
        
>> 6 - Creer un page liste etudiant :
    - Afficher la liste des etudiants 
    - Ajouter a chaque liste des liens pour acceder a leur note :
            . S3
            . S4 option dev
            . S4 option bddres
            . S4 option web
            . L2 option dev
            . L2 option bddres
            . L2 option web
    - Associer chaque lien au methode dans EtudiantModel + NoteModel

 
        

    