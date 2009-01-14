<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'decline' => array
	(
		'avs' => 'AVS fehlgeschlagen; Die angegebene Adresse stimmt nicht mit der Rechnungsadresse in der Bank überein.',
		'cvv' => 'CVV fehlgeschlagen; Die angegebene Zahl ist nicht die korrekte Prüfnummer der Karte.',
		'call' => 'Die Karte muss über das Telefon autorisiert werden. Sie können die Kundenbetreung anrufen, um nach dem Offline-Autorisierungscode zu fragen, der in das entsprechende Feld eingetragen werden kann.',
		'expiredcard' => 'Die Karte ist abgelaufen. Fragen Sie nach einem neuen Ablaufdatum bei dem Karteninhaber.',
		'carderror' => 'Die Kartennummer ist ungültig. Das könnte ein Tippfehler oder manchmal die Karte als gestohlen gemeldet sein.',
		'authexpired' => 'Versuch eine abgelaufene (mehr, als 14 Tage alt) Vorautorisation zu nachzuautorisieren.',
		'fraud' => 'CrediGuard fraud score war unter dem gefordetem Schwellenwert.',
		'blacklist' => 'CrediGuard Blacklist-Wert wurde ausgelöst.',
		'velocity' => 'CrediGuard Geschwindigkeitsregelung wurde ausgelöst.',
		'dailylimit' => 'Tageslimit oder der Transaktionen oder des Betrags wurde erreicht.',
		'weeklylimit' => 'Wochenlimit oder der Transaktionen oder des Betrags wurde erreicht.',
		'monthlylimit' => 'Monatslimit oder der Transaktionen oder des Betrags wurde erreicht.',
	),
	'baddata' => array
	(
		'missingfields' => 'Ein oder mehr Parameter, die für diese Transaktion benötigt werden, wurden nicht gesendet.',
		'extrafields' => 'Parameter, die für diese Transaktion gesendet wurden, sind nicht erlaubt.',
		'badformat' => 'Ein Feld ist nicht sachgemäß formatiert worden. Es könnten zum Beispiel Buchstaben in einem Zahlenfeld vogekommen sein.',
		'badlength' => 'Ein Feld war länger oder kürzer, als es der Server erlaubt.',
		'merchantcantaccept' => 'Der Händler kann diese übergebenen Daten in diesem Feld nicht akzeptieren.',
		'mismatch' => 'Daten in einem der folgenden Felder stimmen nicht mit einem anderen Feld überein.',
	),
	'error' => array
	(
		'cantconnect' => 'Konnte keine Verbindung zu TrustCommerce aufbauen. Kontrollieren Sie ihre Internetverbindung, um sicherzustellen, dass diese funktioniert.',
		'dnsfailure' => 'Das Programm TCLink konnte die DNS-Hostnamen nicht auflösen. Stellen Sie sicher, dass sie die Rechte dafür besitzen.',
		'linkfailure' => 'Die hergestellte Verbindung wurde unterbrochen, bevor die Transaktion beendet werden konnte.',
		'failtoprocess' => 'Die Server der Bank sind offline und nicht in der Lage die Transaktion zu autorisieren. Versuchen Sie es in einigen Minuten noch ein mal oder benutzen Sie eine Karte einer anderen Bank.',
	)
);