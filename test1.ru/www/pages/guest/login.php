<!DOCTYPE html>
<html >

<head>
     <meta charset="UTF-8">
     <title>Organizer</title>

    <script src='/resource/js/jquery.js'></script>
     <link rel="stylesheet" href="resource/css/login_register.css">
     <script src="/resource/js/click_script.js"></script>
    <link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">

</head>

<body>
<div class="login-page">
  <div class="form">

    <form class="register-form" >
      <input type="text" placeholder="Email" id="email_register"/>
      <input type="password" placeholder="Пароль" id="password_register"/>
      <button type="submit" onclick="postQuery('guestQuery','registration','password_register.email_register')">создать</button>
      <p class="message">Уже зарегестрированы? <a href="#">Войти</a></p>
    </form>

    <form class="login-form">
      <input type="text" placeholder="Email" id="email_login"/>
      <input type="password" placeholder="Пароль" id="password_login"/>
      <button type="submit" onclick="postQuery('guestQuery','login','email_login.password_login')">вход</button>
      <p class="forget"> <a href="recover">Забыли пароль?</a></p>
      <p class="message"><a href="#">Не зарегестрированы?</a></p>
    </form>    

  </div>
</div>
<script src='resource/js/jquery.js'></script>
<script src='resource/js/animation.js'></script>
<script src='/resource/confirm_alert/jquery-confirm.min.js'></script>
</body>

</html>