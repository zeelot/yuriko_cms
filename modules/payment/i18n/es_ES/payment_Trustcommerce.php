<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
	'decline' => array
	(
		'avs'                => 'Fallo AVS; la dirección introducida no coincide con la dirección de facturación que aparece en el fichero del banco.',
		'cvv'                => 'Fallo CVV; el número provisto no es el número de verificación correcto para la tarjeta.',
		'call'               => 'La tarjeta tiene que ser autorizada manualmente mediante telefono. Puedes elegir llamar al servicio de atencion al cliente que aparece en la tarjeta y solicitar un número de autorizacón &8220;offline&8221;, que puede ser introducido en el campo &8220;offlineauthcode&8221;.',
		'expiredcard'        => 'La tarjeta ha caducado. Solicite una apliación de la fecha de caducidad a la entidad emisora.',
		'carderror'          => 'Numero de tarjeta incorrecto, lo que podria ser un error de escritura, o en algunos casos una tarjeta denunciada como robada.',
		'authexpired'        => 'Intentando volver a autorizar una autorización previa que ha expirado (mas de 14 dias de antiguedad).',
		'fraud'              => 'La puntuación de fraude de CrediGuard esta por debajo del limite solicitad.',
		'blacklist'          => 'Se han superado los valores para la lista negra de CrediGuard.',
		'velocity'           => 'Se ha superado el control de velocidad de CrediGuard.',
		'dailylimit'         => 'Se ha alcanzado el limite diario de transacciones, ya sea por numero o cantidad.',
		'weeklylimit'        => 'Se ha alcanzado el limite semanal de transacciones, ya sea por numero o cantidad.',
		'monthlylimit'       => 'Se ha alcanzado el limite mensual de transacciones, ya sea por numero o cantidad.',
	),
	'baddata' => array
	(
		'missingfields'      => 'No ha enviado uno o más parametros requeridos para este tipo de transacción.',
		'extrafields'        => 'Se han enviado parametros no permitidos para este tipo de transacción.',
		'badformat'          => 'Uno de los campos se ha rellenado de manera incorrecta, por ejemplo un caractér no númerico en un campo númerico.',
		'badlength'          => 'Uno de los campos es más largo o más corto de lo que permite el servidor.',
		'merchantcantaccept' => 'El comerciante no acepta los datos introducidos en este campo.',
		'mismatch'           => 'Los datos de uno de los campos no coincide con el del otro.',
	),
	'error' => array
	(
		'cantconnect'        => 'Imposible conectar con la pasarela TrustCommerce. Comprueba tu conexión a Internet y asegura que este en funcionamiento.',
		'dnsfailure'         => 'El programa TCLink no ha sido capaz de resolver los nombres DNS. Asegurate de poder resolver en la maquina.',
		'linkfailure'        => 'La conexión se ha establecido , pero se ha interrumpido antes de que la transacción finalizase.',
		'failtoprocess'      => 'Los servidores del Banco estan fuera de línea por lo que resulta imposible autorizar transacciones. Vuelva a intentarlo dentro de unos minutos, o intentelo con una tarjeta de otra entidad bancaria.',
	),
);