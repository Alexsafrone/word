<?
include 'settings.php';

if($_SERVER['REQUEST_URI'] == '/'){
    $page = 'login';
}else{
    $page = substr($_SERVER['REQUEST_URI'] , 1);
	}

$CONNECT = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
if(!$CONNECT){message("нет подключнеия к бд");}

session_start();

if($_SESSION['email'] and file_exists('pages/user/'.$page.'.php')){
    include 'pages/user/'.$page.'.php';
}else if(file_exists('pages/guest/'.$page.'.php')){
    include 'pages/guest/'.$page.'.php';
}else  include 'pages/guest/error404.php';

//отправка ответа в формате json
function message($message){
    exit('{"message" : "'.$message.'"}');
}

//отправка ответа в формате json который должен быть перенаправлен на адрес
function redirect($url, $alert=null){
    if($alert){
        exit('{"redirect" : "'.$url.'", "alert" : "'.$alert.'"}');
    }else{
        exit('{"redirect" : "'.$url.'"}');
    }
}

//проверка валидности email
function emailValid($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        message("неверный формат email");
    }
}

//проверка валидности пароля
function passwordValid($password){
    if(!preg_match('/^[A-z0-9]{4,30}$/',$password)){
        message("неверный формат пароля");}
}

//рандомная строка для проверки
function randomString($number = 30){
    return substr(str_shuffle("abcdefghigklmnopqrstuvwxyz1234567890ABCDEFGHIGKLMNOPQRSTUVWXYZ"),0, $number);
}

function notFound(){
    exit(include 'pages/guest/error404.php');
}

//отправка ответа в формате json
function success($val){
    exit('{"result" : "'.$val.'"}');
}

function keyValueAnswer($arr){
   exit (json_encode($arr));
}


function getTable($name){
        return $_SESSION['email']."_".$name;

}

function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }

?>