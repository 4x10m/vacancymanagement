Stage Management Project Server
===============================

Ce serveur fait partis d'un projet de gestion des stages réalisé dans le milieu universitaire initié dans la cadre de ma formation. Il consiste a réalisé une interface web et une application android permettant de gérer les stages de fin d'année dans un milieu universitaire. Ce système devra respecter la norme MVC et sera réalisé en groupes.

Nous avons décidé de découper le système en trois parties que sont :
	- Le serveur : dans un modèle MVC, il serait identifié comme le modèle et le controller, en effet, le serveur est enrichie d'une API (controlleurs) et d'objets (modèles) venant manipulé la base de données.
	- Un site web : ou plutot une application web puisque qu'elle intègre beaucoup de javascript. C'est un client qui permet a un utilisateur d'utiliser le serveur. C'est une vue.
	- Une application android : La deuxième vue est une application permettant l'apport des fonctionnalités spécifiques des appareils mobiles.

Le serveur

Le serveur est réalisé en PHP et intéragit avec une base de donnée en mysql.

Structure des fichiers :
/
	controller/ : contient les controlleurs
	lib/ : contient les librairies externe
	model/ : les modèles
	sql/ : script base de données

L'organisation est très simple, le protocol est en REST, c'est a dire que chaque controlleur correspond a une fonction identifié par une URL. Le paramètres sont aussi récupéré dans l'URL. Les controlleurs n'intéragissent jamais directement avec la base de données, ils passent par les modèles pour cela.

La ou ça se complique un peu c'est que les modèles héritent d'une classe DatabaseEntity qui utilise une classe DatabaseController pour discuter avec la base de donnée. Des changements sont a venir dans ce système, voir todolist.

Structure des branches :

Une branche dev pour mon dévellopement, normalement il devrait apparaitre des branches en fonction des devellopeurs qui participeront au projet.
La branche master est réservé aux versions realeases fonctionnant en synchronisation avec les versions client.
On pourrais aussi détacher le protocol dans une branche protocol.

Installer

Il suffit de copier le dossier dans lequel se trouve ce readme a la racine de votre repertoire www.
Ensuite il faut importer la base de données qui se trouve dans sql/.
Pour finir il faut modifier le mot de passe et le nom d'utilisateur dans le fichier config dans lib/.

TODO List :

Server

Système de droit
Refaire le système modèle : voir pour fusionner DatabaseEntity et DatabaseController.
Passer les fonctions statics en fonctions de membre dans les modèles
Reunir les deux dossiers lib, le fichier config
Concatener Database Entity et Database Controller
Rassembler GCM utilisateur et user

Modèles

Utilisateur
Session etudiante
Stage
Candidature
Enregistrement d'entreprise
GCM utilisateur
Fichier configuration

Protocol

Ajouter un administrateur
	Paramètre : Nom d'administrateur, mot de passe
	Retour :  Aucun
	Droits : Personne
	Description :Ajoute un administrateur au système

Ajouter un stage
	Paramètre : Nom du stage, Description du stage
	Droit : Entreprise, Administrateur
	Retour : Aucun
	Description : Ajoute un stage a la base de données

Ajouter un étudiant
	Paramètres : Type d'invitation (SMS ou Email), Chaine de contact, Nom
	Droits : Administrateur
	Retour : Aucun
	Description : Invite un étudiant a activer sa session soit par email soit par sms

Candidater a un stage
	Paramètres : Identifiant du stage
	Droits : Etudiants
	Retour : Aucun
	Description : Enregistre une candidature dans la base de données

Vérifier la connexion
	Paramètres : Aucun
	Droits : Tout le monde
	Retour : true si connecté, false sinon
	Description : Vérifie si l'utilisateur est identifié

Déconnecter
	Paramètre : Aucun
	Droits : Tout le monde
	Retour : Aucun
	Description : Oublie les données de connexion

Enregistrer une entreprise
	Paramètre : Email, Nom, Site, Mot de passe
	Droits : Entreprise
	Retour : Aucun
	Description : Démarre le processus d'enregistrement de l'entreprise, envoi un email de pour confirmer l'adresse email

Enregistrer GCM
	Paramètre : Aucun
	Droit : Tout le monde
	Retour : Aucun
	Description : Enregistre un appareil mobile sur le serveur pour recevoir les notification

Obtenir les stages candidaté
	Paramètre : Aucun
	Droit : Etudiant
	Retour : Les stages candidatés
	Description : Obtiens les stages auquels un éudiant a candidaté

Obtenir candidatures
	Paramètre : Aucun
	Droit : Entreprise
	Retour : Les candidatures
	Description : Obtenir les candidatures d'un stage

Obtenir les enregistrement d'entreprise
	Paramètre : Aucun
	Droit : Administrateur
	Retour : Les enregistrement d'entreprise
	Description : Envoi les enregistrements d'entreprise

Obtenir le profil
	Paramètre : Identifiant utilisateur
	Droit : Entreprise
	Retour : Profil utilisateur
	Description : Envoi de profil public de l'utilisateur

Obtenir les stages
	Paramètre : Aucun
	Droit : Etudiant, Administrateur
	Retour : Les stages
	Description : Envoi tous les stages

Obtenir les stages d'une entreprise
	Droit : Entreprise
	Retour : Les stages d'une entreprise
		Tableau
			Etat
		Tableau Valeurs
			Nom stage
			Description Stage
	Description : Renvoi les stages d'une entreprise

Obtenir informations utilisateur
	Paramètres : Identifiant utilisateur
	Droit : Tout le monde
	Description : Obtiens les informations d'un utilisateur
	Retour : Les informations d'un utilisateur
		Tableau
			Etat
		Tableau valeur
			Nom

Obtenir id utilisateur
	Description : Récupère notre id utilisateur
	Droit : Tout le monde
	Paramètres : Aucun
	Retour : Identifiant de l'utilisateur

Inviter a partir des numéros de téléphone
	Description : Ouvre des sessions étudiantes en les invitant grâce a un SMS
	Droit : Administrateur
	Paramètres : Nom et numéro de téléphone des étudiants
	Retour : Aucun

S'identifier
	Description : S'identifier sur le serveur
	Droit : Tout le monde
	Paramètres : Nom d'utilisateur et mot de passe
	Retour : Aucun

Refuser un enregistrement d'entreprise
	Description : Refuse un enregistrement d'entreprise
	Droit : Administrateur
	Paramètres : Identifiant de l'enregistrement d'entreprise
	Retour : Aucun

Valider un enregistrement d'entreprise
	Description : Valide un enregistrement d'entreprise
	Droit : Administrateur
	Paramètres : Identifiant de l'enregistrement d'entreprise
	Retour : Aucun

Publier un stage
	Description : Publie un stage auprès des étudiants
	Droit : Administrateur
	Paramètres : Identifiant du stage
	Retour : Aucun

Valider email entreprise
	Description : Valide l'adresse email d'une entreprise
	Paramètre : Identifiant enregistrement d'entreprise, code de validation d'email
	Droit : Entreprise
	Retour : Etat de la requête
		{ state : "", values: {[""...]}}

Valider session étudiante
	Description : Valide une session étudiante a la première connexion
	Paramètre : Mot de passe étudiant, identifiant étudiant, code de validation activation
	Droit : Etudiant
	Retour ; Etat de la requète
		{ state : "boolean", values {[null]}}