<?
function printGroups()
{
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM `".getTable("groups")."`";


	if ($result = mysqli_query($link, $query)) {
		while ($row = mysqli_fetch_row($result)) {
			echo '<li id="ligroups" onclick="groupItemClicked(';
			echo $row[0];
			echo ')" ';	
			echo '><a href="#" class="changegroup" id="';
			echo $row[0];
			echo '"oncontextmenu="return menu(1, event,';
			echo $row[0];
			echo');">';
			echo $row[1];
			echo "</a></li>";
		}
	}
	mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ученики</title>
	<script src='/resource/js/jquery.js'></script>
	<script src="/resource/js/click_script.js"></script>

	<script src='/resource/confirm_alert/jquery-confirm.min.js'></script>


 <link rel="stylesheet" href="resource/css/main_window.css"> 
 <link rel="stylesheet" href="resource/css/pupils.css">

	<link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">
	
</head>
<body>
	<div id='fixed_header'>
		<p id='header_title'>ученики<img id="header_loading" src="resource/images/loading.gif"><p/>
	</div>

	<div id='menu'>
		<div id='menu_header'>
			<span>
				<p id='menu_header_text'><?echo $_SESSION['email']?></p>
				<button id='exit__account_button'>
					<img id='menuHeaderImage' onclick="buttonClicked('exitAccount')" src="resource/images/exit.png">
				</button>
			</span>
		</div>
		
		<button id='menuButton'>
					<span>
						<img id='menuImage' src="resource/images/pupils.png" alt="" style="vertical-align:middle">
						Ученики
					</span>
		</button>
		
		<button id='menuButton' onclick="go('disciplines')">
					<span>
						<img id='menuImage' src="resource/images/disciplines.png" alt="" style="vertical-align:middle">
						Дисциплины
					</span>
		</button>
		
		<button id='menuButton' onclick="go('reports')">
					<span>
						<img id='menuImage' src="resource/images/charts.png" alt="" style="vertical-align:middle">
						Отчёты
					</span>
		</button>
		
		<button id='menuButton' onclick="go('events')">
					<span>
						<img id='menuImage' src="resource/images/events.png" alt="" style="vertical-align:middle">
						События
					</span>
		</button>
		
		<button id='menuButton' onclick="go('settings')">
					<span>
						<img id='menuImage' src="resource/images/settings.png" alt="" style="vertical-align:middle">
						Настройки
					</span>
		</button>
				 
	</div>
	<div id='content'>
		<div id='content_card'>
			<div id='content_card_element'>
				<center><button class="action_button" onclick="buttonClicked('newGroup')">+ Новая группа</button></center>
			<ol id='groups' class="rounded" >
				<?printGroups();?>
			</ol>
			</div>
			<div id='content_card_element'>
				<center><button class="action_button"onclick="buttonClicked('newPupil')">+ Новый ученик</button></center>
				<ol id='pupils' class="rounded">			
				</ol>
			</div>
			<div id='content_card_element'>
				<center><span id="pupil_ancet_name"></span></center>
				<a  href="#" oncontextmenu="return menu(3, event,-1)">
					<img id="pupil_photo" src="resource/images/no-photo.png" width="100% oncontextmenu="return menu(3, event,-1)";>
				</a>
				
				<div id="loadphoto">
					<p><input type="file" name="photo"  accept="image/jpeg,image/png,image/gif">
						<button class="action_button"onclick="buttonClicked('load_photo_clicked')">Отправить</button>
					</p>
				</div>
				
				<textarea id="pupil_info_text" placeholder="Информационное поле"></textarea>
				<button class="action_button" onclick="buttonClicked('savePupilInfo')">запомнить</button>
			</div>
		</div>
	</div>
</body>

</html>




<div id="contextMenuId"
	 style="position:absolute;
	 text-decoration: none;
	  top:0;
	   left:0;
	      display:none;
	       float:left;">

</div>



