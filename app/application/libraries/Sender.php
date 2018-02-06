<?php

Class Sender {

    /**
     * @var string $from
     */
    protected $_from;

    /**
     * @var string $to
     */
    protected $_to;

    /**
     * @var string $subject
     */
    protected $_subject;

    /**
     * @var string $message
     */
    protected $_message;

    /**
     * @var string $mail object to PHPMailer
     */
    protected $_mail;

    /**
     * @var string $email
     */
    protected $_email;

    /**
     * @var string $_nameSender
     */
    protected $_nameSender;

    /**
     * @var string $_attachFile ruta del archivo a ser adjuntado
     */
    protected $_attachFile = false;

    public function __construct()
	{
        require_once 'Constants.php';
        require_once 'PHPMailer/PHPMailerAutoload.php';

        try {

               $this->_mail = new PHPMailer(true);
               // Se integran opciones de conexión con el servidor de STPS
               $this->_mail->IsSMTP();
               //$this->_mail->SMTPAuth = true;
               $this->_mail->Port = MAIL_PORT;
               $this->_mail->Host = MAIL_HOST;
               //Credenciales de Acceso
               $this->_mail->Username = MAIL_USER;
               $this->_mail->Password = MAIL_PASS;

               $this->setFrom(MAIL_FROM);

        } 
		catch (phpmailerException $e) {
			  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} 
		catch (Exception $e) {
			  echo $e->getMessage(); //Boring error messages from anything else!
		}
    }

    public function __destruct()
	{}

    /**
     * @methods Getters y Setters
     **/
    public function setFrom($from)
	{
        $this->_from = $from;
    }

    public function getFrom()
	{
        return $this->_from;
    }

    public function setTo($to)
	{
        $this->_to = $to;
    }

    public function getTo()
	{
        return $this->_to;
    }

    public function setSubject($subject)
	{
        $this->_subject = $subject;
    }

    public function getSubject()
	{
        return $this->_subject;
    }

    public function setMessage($message)
	{
        $this->_message = $message;
    }

    public function getMessage()
	{
        return $this->_message;
    }

    public function setMail($email)
	{
        $this->_email = $email;
    }

    public function getMail()
	{
        return $this->_email;
    }

    public function setNameSender($name)
	{
        $this->_nameSender = $name;
    }

    public function getNameSender()
	{
        return $this->_nameSender;
    }

    public function setAttachment($path)
    {
        $this->_attachFile = $path;
    }

    public function getAttachment()
    {
        return $this->_attachFile;
    }

    public function sendMail()
	{
        $this->_mail->AddReplyTo($this->getFrom(), "Aula Virtual PROCADIST");
        $this->_mail->SetFrom($this->getFrom(),'Aula Virtual PROCADIST');
        $this->_mail->AddAddress($this->getMail(), $this->getNameSender());
        $this->_mail->Subject = $this->getSubject();
        $this->_mail->MsgHTML($this->getMessage());
        if ($this->getAttachment()) {
            
            $explode = explode(",",$this->getAttachment());
            if(count($explode) === 1)
            {
                $this->_mail->addAttachment($this->getAttachment());    
            }
            else{

                for($i = 0; $i < count($explode); $i++ ){
                    $this->_mail->AddAttachment($explode[$i]);
                }
            }
            
        }
        $this->_mail->IsHTML(true);
        $this->_mail->CharSet = "UTF-8";
	
		$this->_mail->Send();
		
		return true;
    }

    public function triggerSendMail()
	{
            $this->_mail->AddReplyTo($this->getFrom(), "Aula Virtual PROCADIST");
            $this->_mail->SetFrom($this->getFrom(),'Aula Virtual PROCADIST');
            $this->_mail->AddAddress($this->getMail(), $this->getNameSender());
            $this->_mail->Subject = $this->getSubject();
            $this->_mail->MsgHTML($this->getMessage());
            $this->_mail->IsHTML(true);
            $this->_mail->CharSet = "UTF-8";
			$this->_mail->Send();
			return 'true';

    }
}
