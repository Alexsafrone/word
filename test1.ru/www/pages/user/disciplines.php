<?
function printDisciplines()
{
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM`".getTable("disciplines")."`";


	if ($result = mysqli_query($link, $query)) {
		while ($row = mysqli_fetch_row($result)) {
			echo '<li id="lidisciplines" onclick="disciplineItemClicked(';
			echo $row[0];
			echo ')" ';
			echo '><a href="#" class="changediscipline" id="';
			echo $row[0];
			echo '"oncontextmenu="return menu(4, event,';
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
<title>дисциплины</title>
 <link rel="stylesheet" href="resource/css/main_window.css">
	<link rel="stylesheet" href="resource/css/pupils.css">
	<script src='/resource/js/jquery.js'></script>
	<script src="/resource/js/click_script.js"></script>
	<link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">
	<script src='/resource/confirm_alert/jquery-confirm.min.js'></script>
</head>
<body>

	<div id='fixed_header'>
		<p id='header_title'>дисциплины<img id="header_loading" src="resource/images/loading.gif"><p/>
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
		
		<button id='menuButton' onclick="go('pupils')">
					<span>
						<img id='menuImage' src="resource/images/pupils.png" alt="" style="vertical-align:middle">
						Ученики
					</span>
		</button>
		
		<button id='menuButton'>
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
				<center><button class="action_button" onclick="buttonClicked('newDiscipline')">+ Новая дисциплина</button></center>
				<ol id='disciplines' class="rounded" >
					<?printDisciplines();?>
				</ol>
			</div>
			<div id='content_card_element'>
				<center><button class="action_button"onclick="buttonClicked('addMaterials')">+ Добавить материалы</button></center>
				<div id="loadmaterials">
					<p><input type="file" multiple="multiple" name="photo">
						<button class="action_button"onclick="buttonClicked('load_materials_clicked')">Отправить</button>
					</p>
				</div>

				<div id='materials_card'></div>
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