
-------- PLAN -----------
# NB: IL FAUT MORCELER LES TACHES A FAIRE POUR AVANCER SUREMENT ET LENTEMENT
# MM S'IL FAUT EFFECTUER DES PETITS COMMITS. POUR MIEUX COMPRENDRE LE CHEMINEMENT DU PROJET
<!-- - creer la db (MCD, MLD) -->
<!-- - creer les entity dans la db avec doctrine -->
<!-- - ajout d'un utilisateur dans la db et le configurer dans symfony (pour l'inscription) -->
# -------------------------- A FAIRE ------------------------------ #
- commiter le feat/contact
- configuer l'autentification 
- configurer la connexion
- mettre en place la deconnexion
- effectuer l'ajax sur les links restants (profile, messages, settings)
# --------------------------------------------------------------------------- #
- configuration de la homepage
- creation des routes de la homepage
# --- #
- dans le controller home, on y met toutes les routes de la slide bar, et a chaque requette on recuperer les donneer pour les traiter dans une vue twig avant de les afficher dans le dom.
- creer un controller message qui va afficher les message de discutions, lorsqu'on click sur le user dans la partie message
# --- #
- affichage des contacts
# NB: afficher tous les contact sauf le tien 

- ajout de champs dans users pour l'image du profile et le back
- ajouter l'upload d'image dans l'inscription
- pour l'image back on mettra une image par defaut c'est a la connexion que le user pourra modifier l'image
- y afficher les users
- afficher les users dans la parties contact
- ajouter la fonctionnality de la recherche sur les contact avec l'ajax (jquery)
- stocker les messaes envoyer par les users dans la tables messages
- puis afficher les message text envoyer par chaque user dans le chat
- mettre en place les messages audio
# NB: utiliser wavesurfer pour la lecture des audios link: https://wavesurfer-js.org/api/index.html
- l'envoie d'image
- ajouter la fonctinnalite de suppression des messages
# NB: creer un controller pour la homepage et effectuer des requettes an AXAJ pour la recuperation des donnees
----- a la fin du projet -----------
- watch grafikart video to understand serialisation and connexion fonctionnalities


-------- A FAIRE INSHALLAH -----------


- ajouter dans un champs de modification de la description du user dans setting
- effectuer le triage alphabetique sur les contacts


-------------------- fonctionnalities -----------------------------
audio send, emettre un son lors de l'envoie ou reception du message
image send
capable to download an image or delete it from messages

----------------- En attante -----------------------------
- ajouter envoie audio
- possibilite de supprimer un message dans le chat

<!-- --------------------- creation des entitees ---------------------
- users et users_deleted => relation manyTOmany et aussi users_blocked
# NB: lors de l'insertion des donnees dans la tables users_deleted :
- le fk(user_deleted) ne sera pas lier a la table users, les donnees seront ajouter manuelement
pour que la recuperation des users soit plus facile.
- mais user_deleting_id sera utiliser comme relation manyTOmany

- users et messages => relation manyTOone
# NB: la fk sera dans messages (sender_id)
et recepient_id sera ajouter manuellement

# NB: dans les tables generer par doctrine:
- dans les tables de liaison manyTOmany (deleted et blocked), celui qui delete ou block est le 2em champs (users_id)
- donc lors d'ajout dans les tables originelles (deleted et blocked) on ajoute que le user qui a ete blocked ou deleted -->