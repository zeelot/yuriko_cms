<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'decline' => array
	(
		'avs'                => 'AVS Fallito; l\'indirizzo fornito non coincide con l\'indirizzo di fatturazione che appare alla banca.',
		'cvv'                => 'CVV Fallito; il numero fornito non è il numero di verifica corretto della carta.',
		'call'               => 'La carta tiene deve essere autorizzata per telefono. Puoi scegliere di chiamare al servizio clienti che appare sulla carta e richiedere un numero di autorizzazione offline, introducibile nel campo offlineauthcode.',
		'expiredcard'        => 'La carta è scaduta. Richiedi una modifica della data di scadenza all\'ente che ha emesso la carta.',
		'carderror'          => 'Numero della carta incorretto, potrebbe essere un errore di scrittura o in qualche caso una carta denunciata come rubata.',
		'authexpired'        => 'Si è cercato di autorizzare una autorizzazione prima che sia scaduta (più di 14 giorni).',
		'fraud'              => 'Il punteggio di frode di CrediGuard è sotto il limite richiesto.',
		'blacklist'          => 'Sono stati superati i valori della lista nera di CrediGuard.',
		'velocity'           => 'È stato superato il controllo di velocità di CrediGuard.',
		'dailylimit'         => 'È stato raggiunto il limite giornaliero di transazioni, per numero o ammontare.',
		'weeklylimit'        => 'È stato raggiunto il limite settimanale di transazioni, per numero o ammontare.',
		'monthlylimit'       => 'È stato raggiunto il limite mensile di transazioni, per numero o ammontare.',
	),
	'baddata' => array
	(
		'missingfields'      => 'Non sono stati inviati uno o più paramentri obbligatori per questo tipo di transazione.',
		'extrafields'        => 'Sono stati inviati parametri non ammessi per questo tipo di transazione.',
		'badformat'          => 'Uno dei campi è stato compilato impropriamente, ad esempio un carattere alfabetico in un campo numerico.',
		'badlength'          => 'Uno dei campi è più grande o più piccolo del consentito.',
		'merchantcantaccept' => 'Il venditore non accetta i dati introdotti in questo campo.',
		'mismatch'           => 'I dati di uno dei campi non soddisfa il controllo incrociato con con un\'altro dei campi.',
	),
	'error' => array
	(
		'cantconnect'        => 'Impossibile connettersi alla piattaforma TrustCommerce. Controllare la connessione a Internet e assicurarsi che sia in funzione.',
		'dnsfailure'         => 'Il programma TCLink non è stato in grado di risolvere i nomi DNS. Assicurarsi di poter risolvere i nomi sulla macchina.',
		'linkfailure'        => 'È stata stabilita la connessione, ma si è interrotta prima che terminasse la transazione.',
		'failtoprocess'      => 'I server della Banca non sono in línea, pertanto risulta impossibile autorizzare le transazioni. Ritenta fa qualche minuto, oppure prova con una carta di un\'altra banca.',
	),
);