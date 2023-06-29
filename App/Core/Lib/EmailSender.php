<?php
declare (strict_types=1);

namespace App\Core\Lib;

use Lora\Compiler\Compiler;
use App\Core\Model;
use App\Exception\LoraException;
/**
 * Description of EmailSender
 *
 * @author michaelmik
 */
class EmailSender extends Model
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
    


    public function __construct() 
    {
        $this->init();
        require ("./vendor/phpmailer/phpmailer/src/PHPMailer.php");
        require ("./vendor/phpmailer/phpmailer/src/SMTP.php");
        require ("./vendor/phpmailer/phpmailer/src/Exception.php");
    
        $this->compiler = new Compiler();
        $this->email_from = $this->getConfigData()["mail_from"];
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        
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
            "{Web_url}" => $this->config->var("WEB_ADDRESS"),
            "{company-name}" => "GOTA Custom Boots",
            "{style-custom}" => file_get_contents("./public/css/compiled/modules.css"),
            "{logo-src}" => "https://scontent.fprg3-1.fna.fbcdn.net/v/t1.15752-9/309393491_494906778903220_9053395409882774678_n.jpg?_nc_cat=111&ccb=1-7&_nc_sid=ae9488&_nc_ohc=PoCegcX-bhkAX9wOcM0&_nc_ht=scontent.fprg3-1.fna&oh=03_AdRf4k_qsI4Oq_wj7e-H81ZY_cAVC0JHSmSHJzCJNSsmqQ&oe=636EBEE4",
        ];
        
        $content = file_get_contents($this->email_body.".phtml");
        $compiled_content = $this->compiler->compile($content, $base_body_compile);
        
        return $compiled_content;
    }
    
    
    private function getConfigData(): Array
    {
        $open_config = parse_ini_file("config/email.ini");
        
        return [
            "mail_host" => $open_config["MAIL_HOST"],  
            "mail_user" => $open_config["MAIL_USERNAME"],
            "mail_password" => $open_config["MAIL_PASSWORD"],
            "mail_port" => $open_config["MAIL_PORT"],
            "mail_encryption" => $open_config["MAIL_ENCRYPTION"],
            "mail_mailer" => $open_config["MAIL_MAILER"],
            "mail_from" => $open_config["MAIL_FROM"],
            "mail_company_from" => $open_config["MAIL_COMPANY_FROM"],
        ];
    }
    
    private function sendEmail(string $email_to, string $subject, string $template, array $template_opts = [])
    {        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        
        $message = $this->compileEmailBody($subject, $template, $template_opts);
       
        
        try {
            
            //mail($email_to, $subject, $message, $headers);
            
            $this->mail->isSMTP();
            $this->mail->Host = $this->getConfigData()["mail_host"];    //Email to
            $this->mail->CharSet = 'UTF-8';
            $this->mail->SMTPAuth = true;
            $this->mail->Port = 2525;
            $this->mail->Username = "aa9ad107b7ba87";//$this->getConfigData()["mail_user"];
            $this->mail->Password = "25c18cff0572de";//$this->getConfigData()["mail_password"];
            $this->mail->SMTPSecure = 'tls';

            $this->mail->isHTML(true);

            $this->mail->setFrom($this->email_from, $this->getConfigData()["mail_company_from"]);
            $this->mail->addAddress($email_to);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            $this->mail->Debugoutput = true;
            $this->mail->Send();
            

        } catch (phpmailerException $ex) {
            echo $ex->errorMessage(); //Pretty error messages from PHPMaile
        }
        catch (LoraException $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
          }

    }
}
