<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'decline' => array
	(
		'avs' => 'Le Service de Vérification d\'Adresse (AVS) a retourné une erreur. L\'adresse entrée ne correspond pas à l\'adresse de facturation du fichier bancaire.',
		'cvv' => 'Le code de vérification (CVV) de votre carte n\'a pas été accepté. Le numéro que vous avez entré n\'est pas le bon ou ne correspond pas à cette carte.',
		'call' => 'La carte doit être autorisée par téléphone. Vous devez choisir ce numéro d\'appel parmis ceux listés sur la carte et demander un code d\'authentification hors ligne (offline authcode). Celui-ci pourra ensuite être entré dans le champ réservé à cet effet (offlineauthcode).',
		'expiredcard' => 'La carte a expirée. Vous devez obtenir une carte possédant une date de validité valide auprès du fournisseur de celle-ci.',
		'carderror' => 'Le numéro de carte est invalide. Veuillez vérifier que vous avez correctement entré le numéro, ou que cette carte n\'ait pas été reportée comme étant volée.',
		'authexpired' => 'Tentative d\'autoriser une pré-autorisation qui a expirée il y a plus de 14 jours..',
		'fraud' => 'Le score de vérification est en dessous du score anti-fraude CrediGuard.',
		'blacklist' => 'CrediGuard donne cette valeur comme étant sur liste noire (blacklistée).',
		'velocity' => 'Le seuil de contôle CrediGuard a été atteint. Trop de transactions ont été effectués.',
		'dailylimit' => 'La limite journalière des transactions de cette carte a été atteinte.',
		'weeklylimit' => 'La limite hebdomadaire des transactions de cette carte a été atteinte.',
		'monthlylimit' => 'La limite mensuelle des transactions de cette carte a été atteinte.',
	),
	'baddata' => array
	(
		'missingfields' => 'Un ou plusieurs paramètres requis pour ce type de transaction n\'a pas été transmis.',
		'extrafields' => 'Des paramètres interdits pour ce type de transaction ont été envoyés.',
		'badformat' => 'Un champ n\'a pas été formaté correctement, comme par exemple des caractères alphabétiques insérés dans un champ numérique.',
		'badlength' => 'Un champ est plus grand ou plus petit que la taille acceptée par le serveur.',
		'merchantcantaccept' => 'Le commerçant ne peut accepter les données passées dans ce champ.',
		'mismatch' => 'Les données de l\'un des champs erroné ne correspond pas avec l\'autre champs.',
	),
	'error' => array
	(
		'cantconnect' => 'Impossible de se connecter à la plateforme TrustCommerce ! Veuillez vous assurer que votre connexion internet fonctionne.',
		'dnsfailure' => 'Le logiciel TCLink a été incapable de résoudre l\'adresse DNS du serveur. Assurez-vous que votre machine possède la capacité de résoudre les noms DNS.',
		'linkfailure' => 'La connexion n\'a pas pu être établie et vous avez été déconnecté avant que la transaction ne soit complète.',
		'failtoprocess' => 'Les serveurs bancaires ne sont pas disponibles actuellement et ne peuvent donc accepter des transactions. Veuillez réessayer dans quelques minutes. Vous pouvez également tester avec une autre carte d\'un autre organisme bancaire.',
	)
);
