<?php

	$w_routes = array(
		//
		//affichage et traitement public
		//
		['GET', '/', 'Default#home', 'default_home'],//page d'acceuil
		['GET', '/cgu/', 'Default#cgu', 'default_cgu'],//page CGU redirigé depuis footer layout front
		['GET', '/futur/', 'Default#futur', 'default_futur'],//page CGU redirigé depuis footer layout front

		['GET|POST', '/DesinscritpionNewsletter/[:orga]/[:slug]', 'racine\newsletter#home', 'default_desinscription'],//desinscription news letter

		['GET|POST', '/a/[:orga]/[:slug]', 'racine\Assoc#home', 'racine_assoc'],//page de recherche et affichage d'association

		['GET|POST', '/m/[:orga]/[:slug]', 'racine\Mairie#home', 'racine_mairie'],//page de recherche et affichage de mairie

		['GET', '/contact/[:orga]/[:slug]/', 'racine\Contact#home', 'racine_contact'],//affiche le formulaire de contact
		['POST', '/contact/[:orga]/[:slug]/', 'racine\Contact#sendMessage', 'racine_contact_send'],//traite lenvoi du formulaire de contact
		//
		//connexion public
		//
		['GET', '/login/', 'racine\Connexion#form', 'racine_form'],//affiche le formulaire de connection
		['POST', '/login/', 'racine\Connexion#login', 'racine_connexion'],//traite le formulaire de connection
		//mot de passe oublier
		['GET', '/rescu/', 'racine\Connexion#mdpForm', 'racine_mdpForm'],//formulaire de mot de passe oublier
		['POST', '/rescu/', 'racine\Connexion#mdpPost', 'racine_mdpPost'],//traite la demande de changement de mot de passe
		//changement de mot de passe
		['GET', '/modify/[*:mail]/[:token]', 'racine\Connexion#modifyForm', 'racine_modifyForm'],//formulaire de modification de mot de passe
		['POST', '/modifyPost/', 'racine\Connexion#modifyPost', 'racine_modifyPost'],//traite la demande de changement de mot de passe

		//
		//inscrition public
		//
		['GET', '/inscript/', 'racine\Connexion#inscriptForm', 'racine_inscriptForm'],//affiche le formulaire d'inscritpion
		['POST', '/inscript/', 'racine\Connexion#inscriptPost', 'racine_inscriptPost'],//traite le formulaire d'inscription
		//envoi de mail d activation
		['GET', '/sendmail/[*:mail]/[:token]', 'racine\Connexion#sendMailValidate', 'racine_send_valide'],//envoi le mail d'activation de compte
		['GET', '/valid_inscript/[*:mail]/[:token]', 'racine\Connexion#validation', 'racine_valide_inscript'],//traite la demande d'activation
		//
		//Deconnection public
		//
		['GET', '/unlog/', 'racine\Connexion#unlog', 'racine_unlog'],//detruit la session actuel
		//
		//action des systeme de messagerie
		//
		['GET', '/Admin/contact/delete/[:id]/[:orga]/[:slug]/[:page]', 'admin\Action#delete', 'admin_message_delete'],//permet de supprimer un message
		['GET', '/Admin/contact/asSeen/[:id]/[:orga]/[:slug]/[:page]', 'admin\Action#asSeen', 'admin_message_asSeen'],//marque comme lu un message avec la date de lecture
		['GET', '/Admin/contact/decision/[:id]/[:orga]/[:slug]/[:decision]', 'admin\Decision#decision', 'admin_decide'],//accepte la demande d'inscritpion
		['GET|POST', '/Admin/contact/repondre/[:id]/[:orga]/[:slug]/', 'admin\Reponse#repondre', 'admin_repondre'],//permet denvoyer une reponse en tant qu'organisme
		['GET|POST', '/Admin/contact/repondreUser/[:id]/', 'admin\Reponse#repondreUser', 'admin_repondre_User'],//permet de repondre en tant qu'utilisateur
		//Invitation
		['GET', '/Admin/Invitation/[:id]/[:decision]', 'admin\Invitation#decision', 'admin_invitation_decision'],//permet daccepter ou refuser une Invitation a entrer dan une assoc
		//
		//administration Assoc
		//
		['GET', '/Admin/Assoc/[:slug]/', 'admin\Assoc#home', 'admin_assoc'],//page d'administration des association,affichage des info
		['GET', '/Admin/Assoc/role/[:slug]/[:id]', 'admin\Assoc#homeEditUserRole', 'admin_assoc_edit_user_role'],
		['GET', '/Admin/Assoc/delete/[:slug]/[:id]', 'admin\Assoc#homeDeleteUserAssoc', 'admin_assoc_delete_user'],
		['GET', '/Admin/infoMembres/[:slug]/[:id]', 'admin\Users#ficheMembre', 'admin_assoc_membre'],//affiche la fiche personnel des menbre de lassoc
		['GET', '/Admin/EditAssoc/[:slug]/', 'admin\Assoc#homeEditForm', 'admin_assoc_edit_form'],//edition des données assoc
		['POST', '/Admin/EditAssoc/[:slug]/', 'admin\Assoc#homeEditPost', 'admin_assoc_edit_post'],//edition des données assoc
		//Membre
		['GET', '/Admin/ListeMembres/[:slug]/[:page]', 'admin\Assoc#listeMembres', 'admin_assoc_membres'],//affiche le listing des menbre de lassoc
		['POST', '/Admin/InvitMembres/[:slug]', 'admin\Invitation#invitMembre', 'admin_assoc_invit'],//envoi une invitation a rejoindre lassocation
		// messagerie Assoc
		['GET|POST', '/Admin/ContactMembre/[:slugE]/[:id]', 'admin\contact#contactMembre', 'admin_assoc_contact_membre'],//permet d'envoyer un message personnel a un menbre de lassoc
		['GET|POST', '/Admin/ContactToutMembres/[:slugE]', 'admin\contact#contactToutMembres', 'admin_assoc_contact_tout_membres'],//permet d'envoyer un message a tout les menbre de lassoc
		['GET|POST', '/Admin/ContactMairie/[:slugE]/[:slugR]', 'admin\contact#contactMairie', 'admin_assoc_contact_mairie'],//permet d'envoyer un message personnel a la mairie referente
		['GET', '/Admin/message/assoc/[:slug]/[:orga]/[:page]', 'admin\Message#orga', 'admin_message_assoc'],//affiche les message recu de lassociation
		['GET', '/Admin/messageSend/assoc/[:slug]/[:orga]/[:page]', 'admin\Message#orgaSend', 'admin_message_send_assoc'],//affiche les message envoyer par lassociation
		// News Assoc
		['GET|POST', '/Admin/Assoc/EditNew/[:slug]/[:orga]', 'admin\News#edit', 'admin_assoc_edit_news'],
		['GET|POST', '/Admin/Assoc/UpdateNew/[:slug]/[:orga]/[:id]', 'admin\News#update', 'admin_assoc_update_news'],
		['GET', '/Admin/Assoc/News/[:slug]/[:orga]/[:page]', 'admin\News#home', 'admin_assoc_news'],
		['GET', '/Admin/Assoc/DeleteNews/[:slug]/[:orga]/[:id]/[:page]', 'admin\News#delete', 'admin_assoc_delete_news'],
		['GET', '/Admin/Assoc/StatusNews/[:slug]/[:orga]/[:id]/[:page]', 'admin\News#status', 'admin_assoc_status_news'],
		['GET', '/Admin/Assoc/NewsLetter/[:slug]/[:orga]/[:id]/[:page]', 'admin\News#newsletter', 'admin_assoc_newsletter'],//declenche la newsletter
		//
		//administration mairie
		//
		['GET', '/Admin/Mairie/[:slug]/', 'admin\Mairie#home', 'admin_mairie'],//page d'administration des mairie,affichage des info
		['GET', '/Admin/Mairie/status/[:slug]/[:slugA]', 'admin\Mairie#homeEditStatus', 'admin_mairie_edit_status'],//edition du statut de l'assoc (actif, en attente)
		['GET', '/Admin/Mairie/delete/[:slug]/[:slugA]', 'admin\Mairie#homeDeleteAssoc', 'admin_mairie_delete_assoc'],//edition du statut de l'assoc (actif, en attente)
		['GET', '/Admin/EditMairie/[:slug]/', 'admin\Mairie#homeEditForm', 'admin_mairie_edit_form'],//edition des données mairie
		['POST', '/Admin/EditMairie/[:slug]/', 'admin\Mairie#homeEditPost', 'admin_mairie_edit_post'],//edition des données mairie
		//liste assoc
		['GET', '/Admin/ListeAssoc/[:slug]/[:page]', 'admin\Mairie#listeAssoc', 'admin_mairie_assoc'],//listing des assoc enregistrer dans la mairie
		//['POST', '/Admin/InvitCollaborateur/[:slug]', 'admin\Invitation#invitCollaborateur', 'admin_mairie_invit_colab'],//envoi une invitation a rejoindre lassocation
		// Messagerie Mairie
		['GET|POST', '/Admin/ContactAssoc/[:slugE]/[:slugR]', 'admin\contact#contactAssoc', 'admin_mairie_contact_assoc'],//permet d'envoyer un message personnel a une assoc
		['GET|POST', '/Admin/ContactWebmaster/[:slugE]', 'admin\contact#contactWebmaster', 'admin_mairie_contact_Webmaster'],//permet d'envoyer un message personnel au webmaster du site
		['GET', '/Admin/message/mairie/[:slug]/[:orga]/[:page]', 'admin\Message#orga', 'admin_message_mairie'],//affiche les message recu de la mairie
		['GET', '/Admin/messageSend/mairie/[:slug]/[:orga]/[:page]', 'admin\Message#orgaSend', 'admin_message_send_mairie'],//affiche les message envoyer par la mairie
		// News Mairie
		['GET|POST', '/Admin/Mairie/EditNew/[:slug]/[:orga]', 'admin\News#edit', 'admin_mairie_edit_news'],
		['GET|POST', '/Admin/Mairie/UpdateNew/[:slug]/[:orga]/[:id]', 'admin\News#update', 'admin_mairie_update_news'],
		['GET', '/Admin/Mairie/News/[:slug]/[:orga]/[:page]', 'admin\News#home', 'admin_mairie_news'],
		['GET', '/Admin/Mairie/DeleteNews/[:slug]/[:orga]/[:id]/[:page]', 'admin\News#delete', 'admin_mairie_delete_news'],
		['GET', '/Admin/Mairie/StatusNews/[:slug]/[:orga]/[:id]/[:page]', 'admin\News#status', 'admin_mairie_status_news'],
		['GET', '/Admin/Mairie/NewsLetter/[:slug]/[:orga]/[:id]/[:page]', 'admin\News#newsletter', 'admin_mairie_newsletter'],//declenche la newsletter
		//
		//administration user
		//
		['GET', '/profile/', 'admin\Users#home', 'admin_monCompte'],//affiche les info du user connecter
		['GET', '/DeleteProfil/', 'admin\Users#delete', 'admin_monCompte_supprimer'],//supprime definitivement le compte de lutilisateur
		['GET', '/EditProfile/', 'admin\Users#homeEditionForm', 'admin_monCompte_edition'],//affiche le formulaire de modification des données
		['POST', '/SaveProfile/', 'admin\Users#homeEditionPost', 'admin_monCompte_edition_post'],//modifie les données
		//messagerie
		['GET', '/Admin/message/[:page]', 'admin\Message#home', 'admin_message'],//affiche les message du user connecter
		['GET', '/Admin/messageSend/[:page]', 'admin\Message#homeSend', 'admin_message_send'],//affiche les message du user connecter
		//
		//administration superAdmin
		//

		//SuperAdmin
		['GET', '/Admin/message/webmaster/[:slug]/[:orga]/[:page]', 'admin\Message#orga', 'admin_message_webmaster'],//affiche les message du user connecter
		['GET', '/Admin/messageSend/webmaster/[:slug]/[:orga]/[:page]', 'admin\Message#orgaSend', 'admin_message_send_webmaster'],//affiche les message du user connecter
		['GET', '/Admin/ListeMairie/[:page]', 'admin\SuperAdmin#listeMairie', 'admin_webmaster_mairie'],//listing des assoc enregistrer dans la mairie
		['GET', '/Admin/Webmaster/delete/[:id]', 'admin\SuperAdmin#DeleteMairie', 'admin_webmaster_delete_mairie'],//suprime une mairie
		['GET', '/Admin/Webmaster/status/[:id]', 'admin\SuperAdmin#EditStatus', 'admin_webmaster_edit_status'],//edition du statut de la mairie(actif, en attente)
	);
