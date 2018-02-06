<?php

define('TEMPLATE_BASE', 'TemplateBase.html', true);
define('IMG_HEADER', 'header.png', true);
define('IMG_FOOTER', 'footer.jpg', true);

//Subject
define('MSG_SUBJECT','Notificación de Aula Virtual PROCADIST');
define('MSG_SUBJECT_ADD_ACCOUNT','Notificación de Registro Aula Virtual PROCADIST');
define('MSG_SUBJECT_CERTIFICATE','Notificación de Certificado Aula Virtual PROCADIST');
define('MSG_SUBJECT_REPROBATE','Notificación de No Aprobado Aula Virtual PROCADIST');


//Cuerpo de mensajes Encuesta Honey
//define('MSG_SURVEY_HONEY', 'Estimado(a) participante <br> Con la finalidad de conocer tu estilo de aprendizaje A DISTANCIA TE PEDIMOS CONTESTAR el SIGUIENTE cuestionario. ES MUY IMPORTANTE QUE CONTESTES TODAS LAS PREGUNTAS QUE APARECEN EN ÉL Y QUE LO HAGAS DE MANERA VERÍDICA. EL CUESTIONARIO SÓLO LO CONTESTARÁS UNA VEZ Y HASTA NO COMPLETARLO, NO SERÁ POSIBLE QUE PUEDAS INSCRIBIRTE A UN CURSO EN EL PROCADIST. <br> Para CONTESTAR el cuestionario da clic en el SIGUIENTE enlace:enlace []', true);

//Cuerpo de mensajes Bloque/Desbloqueo Usuarios
define('MSG_BLOCK_ACCOUNT', '<h4>Estimado(a) ${username}</h4><p>Tu cuenta está inactiva, favor de contactar al administrador del sistema mediante el correo () para cualquier aclaración o duda.</p>', true);
define('MSG_ENABLE_ACCOUNT', '<h4>Estimado(a) ${username}</h4><p>Tu cuenta se ha reactivado, puedes acceder al PROCADIST en el siguiente enlace [] para matricularte en el curso de tu preferencia.</p>', true);
//Mensaje de aprobado
define('MSG_CERTIFICATE', '<h4>Estimado(a) ${username}</h4><p>Tu has aprobado el curso de ${course}, podrás obtener tu certificado al dar click en el siguiente link.<br> ${urlcertificate}</p>', true);
//Mensaje de no aprobado
define('MSG_REPROBATE', '<h4>Estimado(a) ${username}</h4><p>Tu no has aprobado el curso de ${course}, tu calificación debe ser mayor o igual a 8 para aprobar.</p>', true);
//Mensaje de registro



define('MSG_REG', '<h4>Estimado(a) ${username}</h4> <p> Te damos la bienvenida al Aula Virtual del PROCADIST. No olvides que para ingresar a la plataforma debes usar el correo y la contraseña que acabas de registrar al llenar la cédula de datos generales.</p>  <p>El siguiente paso consiste en determinar tu estilo de aprendizaje, ello con la idea de asegurar que tu aprendizaje sea el más adecuado a tus necesidades. Da clic en el siguiente enlace para contestar el cuestionario (no te tomará más de algunos minutos y sólo respondes la primera vez que ingresas a la plataforma del Aula Virtual):</p>  <p>${enlace}</p> <p>Te recomendamos que actualices tus datos periódicamente y que la primera vez que entres a la plataforma actualices tu perfil; así como también leer la Guía del Usuario para que conozcas los detalles del Aula Virtual. Puedes consultarla en este enlace:</p> <p><a href="http://www.procadist.gob.mx/portal/files/GUIA-PROCADIST.pdf" target="_blank">Guía de Usuario</a></p>', true);
//Mensaje de registro
define('MSG_WELCOME', '<h4>Estimado(a) ${username}</h4><p>${moodleContent}</p>', true);

define('PATTERN_USER','${username}',true);
define('PATTERN_COURSE','${course}',true);
define('PATTERN_URL_CERTIFICATE','${urlcertificate}',true);
define('PATTERN_IMG_HEAD','${imageHead}',true);
define('PATTERN_IMG_FOOT','${imageFoot}',true);
define('PATTERN_BODY','${bodyMessage}',true);
define('PATTERN_LINK','${enlace}',true);
define('PATTERN_MOODLE_CONTENT','${moodleContent}',true);

// Mail...
if (!defined('MAIL_HOST')) {
	define('MAIL_HOST', '172.16.50.81');
	//define('MAIL_HOST', 'localhost');
	define('MAIL_PORT', '25');
	define('MAIL_USER', 'smtpstps');
	define('MAIL_PASS', '546MPUpsa9');
	define('MAIL_FROM', 'smtpstps@stps.gob.mx');
}
?>
