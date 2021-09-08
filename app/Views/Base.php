<?php

use Polly\Core\App;
use Polly\Core\Authentication;
use Polly\Core\Request;
use Polly\Core\Router;
use Polly\Helpers\Str;

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

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/app.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>

    <?=view('Messages/Messages')?>

    <header id="app-header">
        <span class="w-50 "><?=translate('current_datetime')?>: <?=datetime_to_text('%A %e %B %T', new \DateTime())?></span>
        <span class="w-50 text-end">User: <?=Authentication::user()->getUsername()?></span>

    </header>

    <main>
        <div id="main-nav" class="" style="width: 280px;">
            <span class="fs-4 text-white">Navigation</span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">

                <li class="nav-item">
                    <a href="<?=site_url('index')?>" class="nav-link <?=Str::contains(Request::getUrl(), '/index') ? 'active' : 'text-white'?>" aria-current="page">
                        <i class="bi bi-house me-2"></i> Home
                    </a>
                </li>
                <li>
                    <a href="<?=site_url('user')?>" class="nav-link <?=Str::contains(Request::getUrl(), '/user') ? 'active' : 'text-white'?>">
                        <i class="bi bi-people me-2"></i>
                        User
                    </a>
                </li>
                <li>
                    <a href="<?=site_url('login/destroy')?>" class="nav-link text-white">
                        <i class="bi bi-unlock me-2"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div id="app">
            <div class="app-body">
                <?=$content?>
            </div>
        </div>
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto'); ga('set', 'anonymizeIp', true); ga('set', 'transport', 'beacon'); ga('send', 'pageview')
    </script>

    <script src="https://www.google-analytics.com/analytics.js" async></script>

</body>

</html>
