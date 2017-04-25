<?
$uploaddir ="./materials/".$_SESSION['email']."/pupils_photos/";
$itsok;
foreach( $_FILES as $file ){
    if(! move_uploaded_file( $file['tmp_name'], $uploaddir . basename($_POST["id"]) ) ){
        $itsok=0;
    }
    if (!mysqli_query($CONNECT, "UPDATE `".getTable("pupil_info")."` SET `photo_path`='".$uploaddir."/".$_POST[id].
        "' WHERE `pupil_id`='$_POST[id]'")) {
        $itsok=0;
    }else{
        $itsok=$uploaddir."/".$_POST[id];
    }
    message($itsok);
}
?>



