<?php

	$w_routes = array(
		//public
		['GET', '/', 'Default#home', 'default_home'],
		['GET', '/agenda/[:slug]', 'racine\Agenda#home', 'racine_agenda'],

		['GET', '/a/[:orga]/[:slug]', 'racine\Assoc#home', 'racine_assoc'],
		['POST', '/a/[:orga]/[:slug]', 'racine\Assoc#search', 'racine_assoc_search'],

		['GET', '/m/[:orga]/[:slug]', 'racine\Mairie#home', 'racine_mairie'],
		['POST', '/m/[:orga]/[:slug]', 'racine\Mairie#search', 'racine_mairie_search'],

		['GET', '/news/[:slug]', 'racine\News#home', 'racine_news'],

		['GET', '/contact/[:orga]/[:slug]/', 'racine\Contact#home', 'racine_contact'],
		['POST', '/contact/[:orga]/[:slug]/', 'racine\Contact#sendMessage', 'racine_contact_send'],

		['GET', '/contact/accepte/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#accepte', 'admin_accepte'],
		['GET', '/contact/plusInfo/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#plusInfo', 'admin_plus_info'],
		['GET', '/contact/refuse/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#refuse', 'admin_refuse'],
		['GET', '/contact/repondre/[*:mail]/[:orga]/[:slug]/', 'admin\Contact#repondre', 'admin_repondre'],
		//connexion public
		['GET', '/login/', 'racine\Connexion#form', 'racine_form'],
		['POST', '/login/', 'racine\Connexion#login', 'racine_connexion'],

		['GET', '/inscript/', 'racine\Connexion#inscriptForm', 'racine_inscriptForm'],
		['POST', '/inscript/', 'racine\Connexion#inscriptPost', 'racine_inscriptPost'],
		['GET', '/sendmail/[*:mail]/[:token]', 'racine\Connexion#sendMailValidate', 'racine_send_valide'],
		['GET', '/valid_inscript/[*:mail]/[:token]', 'racine\Connexion#validation', 'racine_valide_inscript'],

		['GET', '/rescu/', 'racine\Connexion#mdpForm', 'racine_mdpForm'],
		['POST', '/rescu/', 'racine\Connexion#mdpPost', 'racine_mdpPost'],

		['GET', '/unlog/', 'racine\Connexion#unlog', 'racine_unlog'],
		//admin
		['GET', '/Admin/Assoc/[:slug]/', 'admin\Assoc#home', 'admin_assoc'],
		['GET', '/Admin/message/assoc/[:slug]/[:page]', 'admin\Message#assoc', 'admin_message_assoc'],
		['GET', '/Admin/ListeMenbres/[:slug]/[:page]', 'admin\Assoc#listeMenbres', 'admin_assoc_menbres'],
		['GET', '/Admin/infoMenbres/[:slug]/[:id]', 'admin\Users#ficheMenbre', 'admin_assoc_menbre'],

		['GET', '/Admin/Mairie/[:slug]/', 'admin\Mairie#home', 'admin_mairie'],
		['GET', '/Admin/message/mairie/[:slug]/[:page]', 'admin\Message#mairie', 'admin_message_mairie'],
		['GET', '/Admin/ListeAssoc/[:slug]/[:page]', 'admin\Mairie#listeAssoc', 'admin_mairie_assoc'],

		['GET|POST', '/Admin/SuperAdmin/', 'admin\SuperAdmin#home', 'admin_superAdmin'],
		['GET|POST', '/Admin/message/[:page]', 'admin\Message#home', 'admin_message'],
		['GET|POST', '/profile/', 'admin\Users#home', 'admin_monCompte'],
	);
//$router->addMatchTypes(array('cId' => '[a-zA-Z]{2}[0-9](?:_[0-9]++)?'));
