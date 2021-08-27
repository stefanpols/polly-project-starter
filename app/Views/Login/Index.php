<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Login template</h1>
    <?php foreach(get_messages() as $message): ?>
        <?=$message['type']?><br />
        <?=$message['title']?><br />
        <?=$message['description']?><br />
    <?php endforeach; ?>
    <form method="post" action="<?=site_url('login/try/'.(isset($_GET['origin']) ? '?origin='.$_GET['origin'] : ''))?>">
        <input type="text" name="username" placeholder="Username" />
        <input type="password" name="password" value="" placeholder="Password" />
        <button type="submit">inloggen</button>
    </form>

</body>

</html>
