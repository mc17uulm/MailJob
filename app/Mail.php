<?php
/**
 * Created by PhpStorm.
 * User: mc17uulm
 * Date: 17.01.2019
 * Time: 14:35
 */

namespace app;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{

    private $mail;

    public function __construct(string $subject, array $files)
    {

        $this->mail = new PHPMailer(true);

        try{

            $this->mail->isSMTP();
            $this->mail->Host = Config::get_host();
            $this->mail->SMTPAuth = true;
            $this->mail->Username = Config::get_user();
            $this->mail->Password = Config::get_password();
            if(Config::get_tls())
            {
                $this->mail->SMTPSecure = 'tls';
            }

            $this->mail->Port = Config::get_port();
            $this->mail->setFrom(Config::get_from_mail(), Config::get_from_name());
            $this->mail->addReplyTo(Config::get_from_mail(), Config::get_from_name());
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->CharSet = "utf-8";
            $this->mail->Encoding = "base64";

            if(count($files) > 0)
            {
                foreach($files as $file)
                {
                    $this->mail->addAttachment($file);
                }
            }

            echo "- Connected to mail server\r\n";

        } catch (Exception $e)
        {
            die("ERROR: Connection to mail server failed. Error Msg: " . $e->getMessage());
        }
    }

    public function send(string $to_mail, string $to_name, string $body) : bool
    {

        try{

            $mail = clone $this->mail;

            $mail->addAddress($to_mail, $to_name);
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();

            echo "Successfully send mail to $to_name ($to_mail)\r\n";
            return true;

        } catch (Exception $e)
        {
            echo "Failure in sending mail: " . $e->getMessage() . "\r\n";
            return false;
        }

    }

}