<html>
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
    <link rel="stylesheet" href="css/login.css">

    <meta name="theme-color" content="#fafafa">
</head>
<body class="text-center">

    <?=view('Messages/Messages')?>

    <main class="form-signin">
        <form method="post" action="<?=site_url('login/try/'.(isset($_GET['origin']) ? '?origin='.$_GET['origin'] : ''))?>">
            <img class="mb-4" src="images/logo.svg" alt="" width="200">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="email" name="username" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?=date('Y')?></p>
        </form>
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
