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
<title>отчёты</title>
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
		<p id='header_title'>отчёты<img id="header_loading" src="resource/images/loading.gif"><p/>
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
			<div id='event_card'>
				<center>
					<span id="pupil_ancet_name">формирование отчёта</span>

					<select class="reportdisciplinetype">
						<option>тип занятия не выбран</option>
						<option id="1">лекция</option>
						<option id="2">практика</option>
						<option id="3">обои</option>
					</select>

					<select class="reporttype">
						<option>тип отчёта не выбран</option>
						<option id="1">посещаемость</option>
						<option id="2">срединий балл</option>

					</select>

					<select class="reportgroup">
						<option>группа не выбрана</option>
						<?addGroups();?>
					</select>

					<select class="reportobject">
						<option>ученик не выбран</option>						
					</select>

					<select class="reportdiscipline">
						<option>дисциплина не выбрана</option>
						<?addDisciplines();?>
					</select>

					<div style="display: inline-block">
					<div align="left" class="datepicker-here" name="from" ></div>
					<div align="center">по</div>
					<div   align="right" class="datepicker-here" name="to"></div>
					<button class="action_button" onclick="buttonClicked('makereport')">сформировать</button>
					</div>
				</center>
			</div>

			<div id='event_card' >
				<center>
					<span id="pupil_ancet_name">отчёт</span>
					<textarea id="text_report" placeholder="Отчёт"></textarea>
					<div class="ct-chart ct-perfect-fourth"></div>
				</center>
			</div>
		</div>
	</div>


</body>

</html>






