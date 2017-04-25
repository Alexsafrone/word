<?

if ($_POST["newGroup_f"]){
    if(mysqli_num_rows(mysqli_query($CONNECT,"SELECT `id` FROM `".getTable("groups")."` WHERE `name` = '$_POST[name]'"))) {
        success("-1");
    }else{
        mysqli_query($CONNECT, 'INSERT INTO `'.getTable("groups").'` VALUES ("","'.$_POST[name].'")');
        
        $row = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT `id` FROM `".getTable("groups")."` WHERE `name` = '$_POST[name]'"));
        $id = $row['id'];        
        success($id);
    }
}else if ($_POST["removeGroup_f"]){
    if(mysqli_query($CONNECT, "DELETE FROM `".getTable("groups")."` WHERE `id`='$_POST[id]'")){
        success("1");
    }else{
        success("0");
    }
}else if ($_POST["changeGroup_f"]) {
    if (mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `".getTable("groups")."` WHERE `name` = '$_POST[newName]'"))) {
        success("-1");
    } else {
        if (mysqli_query($CONNECT, "UPDATE `".getTable("groups")."` SET `name`='$_POST[newName]' WHERE `id`='$_POST[id]'")) {
            success("1");
        } else {
            success("0");
        }
    }
}else if ($_POST["loadPupil_f"]){	
	if ($result = mysqli_query($CONNECT, "SELECT * FROM `".getTable("pupils")."` WHERE `group_id` = '$_POST[id]'")) {
		$arr=array();		
		while ($row = mysqli_fetch_row($result)) {	
			$arr[$row[0]]=$row[2];	
		}
		keyValueAnswer($arr);
	}    
}else if ($_POST["loadGroups_f"]){	
	if ($result = mysqli_query($CONNECT, "SELECT * FROM `".getTable("groups")."`")) {
		$arr=array();		
		while ($row = mysqli_fetch_row($result)) {	
			$arr[$row[0]]=$row[1];	
		}
		keyValueAnswer($arr);
	}    
}else if ($_POST["newPupil_f"]){	
	   mysqli_query($CONNECT, 'INSERT INTO `'.getTable("pupils").'` VALUES ("","'.$_POST[group_id].'","'.$_POST[name].'")');
        $row = mysqli_fetch_assoc(mysqli_query($CONNECT,"SELECT `id` FROM `".getTable("pupils")."` WHERE `name` = '$_POST[name]'"));
        $id = $row['id'];        
        success($id);
}else if ($_POST["changePupilName_f"]){	
    if(mysqli_query($CONNECT, "UPDATE `".getTable("pupils")."` SET `name`='$_POST[newName]' WHERE `id`='$_POST[id]'")){
        success("1");
    }else{
        success("0");
    }
}else if ($_POST["removePupil_f"]){
    if(mysqli_query($CONNECT, "DELETE FROM `".getTable("pupils")."` WHERE `id`='$_POST[id]'")){
        success("1");
    }else{
        success("0");
    }
}else if ($_POST["loadPupilInfo_f"]){
    if (!mysqli_num_rows(mysqli_query($CONNECT, "SELECT * FROM `".getTable("pupil_info")."` WHERE `pupil_id` = '$_POST[id]'"))){
        mysqli_query($CONNECT, 'INSERT INTO `'.getTable("pupil_info").'` VALUES ("","'.$_POST[id].'","resource/images/no-photo.png","")');
    }
        if ($result = mysqli_query($CONNECT, "SELECT * FROM `".getTable("pupil_info")."` WHERE `pupil_id` = '$_POST[id]'")) {
            $answer = array();
            $res = mysqli_fetch_row($result);
            keyValueAnswer($res);
        }
}else if ($_POST["unsetSessionInfo_f"]){
    unset($_SESSION['email']);
    redirect("");
}else if ($_POST["changePupilInfo_f"]){
    if(mysqli_num_rows(mysqli_query($CONNECT,"SELECT `pupil_id` FROM `".getTable("pupil_info")."` WHERE `pupil_id` = '$_POST[pupil_id]'"))){
        if (mysqli_query($CONNECT, "UPDATE `".getTable("pupil_info")."` SET `information`='$_POST[newInfo]' WHERE `pupil_id`='$_POST[pupil_id]'")) {
            success("1");
        } else {
            success("-1");
        }
    }else{
        if (mysqli_query($CONNECT, 'INSERT INTO `'.getTable("pupil_info").'` VALUES ("","'.$_POST[pupil_id].'","","'.$_POST[newInfo].'")')) {
            success("1");
        } else {
            success("-1");
        }
    }
}else if ($_POST["changeDiscipline_f"]) {
    if (mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `".getTable("disciplines")."` WHERE `name` = '$_POST[newName]'"))) {
        success("-1");
    } else {
        if (mysqli_query($CONNECT, "UPDATE `".getTable("disciplines")."` SET `name`='$_POST[newName]' WHERE `id`='$_POST[id]'")) {
            success("1");
        } else {
            success("0");
        }
    }
}else if ($_POST["removeDiscipline_f"]){
    if(mysqli_query($CONNECT, "DELETE FROM `".getTable("disciplines")."` WHERE `id`='$_POST[id]'")){
        success("1");
    }else{
        success("0");
    }
}else if ($_POST["newDiscipline_f"]) {
    if (mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `".getTable("disciplines")."` WHERE `name` = '$_POST[name]'"))) {
        success("-1");
    } else {
        mysqli_query($CONNECT, 'INSERT INTO `'.getTable("disciplines").'` VALUES ("","' . $_POST[name] . '")');

        $row = mysqli_fetch_assoc(mysqli_query($CONNECT, "SELECT `id` FROM `".getTable("disciplines")."` WHERE `name` = '$_POST[name]'"));
        $id = $row['id'];
        success($id);
    }
}else if ($_POST["loadMaterials_f"]) {
    if ($result = mysqli_query($CONNECT, "SELECT * FROM `".getTable("materials")."` WHERE `discipline_id` = '$_POST[id]'")) {
        $arr=array();
        while ($row = mysqli_fetch_row($result)) {
            $arr[$row[0]]=$row[2];
        }
        keyValueAnswer($arr);
    }
}else if ($_POST["removeMaterial_f"]){
    if(mysqli_query($CONNECT, "DELETE FROM `".getTable("materials")."` WHERE `id`='$_POST[id]'")){
        success("1");
    }else{
        success("0");
    }
}else if ($_POST["make_download_link_f"]){	
	if ($result = mysqli_query($CONNECT, "SELECT `path` FROM `".getTable("materials")."` WHERE `id` = '$_POST[id]' AND `discipline_id`='$_POST[m_id]'")) {
			$row = mysqli_fetch_row($result);			
			$f = fopen("./pages/user/downloadfile.php", "w");
			$filepath="./materials/".$_SESSION['email']."/".$_POST["m_id"]."/".$row[0];
			$text="<?
			\$file_url = '".$filepath."';
			header('Content-Type: application/octet-stream');
			header(\"Content-Transfer-Encoding: Binary\"); 
			header(\"Content-disposition: attachment; filename=\\\"\" . basename(\$file_url) . \"\\\"\"); 
			readfile(\$file_url); 
			?>";
			fwrite($f, $text); 
			// Закрыть текстовый файл
			fclose($f);
	}
}else if ($_POST["removePhoto_f"]){	
	if (mysqli_query($CONNECT, "UPDATE `".getTable("pupil_info")."` SET `photo_path`='resource/images/no-photo.png' WHERE `pupil_id`='$_POST[id]'")) {
				success("1");
			} else {
				success("-1");
			}
}else if ($_POST["newEvent_f"]){
    $pieces = explode(" ", $_POST["addeddate"]);
    if(mysqli_query($CONNECT, 'INSERT INTO `'.getTable("events").'` VALUES ("","'.$_POST[eventtype].'","'.$_POST[addeddiscipline].'","'.$_POST[addedgroup].'","'.$_POST[addedinfo].'","'.$pieces[0].'","'.$pieces[1].'")')) {
        if($_POST[eventtype]==1||$_POST[eventtype]==2){
            $highest_id = mysqli_fetch_row(mysqli_query($CONNECT, "SELECT MAX(id) FROM `".getTable("events")."`"));
            $highest_id= $highest_id[0];
            if ($result = mysqli_query($CONNECT, "SELECT `id` FROM `".getTable("pupils")."` WHERE `group_id` = '$_POST[addedgroup]'")) {
                while ($row = mysqli_fetch_row($result)) {
                    mysqli_query($CONNECT, 'INSERT INTO `'.getTable("marks").'` VALUES ("","'.$highest_id.'","'.$row[0].'","","","")');
                    }
                success(1);
            }
        }else{success(1);}
    }
    success(-1);
}else if ($_POST["findEvent_f"]){
    $one_already_selected=false;
    $query_string="SELECT * FROM `".getTable("events")."`";
    if($_POST["eventtype"]!="undefined"){
        $one_already_selected=true;
        $query_string= $query_string." WHERE `event_type` = ".$_POST["eventtype"];
    }
    if($_POST["addeddiscipline"]!="undefined"){
        if($one_already_selected){
            $query_string=$query_string." AND `discipline_id` = ".$_POST["addeddiscipline"];
        }else{
            $query_string=$query_string." WHERE `discipline_id` = ".$_POST["addeddiscipline"];
        }
        $one_already_selected=true;
    }
    if($_POST["addedgroup"]!="undefined"){
        if($one_already_selected){
            $query_string=$query_string." AND `group_id` = ".$_POST["addedgroup"];
        }else{
            $query_string=$query_string." WHERE `group_id` = ".$_POST["addedgroup"];
        }
        $one_already_selected=true;
    }
    if($_POST["addeddate"]){
        $pieces = explode(" ", $_POST["addeddate"]);
        if($one_already_selected){
            if($_POST["dontusetime"]=="true"){
                $query_string=$query_string." AND `date` LIKE '%".$pieces[0]."%'";
            }else{
                $query_string=$query_string." AND `date` LIKE '%".$pieces[0]."%'";
                $query_string=$query_string." AND `time` LIKE '%".$pieces[1]."%'";
            }
        }else{
            if($_POST["dontusetime"]=="true"){
                $query_string=$query_string." WHERE `date` LIKE '%".$pieces[0]."%'";
            }else{
                $query_string=$query_string." WHERE `date` LIKE '%".$pieces[0]."%'";
                $query_string=$query_string." AND `time` LIKE '%".$pieces[1]."%'";
            }
        }
    }
    if ($result = mysqli_query($CONNECT,$query_string )) {
        $arr=array();
        while ($row = mysqli_fetch_row($result)) {
            $eventtype=$row[1]=="1"?"лекция":($row[1]=="2"?"практика":"напоминание");
            $query = "SELECT `name` FROM`".getTable("disciplines")."` WHERE id=".$row[2];
            if ($tempresult = mysqli_query($CONNECT, $query)) {
                $temprow = mysqli_fetch_row($tempresult);
                $discipline=$temprow[0];
            }

            $query = "SELECT `name` FROM`".getTable("groups")."` WHERE id=".$row[3];
            if ($tempresult = mysqli_query($CONNECT, $query)) {
                $temprow = mysqli_fetch_row($tempresult);
                $group=$temprow[0];
            }
            $answerString=$eventtype."_".$discipline."_".$group."_".$row[5]."_".$row[6];
            $arr[$row[0]]=$answerString;
        }
        keyValueAnswer($arr);
    }else{
        success(-1);
    }
}else if ($_POST["get_evet_details_f"]){
    $query_string="SELECT * FROM `".getTable("events")."` WHERE `id`=".$_POST["id"];
    $result = mysqli_query($CONNECT,$query_string );
    $arr=array();
    $row = mysqli_fetch_row($result);
    if($row[1]==3){
		$arr["type"]="reminder";
        $arr["info"]=$row[4];
    }else{
        $arr["type"]="notreminder";
		$arr["info"]=$row[4];		
		if ($marks = mysqli_query($CONNECT, "SELECT * FROM `".getTable("marks")."` WHERE `event_id` = '$_POST[id]'")) {	
		while ($row = mysqli_fetch_row($marks)) {		
		$pupilname = mysqli_query($CONNECT, "SELECT `name` FROM `".getTable("pupils")."` WHERE `id` = '$row[2]'");
		$pupilnamearr = mysqli_fetch_row($pupilname);
			$arr[$row[0]]=$pupilnamearr[0]."_".$row[3]."_".$row[4]."_".$row[5];
		}
		keyValueAnswer($arr);
	}
    }
    keyValueAnswer($arr);
}else if ($_POST["changeMarks_f"]){
    if($_POST["type"]=="marks"){
        if (mysqli_query($CONNECT, "UPDATE `".getTable("marks")."` SET `marks`='$_POST[value]' WHERE `id`='$_POST[id]'")) {
            success("1");
        } else {
            success("0");
        }
    }else  if($_POST["type"]=="info"){
        if (mysqli_query($CONNECT, "UPDATE `".getTable("marks")."` SET `info`='$_POST[value]' WHERE `id`='$_POST[id]'")) {
            success("1");
        } else {
            success("0");
        }
    }
}else if ($_POST["changeAbsent_f"]){
        if (mysqli_query($CONNECT, "UPDATE `".getTable("marks")."` SET `absent`='$_POST[absent]' WHERE `id`='$_POST[id]'")) {
            success("1");
        } else {
            success("0");
        }

}else if ($_POST["pupil_absent_f"]){
if ($_POST['reportdisciplinetype'] == 1 || $_POST['reportdisciplinetype'] == 2) {
    $query_str="SELECT e.`date`, m.`absent` FROM `".getTable("marks")."` AS m  INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` WHERE m.`pupil_id` = ".$_POST['reportpupil']." AND e.`event_type` = ".$_POST['reportdisciplinetype']." AND e.`discipline_id` = ".$_POST['reportdiscipline'];
} else if ($_POST['reportdisciplinetype'] == 3) {
    $query_str="SELECT e.`date`, m.`absent` FROM `".getTable("marks")."` AS m  INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` WHERE m.`pupil_id` = ".$_POST['reportpupil']." AND (e.`event_type` = 1 OR e.`event_type`=2) AND e.`discipline_id` = ".$_POST['reportdiscipline'];
}
    if ($query_result=mysqli_query($CONNECT,$query_str )) {
        $id = 0;
        $result = array();
        while ($row = mysqli_fetch_row($query_result)) {
            if(isdatebetween($row[0],$_POST['fromdate'],$_POST['todate']))
            {
                $result[$id] = $row[0] . "_" . $row[1];
                $id++;
            }
        }
    }
    keyValueAnswer($result);
}else if ($_POST["pupil_marks_f"]) {
    if ($_POST['reportdisciplinetype'] == 1 || $_POST['reportdisciplinetype'] == 2) {
        $query_str="SELECT e.`date`, m.`marks` FROM `".getTable("marks")."` AS m  INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` WHERE m.`pupil_id` = ".$_POST['reportpupil']." AND e.`event_type` = ".$_POST['reportdisciplinetype']." AND e.`discipline_id` = ".$_POST['reportdiscipline'];
    } else if ($_POST['reportdisciplinetype'] == 3) {
        $query_str="SELECT e.`date`, m.`marks` FROM `".getTable("marks")."` AS m  INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` WHERE m.`pupil_id` = ".$_POST['reportpupil']." AND (e.`event_type` = 1 OR e.`event_type`=2) AND e.`discipline_id` = ".$_POST['reportdiscipline'];
    }
    if ($query_result=mysqli_query($CONNECT,$query_str )) {
        $id = 0;
        $result = array();
        while ($row = mysqli_fetch_row($query_result)) {
            if(isdatebetween($row[0],$_POST['fromdate'],$_POST['todate']))
            {
                $result[$id] = $row[0] . "_" . $row[1];
                $id++;
            }
        }
    }
    keyValueAnswer($result);
}else if ($_POST["all_pupil_marks_f"]) {
    if ($_POST['reportdisciplinetype'] == 1 || $_POST['reportdisciplinetype'] == 2) {
        $query_str = "SELECT  p.`id`, p.`name`, e.`date`, m.`absent` FROM `".getTable("marks")."` AS m INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` INNER JOIN `".getTable("pupils")."` AS p ON m.`pupil_id`=p.`id` WHERE e.`group_id`= ".$_POST['reportgroup']." AND e.`event_type` = ".$_POST['reportdisciplinetype']."  AND e.`discipline_id` =".$_POST['reportdiscipline'];
    } else if ($_POST['reportdisciplinetype'] == 3) {
        $query_str = "SELECT  p.`id`, p.`name`, e.`date`, m.`marks` FROM `".getTable("marks")."` AS m INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` INNER JOIN `".getTable("pupils")."` AS p ON m.`pupil_id`=p.`id` WHERE e.`group_id`= ".$_POST['reportgroup']." AND (e.`event_type` = 1 OR e.`event_type`=2) AND e.`discipline_id` =".$_POST['reportdiscipline'];
    }
    if ($result = mysqli_query($CONNECT, $query_str)) {
        while ($row = mysqli_fetch_row($result)) {
            if (isdatebetween($row[2], $_POST['fromdate'], $_POST['todate'])) {
                    $arr[$row[0] . "_" . $row[1]] = $arr[$row[0] . "_" . $row[1]] . "," . $row[3];
            }
        }
        keyValueAnswer($arr);
    }
}else if ($_POST["all_pupil_absent_f"]) {
    if ($_POST['reportdisciplinetype'] == 1 || $_POST['reportdisciplinetype'] == 2) {
        $query_str = "SELECT  p.`id`, p.`name`, e.`date`, m.`absent` FROM `".getTable("marks")."` AS m INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` INNER JOIN `".getTable("pupils")."` AS p ON m.`pupil_id`=p.`id` WHERE e.`group_id`= ".$_POST['reportgroup']." AND e.`event_type` = ".$_POST['reportdisciplinetype']."  AND e.`discipline_id` =".$_POST['reportdiscipline'];
    } else if ($_POST['reportdisciplinetype'] == 3) {
        $query_str = "SELECT  p.`id`, p.`name`, e.`date`, m.`absent` FROM `".getTable("marks")."` AS m INNER JOIN `".getTable("events")."` AS e ON m.`event_id`=e.`id` INNER JOIN `".getTable("pupils")."` AS p ON m.`pupil_id`=p.`id` WHERE e.`group_id`= ".$_POST['reportgroup']." AND (e.`event_type` = 1 OR e.`event_type`=2) AND e.`discipline_id` =".$_POST['reportdiscipline'];
    }
    if ($result = mysqli_query($CONNECT, $query_str)) {
        while ($row = mysqli_fetch_row($result)) {
            if (isdatebetween($row[2], $_POST['fromdate'], $_POST['todate'])) {
                $arr[$row[0] . "_" . $row[1]] =  $arr[$row[0] . "_" . $row[1]]."_".$row[3];
            }
        }
        keyValueAnswer($arr);
    }
}else if ($_POST["change_event_info_f"]){
    if (mysqli_query($CONNECT, "UPDATE `".getTable("events")."` SET `info`='$_POST[newinfo]' WHERE `id`='$_POST[id]'")) {
        success(1);
    } else {
        success("0");
    }
}else if ($_POST["remove_event_f"]){
    if(mysqli_query($CONNECT, "DELETE FROM `".getTable("events")."` WHERE `id`='$_POST[id]'")){
        success("1");
    }else{
        success("0");
    }
}







function isdatebetween($date,$startdate,$enddate){
    $date = explode('.', $date);
    $startdate = explode('.', $startdate);
    $enddate = explode('.', $enddate);
    $datea=(integer)($date[2].$date[1].$date[0]);
    $startdatea=(integer)($startdate[2].$startdate[1].$startdate[0]);
    $enddatea=(integer)($enddate[2].$enddate[1].$enddate[0]);
    if($datea>=$startdatea && $datea<=$enddatea)
        return true;
    return false;
}
?>










