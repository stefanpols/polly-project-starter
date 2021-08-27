<?php

use Polly\Core\Authentication;

?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <base href="<?=site_url()?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/icon-font.min.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
    <?php foreach(get_messages() as $message): ?>
        <?=$message['type']?><br />
        <?=$message['title']?><br />
        <?=$message['description']?><br />
    <?php endforeach; ?>
    <hr />
        <?=translate('current_datetime')?>: <?=datetime_to_text('%A %e %B %T', new \DateTime())?>
    <hr />
    <h1>Menu</h1>
    <ul>
        <li><a href="<?=site_url('index')?>">Home page</a></li>
        <li><a href="<?=site_url('user')?>">User page</a></li>
        <li><a href="<?=site_url('login/destroy')?>">Logout (ingelogd als: <?=Authentication::user()->getUsername()?>)</a></li>
    </ul>
    <hr />
    <h1>Page content</h1>
    <?=$content?>
    <hr />

    <script src="js/main.js"></script>

    <script>
        window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>

    <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>
