<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . "third_party/phpmailer/class.phpmailer.php"; //php smtp mailer library
class Smtp_email{

    protected $CI;
   /* var $host = 'tulia.tech',
        $from_mail = 'noreply@tulia.tech',
        $mail_pwd = 'GR}7EVB)5qH6',
        $port = 587,
        $from_name = 'Tulia';*/

    var $host = 'mindiii.com',
        $from_mail = 'test@mindiii.com',
        $mail_pwd = 'Ch@ML7!s-R@+',
        $port = 587,
        $from_name = 'Tulia';

    public function __construct(){

        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->Host = $this->host;
        $this->mail->SMTPAuth = true;
        //$mail->SMTPSecure = "ssl";
        $this->mail->Port = $this->port;
        $this->mail->Username = $this->from_mail;
        $this->mail->Password = $this->mail_pwd;
        $this->mail->From = 'test@mindiii.com';
        $this->mail->FromName = $this->from_name;
    }

    public function send_mail($to,$subject,$message){
        
        $this->mail->AddAddress($to); //change it to yours
        //$mail->AddReplyTo("mail@mail.com");
        $this->mail->IsHTML(true);        //keep this true
        $this->mail->Subject = $subject;
        $this->mail->Body = $message; 
        
        if(!$this->mail->Send()){
            return FALSE;       // for debug-   $mail->ErrorInfo;
        }
        return TRUE;

    }
    
}