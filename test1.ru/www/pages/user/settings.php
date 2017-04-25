<!DOCTYPE html>
<html>
<head>
<title>настройки</title>
 <link rel="stylesheet" href="resource/css/main_window.css">
	<script src='/resource/js/jquery.js'></script>
	<script src="/resource/js/click_script.js"></script>
	<link rel="stylesheet" href="/resource/confirm_alert/jquery-confirm.min.css">
	<script src='/resource/confirm_alert/jquery-confirm.min.js'></script>
</head>
<body>
	<div id='fixed_header'>
		<p id='header_title'>настройки</p>
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
		
		<button id='menuButton'>
					<span>
						<img id='menuImage' src="resource/images/settings.png" alt="" style="vertical-align:middle">
						Настройки
					</span>
		</button>
				 
	</div>
	<div id='content'>
		<div id='content_card'>
		Мотоци́кл (от фр. motocycle — средство передвижения. От лат. mōtor — приводящий в движение и греч. κύκλος — круг, колесо) — двухколёсное (либо трёхколёсное) транспортное средство с механическим двигателем (двигатель внутреннего сгорания, электрический, пневматический) главными отличительными чертами которого являются: вертикальная посадка водителя (мотоциклиста), наличие боковых ножных упоров (площадок, подножек), прямое (безредукторное) управление передним поворотным колесом.

Классические мотоциклы включают в себя двухколесные, двухколесные с боковой коляской, трёхколесные (трайк) и четырёхколесные (квадроцикл), снегоходы (имеют гусеничный привод). Помимо количества колес, мотоциклы также различаются по своей конструкции и размерам: мопеды, мокики (имеют небольшой размер двигателя, как правило до 50 см³) мотороллеры или скутеры (закрытый кузовом двигатель расположенный под сиденьем водителя и площадки для ног), и собственно сами мотоциклы различных типов: классические, крузеры, туреры, спортивные, шоссейные, кроссовые, эндуро, чопперы.
		</div>

	</div>
</body>

</html>
