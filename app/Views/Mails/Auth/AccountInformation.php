<?php

use Polly\Core\Config;

?>
<?= view("Mails/Header"); ?>



<p style="margin-bottom: 20px; padding-bottom:0; font-size: 17px;">
    <strong style="color:#000;">Beste <?=$user->getName()?>,</strong>
</p>
<p style="margin-bottom: 20px">Er zijn nieuwe accountgegevens beschikbaar voor <strong><?=$user->getUsername()?></strong>. Het nieuwe wachtwoord waarmee ingelogd kan worden is:</p>
<div style="margin-bottom: 20px; margin-top:10px; margin-bottom:10px; text-align:center;background: #3385b7;"><p style="padding:10px; line-height:30px; text-align:center; color: #fff;font-weight: bold;"><?=$password?></p></div>
<p style="margin-bottom: 30px;">Log in op <a href="<?=site_url('/')?>" style="color:#e41b12;" rel="noopener" target="_blank"><?=Config::get('name')?></a> met je gebruikersnaam en wachtwoord om het wachtwoord te wijzigen. De gebruikersnaam is gelijk aan het e-mail adres.</p>
<p style="margin-bottom: 10px;">
    Met vriendelijke groet, <br>
    Janssen Keuringsbedrijf B.V.
</p>



<?= view("Mails/Footer"); ?>
