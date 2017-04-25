<?
function addDisciplines()
{
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM`".getTable("disciplines")."`";


	if ($result = mysqli_query($link, $query)) {
		while ($row = mysqli_fetch_row($result)) {
			echo '<option id="';
			echo $row[0];
			echo '">';
			echo $row[1];
			echo '</option>';
		}
	}
	mysqli_close($link);
}


function addGroups()
{
	$link = mysqli_connect("localhost", "root", "", "database");
	$query = "SELECT * FROM `".getTable("groups")."`";


	if ($result = mysqli_query($link, $query)) {
		while ($row = mysqli_fetch_row($result)) {
			echo '<option id="';
			echo $row[0];
			echo '">';
			echo $row[1];
			echo '</option>';
		}
	}
	mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>события</title>
	<link rel="stylesheet" href="resource/css/main_window.css">
	<link rel="stylesheet" href="resource/css/pupils.css">
	<link href="/resource/air-datepicker-master/dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
	<script src='/resource/js/jquery.js'></script>
	<script src="/resource/js/click_script.js"></script>
	<script src="/resource/air-datepicker-master/dist/js/datepicker.min.js"></script>
	<script src='/resource/js/jeditable.js'></script>
	<link rel="stylesheet" href="/resource/dist/chartist.min.css">
	<script src="/resource/dist/chartist.min.js"></script>
	<link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">
	<script src='/resource/confirm_alert/jquery-confirm.min.js'></script>
</head>
<body>
	<div id='fixed_header'>
		<p id='header_title'>события<img id="header_loading" src="resource/images/loading.gif"><p/>
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
		
		<button id='menuButton' onclick="go('pupils')" >
					<span>
						<img id='menuImage' src="resource/images/pupils.png" alt="">
						Ученики
					</span>
		</button>
		
		<button id='menuButton' onclick="go('disciplines')">
					<span>
						<img id='menuImage' src="resource/images/disciplines.png" alt="">
						Дисциплины
					</span>
		</button>
		
		<button id='menuButton' onclick="go('reports')">
					<span>
						<img id='menuImage' src="resource/images/charts.png" alt="">
						Отчёты
					</span>
		</button>
		
		<button id='menuButton'>
					<span>
						<img id='menuImage' src="resource/images/events.png" alt="">
						События
					</span>
		</button>
		
		<button id='menuButton' onclick="go('settings')">
					<span>
						<img id='menuImage' src="resource/images/settings.png" alt="">
						Настройки
					</span>
		</button>
				 
	</div>
	<div id='content'>

		<div id='content_card_show_hide'>
			<div id='event_card_show_events'>
				<button class="action_button_events" onclick="buttonClicked('showhidenew')">новое событие</button>
			</div>
			<div id='event_card_show_events'>
				<button class="action_button_events" onclick="buttonClicked('showhideshow')">показать событие</button>
			</div>
			<div id='event_card_show_events'>
				<button class="action_button_events" onclick="buttonClicked('showhidefind')">найти событие</button>
			</div>
		</div>

		<div id='content_card'>

			<div id='event_card' class="eventcardnewevent">
				<center>
					<span id="pupil_ancet_name">добавить событие</span>
					<select class="addeventtype">
						<option>тип занятия не выбран</option>
						<option id="1">лекция</option>
						<option id="2">практика</option>
						<option id="3">напоминание</option>
					</select>
					<select class="adddiscipline">
						<option>дисциплина не выбрана</option>
						<?addDisciplines();?>
					</select>
					<select class="addgroup">
						<option>группа не выбрана</option>
						<?addGroups();?>
					</select>
					<textarea id="event_info_text" placeholder="Информация"></textarea>
					<div class="datepicker-here" name="datepicker1" data-timepicker="true"></div>
					<button class="action_button" onclick="buttonClicked('addevent')">добавить</button>
				</center>
			</div>


			<div id='event_card' class="eventcardshowevent">
				<center><span id="pupil_ancet_name">найденные события</span></center>
			</div>


			<div id='event_card' class="eventcardfindevent" >
				<center>
					<span id="pupil_ancet_name">найти событие</span>
					<select class="findeventtype">
						<option>тип занятия не выбран</option>
						<option id="1">лекция</option>
						<option id="2">практика</option>
						<option id="3">напоминание</option>
					</select>
					<select class="finddiscipline">
						<option>дисциплина не выбрана</option>
						<?addDisciplines();?>
					</select>
					<select class="findgroup">
						<option>группа не выбрана</option>
						<?addGroups();?>
					</select>
					<div class="datepicker-here" name="datepicker2" data-timepicker="true"></div>
					<input type="checkbox" id="cc" />
					<label for="c1"><span></span>без учёта времени  </label>
					<button class="action_button" onclick="buttonClicked('findevent')">найти</button>
				</center>
			</div>


		</div>
		
		<div id='content_card' class="event_editing">
			<table id="events_table">
			</table>
		</div>

		<div id='content_card' class="event_info_editing">
		<textarea id="event_edit_info" placeholder="Информация"></textarea>			
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
	      z-index: 200;
	       float:left;">

</div>
