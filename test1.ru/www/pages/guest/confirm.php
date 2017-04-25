<?
if(!$_SESSION['confirm']['code']){
    notFound();
}
?>
<!DOCTYPE html>
<html >

<head>
    <meta charset="UTF-8">
    <title>Organizer</title>
    <link rel="stylesheet" href="resource/css/login_register.css">
    <link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">
    <script src='/resource/js/jquery.js'></script>
    <script src="/resource/js/click_script.js"></script>
    <script src='resource/js/animation.js'></script>
    <script src='/resource/confirm_alert/jquery-confirm.min.js'></script>
</head>

<body>
<div class="login-page">
    <div class="form">
        <form class="login-form">
            <input type="text" placeholder="Код, высланный на email?" id="code"/>
            <button type="submit" onclick="postQuery('guestQuery','confirm','code')">Отправить</button>
        </form>
    </div>
</div>
</body>

</html>