<?
$uploaddir ="./materials/".$_SESSION['email']."/".$_POST["id"]."/";
if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
$itsok=1;
    foreach( $_FILES as $file ){
		$translit_name=translit($file['name']);
		$temp_filename=$translit_name;
		$number=1;
		while((mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `".getTable("materials")."` WHERE `discipline_id` = '$_POST[id]' AND `path`='$temp_filename'")))){
			$temp_filename="(".$number.")_".$translit_name;
			$number=$number+1;
		}
        if( move_uploaded_file( $file['tmp_name'], $uploaddir .$temp_filename ) ) {
            $files[] = realpath($uploaddir .$temp_filename);
             mysqli_query($CONNECT, 'INSERT INTO `'.getTable("materials").'` VALUES ("","'.$_POST[id].'","'.$temp_filename.'")');
        }else{
            $itsok = 0;
        }
    }
success($itsok);

?>



