<?php
declare (strict_types=1);

namespace App\Core\Lib;

use App\Core\DI\DIContainer;
use Lora\Compiler\Compiler;
use App\Exception\LoraException;
/**
 * Description of EmailSender
 *
 * @author michaelmik
 */
class EmailSender
{
    /**
     * 
     * @var string <p>Template path destination</p>
     */
    public string $template_path = "./resources/templates/emailsender";

    /**
     * Email body
     * @var string
     */
    public string $email_body = "./resources/templates/emailsender/emailbody";
    
    /**
     * 
     * @var string <p>Template File suffix (default: "phtml")</p>
     */
    public $template_extension = "phtml";
    
    
    protected $compiler;
    protected $email_from;
    protected $mail;

    private $exception;
    


    public function __construct(DIContainer $container, Compiler $compiler, LoraException $exception) 
    {
        if($_ENV["mail_plugin"] == "phpmailer")
        {
            require_once ("./vendor/phpmailer/phpmailer/src/PHPMailer.php");
            require_once ("./vendor/phpmailer/phpmailer/src/SMTP.php");
            require_once ("./vendor/phpmailer/phpmailer/src/Exception.php");
            $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        }
        
        $this->compiler = $compiler;
        $this->email_from = $_ENV["mail_from"];

        $this->exception = $exception;
    }
    
    /**
     * 
     * @param string $email_to <p>Email To</p>
     * @param string $subject
     * @param string $template
     * @param array $template_opts
     * @return void
     */
    public function send($email_to, $subject, $template, $template_opts = [])
    {        
        return $this->sendEmail($email_to, $subject, $template, $template_opts);
    }
    
    private function compileEmailBody(string $subject, string $template, array $message_compile_opts = [])
    {
        $message_content = file_get_contents($this->template_path."/".$template.".".$this->template_extension);
        
        
        $compiled_message = $this->compiler->compile($message_content, $message_compile_opts);
        
        $base_body_compile = [
            "{subject}"=> $subject,
            "{message}" => $compiled_message,
            "{from}" => $this->email_from,
            "{style}" => "<link rel='stylesheet' href='https:shoesby.eu/public/css/stylize.css'>",
            "{Web_url}" => $_ENV["base_href"],
            "{company-name}" => $_ENV["web_name"],
            "{style-custom}" => file_get_contents("./public/css/stylize.css"),
            "{logo-src}" => $_ENV["mail_main_logo"],
        ];
        
        $content = file_get_contents($this->email_body.".phtml");
        $compiled_content = $this->compiler->compile($content, $base_body_compile);
        
        return $compiled_content;
    }
    
    private function sendEmail(string $email_to, string $subject, string $template, array $template_opts = [])
    {        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
        $message = $this->compileEmailBody($subject, $template, $template_opts);
       
        if($_ENV["mail_plugin"] == "phpmailer")
        {
            try {
                
                $this->mail->isSMTP();
                $this->mail->Host = $_ENV["mail_host"];   //Email to
                $this->mail->CharSet = $_ENV["mail_charset"];
                $this->mail->SMTPAuth = true;
                $this->mail->Port = $_ENV["mail_smtp_port"];
                $this->mail->Username = $_ENV["mail_user"];
                $this->mail->Password = $_ENV["mail_password"];
                $this->mail->SMTPSecure = $_ENV["mail_smtp_secure"];

                $this->mail->isHTML(true);

                $this->mail->setFrom($this->email_from, $_ENV["mail_from"]);
                $this->mail->addAddress($email_to);
                $this->mail->Subject = $subject;
                $this->mail->Body = $message;
                $this->mail->Debugoutput = true;
                $this->mail->Send();
                

            } catch (LoraException $ex) {
                $this->exception->errorMessage($ex->getMessage()); //Pretty error messages from PHPMaile
            }
        }
        else
        {
            try {
                mail($email_to, $subject, $message, $headers);
            }catch (LoraException $ex) {
                $this->exception->errorMessage($ex->getMessage()); //Pretty error messages from PHPMaile
            }
        }

    }
}
