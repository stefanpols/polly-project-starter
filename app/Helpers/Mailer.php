<?php

namespace App\Helpers;


use PHPMailer\PHPMailer\PHPMailer;
use Polly\Core\Config;
use Polly\Core\Logger;
use Polly\Core\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;


class Mailer
{
    public static function make(string $subject, string $templatePath, array $parameters=[]) : PHPMailer
    {
        $content = View::include($templatePath, $parameters);
        $content = (new CssToInlineStyles())->convert($content,"");

        $mail = new PHPMailer();
        $mail->AddEmbeddedImage(Config::get('site_url').'images/logo.png', 'logo', Config::get('name'));
        $mail->isHTML(true);
        $mail->setFrom(Config::get("mailer")['from_address'], Config::get("mailer")['from_name']);

        $mail->Subject  = utf8_decode($subject);
        $mail->Body     = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

        if(isset(Config::get("mailer",[])['send_copy']))
        {
            foreach(Config::get("mailer")['send_copy'] as $address)
            {
                $mail->addBCC(strtolower($address));
            }
        }

        return $mail;
    }

    public static function send(PHPMailer $mail) : bool
    {
        try
        {
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
