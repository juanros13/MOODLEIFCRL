<?php

class Helper
{

    /**
     * verifica si la petición se realiza mendiante una llamada ajax
     * @return bool verdadero en caso de que la petición sea mediante ajax
     */
    static public function chekIsAjax()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Envia un correo electronico con el mensaje y los datos para continuar el registro respondiendo la encuesta Honey-Alonso
     * @param  integer $userId      id del usuario en la tabla mdl_user
     * @param  string $fullName    Nombre completo con apellidos
     * @param  string $encuestaUrl url unica del enlace a la ecuesta Honey-Alonso
     * @param  string $email       dirección de correo electronico
     * @return boolean              retorna true en caso de exito
     */
    static public function sendRegistroEmail($userId, $fullName, $encuestaUrl, $email)
    {
        require_once 'Constants.php';
        require_once 'Sender.php';
        require_once 'Utils.php';

        $sender = new Sender();
        $utils  = new Utils();

        $link = '<a href="' . $encuestaUrl . '">' . $encuestaUrl . '</a>';
        $sender->setSubject(MSG_SUBJECT_ADD_ACCOUNT);
        $sender->setNameSender($fullName);
        $sender->setMail($email);
        //Invoke the Utils Object
        $template    = $utils->getTemplateString(TEMPLATE_BASE);
        $imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
        $imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');
        $newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
        $newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
        $bodyMessage = $utils->replaceValue(PATTERN_USER,$fullName,MSG_REG);
        $bodyMessage = $utils->replaceValue(PATTERN_LINK,$link,$bodyMessage);
        
        //Tramite concluido
        $bodyMessage.="<br /><p>El tr&aacute;mite de registro ha conclu&iacute;do.</p>";

        $newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
        $sender->setMessage($newTemplate);

       return $sender->sendMail();
    }

    /**
     * Envia un correo con el template definido en Constants.php
     * @param string $to        Email a donde sera enviado el correo
     * @param string $fullName  Nombre del destiniatario
     * @param string $subject   Mensaje del asunto
     * @param string $message   Mensaje del cuerpo del correo
     * @param string $file      (Opcional) Ruta del fichero a ser adjuntado
     * @return boolean          retorna true en caso de exito
     */
    static public function sendGenericEmail($to, $fullName, $subject, $message, $file = '')
    {
        require_once 'Constants.php';
        require_once 'Sender.php';
        require_once 'Utils.php';

        $sender = new Sender();
        $utils  = new Utils();

        $sender->setSubject($subject);
        $sender->setNameSender($fullName);
        $sender->setMail($to);
        if (file_exists($file)) {
            $sender->setAttachment($file);
        }
        //Invoke the Utils Object
        $template    = $utils->getTemplateString(TEMPLATE_BASE);
        $imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
        $imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');
        $newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
        $newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
        $bodyMessage = $message;

        $newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
        $sender->setMessage($newTemplate);

       return $sender->sendMail();
    }

    /**
     * Escribe una lista de scripts definida en un arreglo
     * @param  Array $scripts Arreglo con los nombres de los scripts a ser cargados
     */
    static public function loadScripts($scripts = [])
    {
        foreach ($scripts as $script) {
            echo "<script type='text/javascript' src='" . URL . $script . "'></script>\n";
        }
    }

    /**
     * Obtiene la ip real del contexto donde se llama la función
     * @return mixied   cadena con la ip o null si no se pudo obtener
     */
    public static function getIp()
    {
        // Variables locales
        $userIp = null;

        // Identificando Ip dependiendo de las variables del browser
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            if (isset( $_SERVER ['HTTP_VIA'] )) {
                $userIp = $_SERVER ['HTTP_VIA'];
            } else {
                if (isset( $_SERVER ['REMOTE_ADDR'] )) {
                    $userIp = $_SERVER ['REMOTE_ADDR'];
                }
            }
        }

        return $userIp;
    }

    public static function getContext()
    {
        $context = null;

        if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SERVER_NAME'])) {
            $context = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        }

        return $context;
    }

    /**
     * METHOD: saveInfoPage
     *
     * Guarda infomación de seguimiento en cada una de las páginas donde sea invocada
     */
    static public function saveInfoPage()
    {
        require APP . '/libs/TrafficTracker.php';
        require APP . '/model/TrafficTrackerModel.php';

        // trata de obtener el último registro con la ip actual, en caso contrario retorna falso
        $lastTrackingInfo = TrafficTrackerModel::getTrackingInfo(self::getIp());

        // si ya existe un registro ahora se comprueba si este fue creado en el mismo día,
        // solo se agregan nuevos registros a la base de datos si las visitas no son del mismo día
        if ($lastTrackingInfo) {
            $ip         = $lastTrackingInfo[0]['ip']; // ip del último registro
            $lastDay    = new DateTime($lastTrackingInfo[0]['timecreated']); // fecha del último registro
            $currentDay = new DateTime(); // fecha actual
            $context    = $lastTrackingInfo[0]['context']; // contexto del último registro
            $currentContext = self::getContext(); // contexto actual
            $interval   = $lastDay->diff($currentDay)->format('%R%a'); // diferencia de fechas

            // echo '<pre>';
            // var_dump($ip);
            // var_dump($lastDay);
            // var_dump($currentDay);
            // var_dump($context);
            // var_dump($currentContext);
            // var_dump($interval);
            // echo '</pre>';

            // if ($interval === '+0' && $currentContext === $context) {
            //     echo '<pre>';var_dump('No graba');echo '</pre>';
            // } else {
            //     $tracker = new TrafficTracker();
            //     $tracker->setAll();
            //
            //     TrafficTrackerModel::saveTrackingInfo($tracker->getAll());
            //     echo '<pre>';var_dump('Si graba');echo '</pre>';
            // }

            // if ($interval !== '+0' && $currentContext !== $context) {
            //     echo '<pre>';var_dump('Si graba');echo '</pre>';
            // }

            if ($interval === '+0' && $currentContext !== $context) {
                $tracker = new TrafficTracker();
                $tracker->setAll();

                TrafficTrackerModel::saveTrackingInfo($tracker->getAll());
            }

        } else {
            // tambien se debe generar un nuevo registro si no existe ninguno asociado a esa ip
            $tracker = new TrafficTracker();
            $tracker->setAll();

            TrafficTrackerModel::saveTrackingInfo($tracker->getAll());
        }

    }

}
