<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Organizer</title>
    <link rel="stylesheet" href="resource/css/login_register.css">
    <link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">
    <script src='/resource/js/jquery.js'></script>
    <script src="/resource/js/click_script.js"></script>
    <script src='/resource/confirm_alert/jquery-confirm.min.js'></script>
    <script src='resource/js/animation.js'></script>
</head>

<body>
<div class="login-page">
    <div class="form">
        <form class="login-form">
            <input type="text" placeholder="Ваш email пожалуйста?" id="email_recover"/>
            <button type="submit" onclick="postQuery('guestQuery','recoverPassword','email_recover')">Восстановить</button>
            <p class="forget"> <a href="\">На главную</a></p>
        </form>
    </div>
</div>

</body>

</html>