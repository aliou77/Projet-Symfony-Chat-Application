
-------- PLAN -----------
# NB: IL FAUT MORCELER LES TACHES A FAIRE POUR AVANCER SUREMENT ET LENTEMENT
# MM S'IL FAUT EFFECTUER DES PETITS COMMITS. POUR MIEUX COMPRENDRE LE CHEMINEMENT DU PROJET
<!-- - creer la db (MCD, MLD) -->
<!-- - creer les entity dans la db avec doctrine -->
<!-- - ajout d'un utilisateur dans la db et le configurer dans symfony (pour l'inscription) -->
# -------------------------- A FAIRE ------------------------------ #
<!-- - commiter le feat/contact -->
<!-- - configuer l'autentification  -->
<!-- - configurer la connexion -->
<!-- - mettre en place la deconnexion -->
<!-- - setup profile -->
<!-- - setup contact search -->
<!-- - setup message -->
 <!-- + apres le click sur un contact ou message on recuper le user selectionner on affiche ses infos dans la chat section et dans le modal -->
 <!-- + on envyoie les messages, on les stock en DB -->
 <!-- + on les reaffiche pour chaque user selectionnet, et on renvoie une vue en json content toutes la section message les infos du user et les messages lui concernant. -->

 <!-- - afficher les messages dans le chat instantanement -->

<!-- - mettre l'effet de chargement de page dans les requettes ajax  -->
<!-- - fix les conctacts dont l'ajax ne s'applique pas apres une recherche -->
<!-- - organiser l'affichage des error d'invalidation dans page connexion -->
<!-- - ajouter le remember me -->
# --------------------------------------------------------------------------- #
<!-- - modifier les img profile et back- utiliser fetch au lieu d'ajax
    on ne peut recuperer le tmp_path avec l'ajax donc on ne peut changer les imgs -->
<!-- - responsive de la hommepage -->
<!-- - appliquer l'effet de chargement de la discussion -->
<!-- - centrer la photo du setting -->
<!-- - modifier les touch arrow pour la navigation des tabs (up et down) -->

<!-- - afficher les discussions dans messages avec le you: ...  -->
<!-- - affiche le button online sur la section messages pour les users connectes -->
<!-- - afficher la discussion apres le click -->

<!-- - ajouter l'envoie des emoji -->
<!-- ---
129295 => main chutup #form
129354 => guan box #to
129392 => heureux glamour #form
129393, 129395, 129396, 129397, 129398, 129402, 129488,129489,   129505, 129489, 129467
--- -->
<!-- - modify status of user when he login and logout -->
<!-- - setup audio send -->
<!-- - verifier tous les champs avec l'ajax, verifier les champs avant l'envoie des datas comme dans le form-setting  -->
<!-- - creer un service pour rediger les slug que les users pourais modifier -->
<!-- - setup setting
    photo profile et le background-img
    pour la modification des image, il faut renvoyer le user dans une page ou il soumet un form content les images qui seront updater en php, pour utiliser l'axaj il faut nodejs.
    il sera renvoyer a la page lors du click sur le svg <pen>, un popup s'ouvre avec un form pour changer les images profile et back
    apres submition. utiliser <vichUploader> -->

# --------------------------------------------------------------------------- #

<!-- - mettre en place les messages audio -->
<!-- - ajout remember me dans la connexion -->
<!-- - ajouter un effet de chargement de la homepage avec le document.readyState -->
# NB: utiliser wavesurfer pour la lecture des audios link: https://wavesurfer-js.org/api/index.html

-------------------- fonctionnalities -----------------------------
<!-- audio send, emettre un son lors de l'envoie ou reception du message
image send
capable to download an image or delete it from messages -->

----------------- En attante -----------------------------
<!-- - ajouter envoie audio -->
- possibilite de supprimer un message dans le chat
----------------------------------------------------------
- en apprendre plus sur les fonctions async, pour comprendre leur utilisations
- aussi sur les Promesses
- en apprendre plus sur symfony avec openclassrooms, surtout la bonne qualite d'un code

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
-----------------------------------------
# systeme d'auth pour tous les users:
- faire un make:auth, prendre option 1
creation d'un nouveau userAuthenicator
- mettre la route a rediriger apres connexion dans UsersAuthenticator::onAuthenticationSuccess
- dans security.yaml ne pas decommenter les routes dans <access_control:>
- ajouter le role des users dans Users::getRoles
- ajouter la route a aller apres deconnexion dans security.yaml <logout:>
- et enfin ajouter une condition dans le controller Home
si aucun user n'est connecter on le renvoie vers la page login avec ($this->getUser())
-------------
- essayer d'utiliser le entry_point pour rediriger les users qui ne sont pas conneceter
# NB: pour le corriger le probleme peut etre qu'il faut que la route commence par qlq chose comme le ^/admin
-- la logique etait exacte fallait modifier l'url a utiliser pour home '/' en '^/home'
# NB: le entry_point est point d'entrer, lorsqu'une route est configurer dans <access_control:> comme ici ^/home

------------ installation symfony cli ---------------------
# step 1:
ouvrir powershell et taper => iwr -useb get.scoop.sh | iex
install scoop l'outil qui sera utiliser pour installation de symfony cli
# NB: 
en cas d'erreur de permition policy executer la command =>  Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
# step 2:
installation symfony cli => scoop install symfony-cli
# tester symfony cli:
tapper symfony 

---------------- INSTALLATION DE UTILISATION DE MERCURE (protocol utilisant le system de HUB) ------------------
# steps:
- telecharger mercure depuis le site officiel => https://github.com/dunglas/mercure/releases
- puis installer mercureBundle => composer require mercure
- puis configurer le bundle pour son utilisation
command: $env:MERCURE_PUBLISHER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; $env:MERCURE_SUBSCRIBER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; .\mercure.exe run --config Caddyfile.dev
#NB: le plus simple pour utiliser mercure c'est avec docker

--------------------- SUBSCRIBER EVENTS USES ---------------------------
- php bin/console make:subscriber => to CREATE a event subscriber then you can see all event and choose one