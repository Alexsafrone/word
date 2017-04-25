<?
if ($_POST["registration_f"]){
    emailValid($_POST["email_register"]);
    passwordValid($_POST["password_register"]);
    if(mysqli_num_rows(mysqli_query($CONNECT,"SELECT `id` FROM `users` WHERE `email` = '$_POST[email_register]'"))) {
        message("этот емаил уже занят");
    }
    $confirmCode=randomString(5);
    $_SESSION['confirm']=array(
        "type" => "register",
        "email" => $_POST["email_register"],
        "password" => $_POST["password_register"],
        "code" => $confirmCode
    );
    mail($_POST['email_register'],"регистрация", "$confirmCode");
    redirect("confirm");

}else if ($_POST["login_f"]){
    $md5pass=md5($_POST[password_login]);
    if(!mysqli_num_rows(mysqli_query($CONNECT,"SELECT `id` FROM `users` WHERE `email` = '$_POST[email_login]' AND `password` = '$md5pass'"))) {
        unset($_SESSION['email']);
       message("неверный логин или пароль");
    }else{
        $_SESSION['email']=$_POST[email_login];
        redirect('events');
    }
}else if($_POST["confirm_f"]) {
    if ($_SESSION['confirm']['type'] == register) {
        if ($_SESSION['confirm']['code'] == $_POST['code']) {
            mysqli_query($CONNECT, 'INSERT INTO `users` VALUES ("", "' . $_SESSION['confirm']['email'] . '", "' . md5($_SESSION['confirm']['password']) . '")');


            $create_groups = "CREATE TABLE `".$_SESSION['confirm']['email']."_groups`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    name  text NOT NULL)";
            mysqli_query($CONNECT,$create_groups);

            $create_disciplines = "CREATE TABLE `".$_SESSION['confirm']['email']."_disciplines`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    name  text NOT NULL)";
            mysqli_query($CONNECT,$create_disciplines);

            $create_pupils = "CREATE TABLE `".$_SESSION['confirm']['email']."_pupils`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    group_id INT(6) UNSIGNED, 
                    name  text NOT NULL)";
            mysqli_query($CONNECT,$create_pupils);

            $create_pupil_info = "CREATE TABLE `".$_SESSION['confirm']['email']."_pupil_info`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    pupil_id INT(6) UNSIGNED,
                    photo_path  text,
                    information  text)";
            mysqli_query($CONNECT,$create_pupil_info);

            $create_pupil_materials = "CREATE TABLE `".$_SESSION['confirm']['email']."_materials`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					discipline_id INT(6) UNSIGNED,
                    path text)";
            mysqli_query($CONNECT,$create_pupil_materials);
            mkdir( "./materials/".$_SESSION['confirm']['email']."/", 0777 );
            mkdir( "./materials/".$_SESSION['confirm']['email']."/pupils_photos/", 0777 );

            $create_events = "CREATE TABLE `".$_SESSION['confirm']['email']."_events`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    event_type INT(6) UNSIGNED,
                    discipline_id INT(6) UNSIGNED,
                    group_id INT(6) UNSIGNED,
                    info text,
                    date text,
                    time text)";
            mysqli_query($CONNECT,$create_events);

            $create_marks = "CREATE TABLE `".$_SESSION['confirm']['email']."_marks`(
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    event_id INT(6) UNSIGNED,
                    pupil_id INT(6) UNSIGNED,
                    absent INT(6) UNSIGNED,
                    marks text,
                    info text)";
            mysqli_query($CONNECT,$create_marks);

            unset($_SESSION['confirm']);
            redirect('login');
        } else message("неверный код");
    } else if ($_SESSION['confirm']['type'] == recover) {
        if ($_SESSION['confirm']['code'] == $_POST['code']) {
            $newPassword = randomString(10);
            mysqli_query($CONNECT, 'UPDATE `users` SET `password` = "' . md5($newPassword) . '" WHERE `email` = "' . $_SESSION['confirm']['email'] . '"');
            mail($_SESSION['confirm']['email'],"ВОССТАНОВЛЕНИЕ ПАРОЛЯ", "$newPassword");
            unset($_SESSION['confirm']);
            redirect('login','НОВЫЙ ПАРОЛЬ ОТПРАВЛЕН НА EMAIL');
        }else{ message("неверный код");}
    }
}else if($_POST["recoverPassword_f"]){
    emailValid($_POST["email_recover"]);
    if(!mysqli_num_rows(mysqli_query($CONNECT,"SELECT `id` FROM `users` WHERE `email` = '$_POST[email_recover]'"))) {
        message("пользователя с таким email не существует");
    }
    $confirmCode=randomString();
    $_SESSION['confirm']=array(
        "type" => "recover",
        "email" => $_POST["email_recover"],
        "code" => $confirmCode
    );
    mail($_POST['email_recover'],"ВОССТАНОВЛЕНИЕ ПАРОЛЯ", "$confirmCode");
    redirect("confirm");
}
?>