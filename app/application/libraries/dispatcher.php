<?php

require_once 'Sender.php';
require_once 'Constants.php';
require_once 'Utils.php';
require_once 'Certification.php';

if(isset($argv)){

       $sender = new Sender();
       $utils  = new Utils();
       $certification = new Certification();

       switch($argv[1]){
		case 'block-account':
			$mailSender = $argv[2];
			$nameSender = $argv[3];
			//Invoke the functions in Sender Object
                        $sender->setSubject(MSG_SUBJECT);
                        $sender->setNameSender($nameSender);
                        $sender->setMail($mailSender);
			//Invoke the Utils Object
			$template    = $utils->getTemplateString(TEMPLATE_BASE);
			$imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
			$imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');

			$newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
			$newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
			$bodyMessage = $utils->replaceValue(PATTERN_USER,$nameSender,MSG_BLOCK_ACCOUNT);
			$newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
			$sender->setMessage($newTemplate);
			echo $sender->triggerSendMail() ? 'INACTIVO' : 'FALLO';
                break;
		case 'enable-account':
			$mailSender = $argv[2];
            $nameSender = $argv[3];
   			//Invoke the functions in Sender Object
                        $sender->setSubject(MSG_SUBJECT);
                        $sender->setNameSender($nameSender);
                        $sender->setMail($mailSender);
			//Invoke the Utils Object
            $template    = $utils->getTemplateString(TEMPLATE_BASE);
			$imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
			$imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');
			$newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
			$newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
			$bodyMessage = $utils->replaceValue(PATTERN_USER,$nameSender,MSG_ENABLE_ACCOUNT);
			$newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
			$sender->setMessage($newTemplate);
			echo $sender->triggerSendMail() ? 'ACTIVO' : 'FALLO';
				break;
		case 'create-certificate':
				//echo $argv[1];	//create-certificate
				//echo $argv[2];	//userid
				//echo $argv[3];	//fullnameuser
				//echo $argv[4];	//curp
				//echo $argv[5];	//courseid
				//echo $argv[6];	//course
				//echo $argv[7];	//stardate
				//echo $argv[8];	//calification 
				//echo $argv[9];	//email
		$urlcertificate = $certification->saveCertificate($argv[2],$argv[3],$argv[4],$argv[5],$argv[6],$argv[7],$argv[8]);
			if(!$urlcertificate){
				echo "FALLO";
			}else{
				$mailSender = $argv[9];
          		$nameSender = $argv[3];
          		$namecourse = $argv[6];
          		//Invoke the functions in Sender Object
          		$sender->setSubject(MSG_SUBJECT_CERTIFICATE);
          		$sender->setNameSender($nameSender);
          		$sender->setMail($mailSender);
          		//Invoke the Utils Object
          		$template    = $utils->getTemplateString(TEMPLATE_BASE);
          		$imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
          		$imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');
          		$newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
          		$newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
          		$searchparams = array(PATTERN_USER, PATTERN_COURSE, PATTERN_URL_CERTIFICATE);
				$replaceparams   = array($nameSender, $namecourse, $urlcertificate);
                $bodyMessage = $utils->replaceValue($searchparams,$replaceparams,MSG_CERTIFICATE);
                $newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
                $sender->setMessage($newTemplate);
                $sender->triggerSendMail();
			}
		break;

		case 'course-reprobate':
			$mailSender = $argv[9];
			$nameSender = $argv[3];
			$namecourse = $argv[6];
			//Invoke the functions in Sender Object
					$sender->setSubject(MSG_SUBJECT_REPROBATE);
					$sender->setNameSender($nameSender);
					$sender->setMail($mailSender);
			//Invoke the Utils Object
			$template    = $utils->getTemplateString(TEMPLATE_BASE);
			$imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
			$imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');
			$newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
			$newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
			$searchparams = array(PATTERN_USER, PATTERN_COURSE);
			$replaceparams   = array($nameSender, $namecourse);
			$bodyMessage = $utils->replaceValue($searchparams,$replaceparams,MSG_REPROBATE);
			$newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
			$sender->setMessage($newTemplate);
			$sender->triggerSendMail();
		break;
		
		case 'moodle-mail':
			//echo $argv[1];	//moodle_mail
			//echo $argv[2];	//userid
			//echo $argv[3];	//fullnameuser
			//echo $argv[4];	//email
			//echo $argv[5];	//subject
			//echo $argv[6];	//messagetext
			
				$mailSender = $argv[4];
				$nameSender = $argv[3];
				$moodleSubject = $argv[5];
				$messagetext = $argv[6];
				//Invoke the functions in Sender Object
						$sender->setSubject($moodleSubject." Aula Virtual PROCADIST");
						$sender->setNameSender($nameSender);
						$sender->setMail($mailSender);
				//Invoke the Utils Object
				$template    = $utils->getTemplateString(TEMPLATE_BASE);
				$imageHeader = $utils->getImageBase64(IMG_HEADER,'image/png');
				$imageFooter = $utils->getImageBase64(IMG_FOOTER,'image/png');
				$newTemplate = $utils->replaceValue(PATTERN_IMG_HEAD,$imageHeader,$template);
				$newTemplate = $utils->replaceValue(PATTERN_IMG_FOOT,$imageFooter,$newTemplate);
				$searchparams = array(PATTERN_USER, PATTERN_MOODLE_CONTENT,);
				$replaceparams   = array($nameSender, $messagetext);
				$bodyMessage = $utils->replaceValue($searchparams,$replaceparams,MSG_WELCOME);
				$newTemplate = $utils->replaceValue(PATTERN_BODY,$bodyMessage,$newTemplate);
				$sender->setMessage($newTemplate);
				$sender->triggerSendMail();
			break;
	}
}

?>
