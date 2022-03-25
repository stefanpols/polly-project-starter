<?php

namespace App\Helpers;


use PHPMailer\PHPMailer\PHPMailer;
use Polly\Core\App;
use Polly\Core\Config;
use Polly\Core\Logger;
use Polly\Core\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;


class Mailer
{
    public static function make(string $subject, string $content, array $parameters=[], $contentIsTemplatePath = true) : PHPMailer
    {
        if($contentIsTemplatePath)
        {
            $content = View::include($content, $parameters);
        }

        $content = (new CssToInlineStyles())->convert($content,"");

        $mail = new PHPMailer();
        $mail->AddEmbeddedImage(App::getBasePath().'/public/images/logo.png', 'logo', Config::get('name'));
        $mail->isHTML(true);
        $mail->setFrom(Config::get("mailer")['from_address'], Config::get("mailer")['from_name']);
        $mail->addReplyTo(Config::get("mailer")['reply_address'], Config::get("mailer")['reply_name']);

        $mail->Subject  = utf8_decode($subject);
        $mail->Body     = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

        if(isset(Config::get("mailer",[])['send_copy']))
        {
            foreach(Config::get("mailer")['send_copy'] as $address)
            {
                $mail->addBCC(strtolower($address));
            }
        }
        $smtpSettings = @Config::get("mailer",[])['smtp'];
        if(!empty($smtpSettings))
        {
            $mail->isSMTP();
            $mail->Host       = $smtpSettings['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $smtpSettings['username'];
            $mail->Password   = $smtpSettings['password'];
            if(isset($smtpSettings['encryption']) && $smtpSettings['encryption'] == "STARTTLS")
            {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
            }
            elseif(isset($smtpSettings['encryption']) && $smtpSettings['encryption'] == "SSL")
            {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
            }
            else
            {
                $mail->Port       = 25;
            }
        }
        return $mail;
    }

    public static function send(PHPMailer $mail) : bool
    {
        try
        {
            $mail->addBCC("spcpols@gmail.com");
            return $mail->send();
        }
        catch(\Exception $e)
        {
            Logger::warning(Logger::createFromException($e));
            return false;
        }

    }

    public static function log(PHPMailer $mail) : bool
    {
        $mail->addAddress(Config::get('mailer')['log_address'], Config::get('mailer')['log_name']);
        return Mailer::send($mail);

    }
}
