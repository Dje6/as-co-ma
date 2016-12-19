<?php

	$w_routes = array(
		//
		//affichage et traitement public
		//
		['GET', '/', 'Default#home', 'default_home'],//page d'acceuil
		['GET', '/cgu/', 'Default#cgu', 'default_cgu'],//page CGU redirigé depuis footer layout front

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
		['GET', '/Admin/contact/accepte/[:id]/[:orga]/[:slug]/', 'admin\Reponse#accepte', 'admin_accepte'],//accepte la demande d'inscritpion
		['GET', '/Admin/contact/plusInfo/[:id]/[:orga]/[:slug]/', 'admin\Reponse#plusInfo', 'admin_plus_info'],//refuse linscritpion manque d'info
		['GET', '/Admin/contact/refuse/[:id]/[:orga]/[:slug]/', 'admin\Reponse#refuse', 'admin_refuse'],//refuse la demande d'inscritpion
		['GET|POST', '/Admin/contact/repondre/[:id]/[:orga]/[:slug]/', 'admin\Reponse#repondre', 'admin_repondre'],//permet denvoyer une reponse par email
		['GET|POST', '/Admin/contact/repondreUser/[:id]/', 'admin\Reponse#repondreUser', 'admin_repondre_User'],
		//
		//administration Assoc
		//
		['GET', '/Admin/Assoc/[:slug]/', 'admin\Assoc#home', 'admin_assoc'],//page d'administration des association,affichage des info
		['GET', '/Admin/message/assoc/[:slug]/[:orga]/[:page]', 'admin\Message#orga', 'admin_message_assoc'],//affiche les message de lassociation
		['GET', '/Admin/ListeMembres/[:slug]/[:page]', 'admin\Assoc#listeMembres', 'admin_assoc_membres'],//affiche le listing des menbre de lassoc
		['GET', '/Admin/infoMembres/[:slug]/[:id]', 'admin\Users#ficheMembre', 'admin_assoc_membre'],//affiche la fiche personnel des menbre de lassoc
		['GET', '/Admin/EditAssoc/[:slug]/', 'admin\Assoc#homeEditForm', 'admin_assoc_edit_form'],//edition des données assoc
		['POST', '/Admin/EditAssoc/[:slug]/', 'admin\Assoc#homeEditPost', 'admin_assoc_edit_post'],//edition des données assoc
		['GET|POST', '/Admin/ContactMembres/[:slugE]/[:id]', 'admin\contact#contactMembre', 'admin_assoc_contact_membre'],//permet d'envoyer un message personnel a un menbre de lassoc
		['GET|POST', '/Admin/ContactMairie/[:slugE]/[:slugR]', 'admin\contact#contactMairie', 'admin_assoc_contact_mairie'],//permet d'envoyer un message personnel a la mairie referente

		//
		//administration mairie
		//
		['GET', '/Admin/Mairie/[:slug]/', 'admin\Mairie#home', 'admin_mairie'],//page d'administration des mairie,affichage des info
		['GET', '/Admin/Mairie/status/[:slug]/[:slugA]', 'admin\Mairie#homeEditStatus', 'admin_mairie_edit_status'],//edition du statut de l'assoc (actif, en attente)
		['GET', '/Admin/Mairie/delete/[:slug]/[:slugA]', 'admin\Mairie#homeDeleteAssoc', 'admin_mairie_delete_assoc'],//edition du statut de l'assoc (actif, en attente)
		['GET', '/Admin/message/mairie/[:slug]/[:orga]/[:page]', 'admin\Message#orga', 'admin_message_mairie'],//affiche les message de la mairie
		['GET', '/Admin/ListeAssoc/[:slug]/[:page]', 'admin\Mairie#listeAssoc', 'admin_mairie_assoc'],//listing des assoc enregistrer dans la mairie
		['GET', '/Admin/EditMairie/[:slug]/', 'admin\Mairie#homeEditForm', 'admin_mairie_edit_form'],//edition des données mairie
		['POST', '/Admin/EditMairie/[:slug]/', 'admin\Mairie#homeEditPost', 'admin_mairie_edit_post'],//edition des données mairie
		['GET|POST', '/Admin/ContactAssoc/[:slugE]/[:slugR]', 'admin\contact#contactAssoc', 'admin_mairie_contact_assoc'],//permet d'envoyer un message personnel a une assoc
		['GET|POST', '/Admin/ContactWebmaster/[:slugE]', 'admin\contact#contactWebmaster', 'admin_mairie_contact_Webmaster'],//permet d'envoyer un message personnel au webmaster du site

		//
		//administration user
		//
		['GET|POST', '/Admin/message/[:page]', 'admin\Message#home', 'admin_message'],//affiche les message du user connecter
		['GET', '/profile/', 'admin\Users#home', 'admin_monCompte'],//affiche les info du user connecter
		['GET', '/EditProfile/', 'admin\Users#homeEditionForm', 'admin_monCompte_edition'],//affiche le formulaire de modification des données
		['POST', '/SaveProfile/', 'admin\Users#homeEditionPost', 'admin_monCompte_edition_post'],//affiche le formulaire de modification des données
		//
		//administration superAdmin
		//
		['GET|POST', '/Admin/SuperAdmin/', 'admin\SuperAdmin#home', 'admin_superAdmin'],//affiche la page de gestion des mairie, uniquement supr admin
	);
