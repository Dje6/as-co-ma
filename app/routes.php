<?php

	$w_routes = array(
		//
		//affichage et traitement public
		//
		['GET', '/', 'Default#home', 'default_home'],//page d'acceuil

		['GET', '/a/[:orga]/[:slug]', 'racine\Assoc#home', 'racine_assoc'],//page de recherche et affichage d'association
		['POST', '/a/[:orga]/[:slug]', 'racine\Assoc#search', 'racine_assoc_search'],//retourne le resultat de la recherche d'association

		['GET', '/m/[:orga]/[:slug]', 'racine\Mairie#home', 'racine_mairie'],//page de recherche et affichage de mairie
		['POST', '/m/[:orga]/[:slug]', 'racine\Mairie#search', 'racine_mairie_search'],//retourne le resultat de la recherche de mairie

		['GET', '/contact/[:orga]/[:slug]/', 'racine\Contact#home', 'racine_contact'],//affiche le formulaire de contact
		['POST', '/contact/[:orga]/[:slug]/', 'racine\Contact#sendMessage', 'racine_contact_send'],//traite lenvoi du formulaire de contact
		//
		//connexion public
		//
		['GET', '/login/', 'racine\Connexion#form', 'racine_form'],//affiche le formulaire de connection
		['POST', '/login/', 'racine\Connexion#login', 'racine_connexion'],//traite le formulaire de connection

		['GET', '/rescu/', 'racine\Connexion#mdpForm', 'racine_mdpForm'],//formulaire de mot de passe oublier
		['POST', '/rescu/', 'racine\Connexion#mdpPost', 'racine_mdpPost'],//traite la demande de changement de mot de passe

		['GET', '/modify/[*:mail]/[:token]', 'racine\Connexion#modifyForm', 'racine_modifyForm'],//formulaire de modification de mot de passe
		['POST', '/modifyPost/', 'racine\Connexion#modifyPost', 'racine_modifyPost'],//traite la demande de changement de mot de passe

		//
		//inscrition public
		//
		['GET', '/inscript/', 'racine\Connexion#inscriptForm', 'racine_inscriptForm'],//affiche le formulaire d'inscritpion
		['POST', '/inscript/', 'racine\Connexion#inscriptPost', 'racine_inscriptPost'],//traite le formulaire d'inscription

		['GET', '/sendmail/[*:mail]/[:token]', 'racine\Connexion#sendMailValidate', 'racine_send_valide'],//envoi le mail d'activation de compte
		['GET', '/valid_inscript/[*:mail]/[:token]', 'racine\Connexion#validation', 'racine_valide_inscript'],//traite la demande d'activation
		//
		//Deconnection public
		//
		['GET', '/unlog/', 'racine\Connexion#unlog', 'racine_unlog'],//detruit la session actuel
		//
		//administration des demande
		//
		['GET', '/contact/accepte/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#accepte', 'admin_accepte'],//accepte la demande d'inscritpion
		['GET', '/contact/plusInfo/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#plusInfo', 'admin_plus_info'],//refuse linscritpion manque d'info
		['GET', '/contact/refuse/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#refuse', 'admin_refuse'],//refuse la demande d'inscritpion
		['GET', '/contact/repondre/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#repondre', 'admin_repondre'],//permet denvoyer une reponse par email
		//
		//administration Assoc
		//
		['GET', '/Admin/Assoc/[:slug]/', 'admin\Assoc#home', 'admin_assoc'],//page d'administration des association,affichage des info
		['GET', '/Admin/message/assoc/[:slug]/[:page]', 'admin\Message#assoc', 'admin_message_assoc'],//affiche les message de lassociation
		['GET', '/Admin/ListeMenbres/[:slug]/[:page]', 'admin\Assoc#listeMenbres', 'admin_assoc_menbres'],//affiche le listing des menbre de lassoc
		['GET', '/Admin/infoMenbres/[:slug]/[:id]', 'admin\Users#ficheMenbre', 'admin_assoc_menbre'],//affiche la fiche personnel des menbre de lassoc
		//
		//administration mairie
		//
		['GET', '/Admin/Mairie/[:slug]/', 'admin\Mairie#home', 'admin_mairie'],//page d'administration des mairie,affichage des info
		['GET', '/Admin/message/mairie/[:slug]/[:page]', 'admin\Message#mairie', 'admin_message_mairie'],//affiche les message de la mairie
		['GET', '/Admin/ListeAssoc/[:slug]/[:page]', 'admin\Mairie#listeAssoc', 'admin_mairie_assoc'],//listing des assoc enregistrer dans la mairie
		//
		//administration user
		//
		['GET|POST', '/Admin/message/[:page]', 'admin\Message#home', 'admin_message'],//affiche les message du user connecter
		['GET|POST', '/profile/', 'admin\Users#home', 'admin_monCompte'],//affiche les info du user connecter
		//
		//administration superAdmin
		//
		['GET|POST', '/Admin/SuperAdmin/', 'admin\SuperAdmin#home', 'admin_superAdmin'],//affiche la page de gestion des mairie, uniquement supr admin
	);
