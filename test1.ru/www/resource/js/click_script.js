//=================================================================================
var photo;

$(document).ready(function(){
	$('.login-form').submit(function (e) {
		e.preventDefault();
	});


		$(window).unload(function(){
		delete_cookie("selectedgroup");
		delete_cookie("selectedpupil");
		delete_cookie("selectedDiscipline");
		delete_cookie("selectedevent");
	});
	$("#loadphoto").hide();
	$("#loadmaterials").hide();
	$("#materials_card").hide();
	$(".event_editing").hide();
	$(".event_info_editing").hide();



	hide_loading_progress();
	//загрузка фото далее
	$('input[type=file]').change(function(){
		photo = this.files;
	});

	//показ карточек событий взависимости от кук
	if(tmp=getCookie("neweventshow")){
		if(tmp==0){
			$(".eventcardnewevent").hide();
		}else{
			$(".eventcardnewevent").show();
		}
	}

	if(tmp=getCookie("showhideshow")){
		if(tmp==0){
			$(".eventcardshowevent").hide();
		}else{
			$(".eventcardshowevent").show();
		}
	}

	if(tmp=getCookie("findeventshow")){
		if(tmp==0){
			$(".eventcardfindevent").hide();
		}else{
			$(".eventcardfindevent").show();
		}
	}
	// При клике на td ставим input
	$("table").on('click', '.marks', function(){
		if($(this).attr("class")!="noedit" & $(this).attr("class")!="check") {
			$(this).html("<input type='text'  value='" + $(this).text() + "'/>");
		}else if($(this).attr("class")=="check") {}
// Что бы input не ставился повторно, запрещаем
	}).on('click', 'td input', function(){
		return false;
// При потере фокуса в input, возвращаем все как было.
	}).on('blur', '.marks input', function(){
		// text, т.к. html теги не обрабатываются.
		v=$(this).parent('.marks');
		text=$(this).val()
		var re =/^((\d+,)*(\d+)){0,}$/;
		if (re.test(text) ) {
			v.text(text);
			$.ajax({
				url: "/userQuery",
				type: "POST",
				data: "changeMarks_f=1&id=" + v.attr("id") + "&type=" + v.attr("class") + "&value=" + text,
				cache: false,
				success: function (result) {
					//alert(result);
				}
			});
		}else {
			$.alert({title: 'Внимание!',	content: 'Вы можете вводить только цифры через запятую',	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}
	});

	// При клике на td ставим input
	$("table").on('click', '.info', function(){
		if($(this).attr("class")!="noedit" & $(this).attr("class")!="check") {
			$(this).html("<input type='text'  value='" + $(this).text() + "'/>");
		}else if($(this).attr("class")=="check") {}
// Что бы input не ставился повторно, запрещаем
	}).on('click', 'td input', function(){
		return false;
// При потере фокуса в input, возвращаем все как было.
	}).on('blur', '.info input', function() {
		// text, т.к. html теги не обрабатываются.
		v = $(this).parent('.info');
		text = $(this).val();
		v.text(text);
		$.ajax({
			url: "/userQuery",
			type: "POST",
			data: "changeMarks_f=1&id=" + v.attr("id") + "&type=" + v.attr("class") + "&value=" + text,
			cache: false,
			success: function (result) {
			}
		});

	});

	// При клике на td ставим input
	$("table").on('click', '.check', function(){
	var check_id=$(this).find('input:checkbox:first').attr("id");
		if($("#"+check_id+".checker").is(':checked')){
			$("#"+check_id+".checker").removeAttr('checked');
			$.ajax({
				url: "/userQuery",
				type: "POST",
				data: "changeAbsent_f=1&id=" + check_id+"&absent="+0,
				cache: false,
				success: function (result) {
				}
			});
		}else{
			$("#"+check_id+".checker").prop("checked",true);
			$.ajax({
				url: "/userQuery",
				type: "POST",
				data: "changeAbsent_f=1&id=" + check_id+"&absent="+1,
				cache: false,
				success: function (result) {
				}
			});
		}
	});

		$('.reportgroup').change(function(){
			var id = $(".reportgroup option:selected").attr("id");
			if(id) {
				show_loading_progress();
				$.ajax({
					url: "/userQuery",
					type: "POST",
					data: "loadPupil_f=1&id=" + id,
					cache: false,
					success: function (result) {
						hide_loading_progress();
						obj = jQuery.parseJSON(result);
						str = "";
						$('.reportobject option').remove();
						$('.reportobject')
							.append($("<option></option>")
								.text("ученик не выбран"));
						$.each(obj, function (key, value) {
							$('.reportobject')
								.append($("<option></option>")
									.attr("id", key)
									.text(value));
						});
					}
				});
			}else{
				$('.reportobject option').remove();
				$('.reportobject')
					.append($("<option></option>")
						.text("ученик не выбран"));
			}
		});



	$("#event_edit_info").on('blur', function(){
		$.ajax({
			url:"/userQuery",
			type: "POST",
			data: "change_event_info_f=1&id="+getCookie("selectedevent")+"&newinfo="+$("#event_edit_info").val(),
			cache: false,
			success: function(result) {
				obj = jQuery.parseJSON(result);
				if(obj.result==0){
					$.alert({title: 'Внимание!',	content: 'что-то пошло не так',	boxWidth: '30%', type: 'red', useBootstrap: false,});
				}
			}
		});
	});



});

function postQuery(adress, form, params){
    var str="";
    $.each(params.split('.'),function(k,v){
        str+="&"+v+"="+$("#"+v).val();
    });

    $.ajax({
        url:"/"+adress,
        type: "POST",
        data: form+"_f=1"+str,
        cache: false,
        success: function(result){
            obj = jQuery.parseJSON(result);
            if(obj.message){
				$.alert({title: 'Внимание!',	content:obj.message ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
            }else {
				if(obj.redirect && obj.alert){
					if(obj.alert){
						$.confirm({
							title: 'Мои поздравления',
							content: obj.alert,
							boxWidth: '30%',
							type: 'green',
							useBootstrap: false,
							buttons: {
								ок: function () {
									go(obj.redirect);
								},
							}
						});
					}
				}else if (obj.alert) {
					$.alert({
						title: 'Внимание!',
						content: obj.alert,
						boxWidth: '30%',
						type: 'red',
						useBootstrap: false,
					});
				}else if(obj.redirect){
					go(obj.redirect);
				}
			}
        }
    });
}


//=================================================================================
//редирект на страницу в случае json ключа redirect
function go( url ){
    window.location.href="/" + url;
}

//=================================================================================
function buttonClicked(name){
    if(name=='newGroup'){
		$.confirm({
			title: 'Пожалуйста',
			boxWidth: '30%',
			type: 'green',
			useBootstrap: false,
			content: '' +
			'<form action="" class="formName">' +
			'<div class="form-group">' +
			'<label>Введите название новой групы</label>' +
			'<input type="text" placeholder="Название" class="name form-control" required />' +
			'</div>' +
			'</form>',
			buttons: {
				formSubmit: {
					text: 'ок',
					btnClass: 'btn-blue',
					action: function () {
						var group = this.$content.find('.name').val();
						if(group){
							show_loading_progress();
							$.ajax({
								url:"/userQuery",
								type: "POST",
								data: "newGroup_f=1&name="+group,
								cache: false,
								success: function(result){
									hide_loading_progress();
									obj = jQuery.parseJSON(result);
									if(obj.result){
										if(obj.result=='-1'){
											$.alert({title: 'Внимание!',	content: 'такая запись уже есть' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}else{
											$("#groups").append("<li  onclick='groupItemClicked("+obj.result+")'><a href='#' class='changegroup' id='"+obj.result+"'oncontextmenu='return menu(1, event,"+obj.result+")'>"+group+"</a></li>");
										}
									}
								}
							});
							return true;
						}
					}
				},
				отмена: function () {
				},
			},
			onContentReady: function () {
				// bind to events
				var jc = this;
				this.$content.find('form').on('submit', function (e) {
					// if the user submits the form by pressing enter in the field.
					e.preventDefault();
					jc.$$formSubmit.trigger('click'); // reference the button and click it
				});
			}
		});
	}else if(name=='newPupil') {
		group_id = getCookie("selectedgroup");
		if (group_id) {
			$.confirm({
				title: 'Пожалуйста',
				boxWidth: '30%',
				type: 'green',
				useBootstrap: false,
				content: '' +
				'<form action="" class="formName">' +
				'<div class="form-group">' +
				'<label>Введите ФИО нового ученика</label>' +
				'<input type="text" placeholder="Название" class="name form-control" required />' +
				'</div>' +
				'</form>',
				buttons: {
					formSubmit: {
						text: 'ок',
						btnClass: 'btn-blue',
						action: function () {
							var pupil = this.$content.find('.name').val();
							if(pupil){
								show_loading_progress();
								$.ajax({
									url: "/userQuery",
									type: "POST",
									data: "newPupil_f=1&name=" + pupil + "&group_id=" + group_id,
									cache: false,
									success: function (result) {
										hide_loading_progress();
										obj = jQuery.parseJSON(result);
										if (obj.result) {
											if (obj.result == '-1') {
												$.alert({title: 'Внимание!',	content: 'не удалось' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
											} else {
												$("#pupils").append("<li  onclick='pupilItemClicked(" + obj.result + ")'><a href='#' class='changepupil' id='" + obj.result + "'oncontextmenu='return menu(2, event," + obj.result + ")'>" + pupil + "</a></li>");
											}
										}
									}
								});
								return true;
							}
						}
					},
					отмена: function () {
					},
				},
				onContentReady: function () {
					// bind to events
					var jc = this;
					this.$content.find('form').on('submit', function (e) {
						// if the user submits the form by pressing enter in the field.
						e.preventDefault();
						jc.$$formSubmit.trigger('click'); // reference the button and click it
					});
				}
			});
		}else{
			$.alert({title: 'Внимание!',	content: 'необходимо выбрать группу' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}
	}else if(name=='savePupilInfo'){
		if(getCookie("selectedpupil")){
			show_loading_progress();
			$.ajax({
				url: "/userQuery",
				type: "POST",
				data: "changePupilInfo_f=1&newInfo=" + $("#pupil_info_text").val() + "&pupil_id=" + getCookie("selectedpupil"),
				cache: false,
				success: function (result) {
					hide_loading_progress();
					obj = jQuery.parseJSON(result);
					if (obj.result) {
						if (obj.result == '-1') {
							$.alert({title: 'Внимание!',	content: 'не удалось' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
						}else{
							var tmp=$("#pupil_info_text").val();
							$("#pupil_info_text").val("");
							$("#pupil_info_text").val(tmp);
							$.alert({title: 'Мои поздравления!',	content: 'информация успешно записана' ,	boxWidth: '30%', type: 'green', useBootstrap: false,});
						}
					}
				}
			});	
		}else{
			$.alert({title: 'Внимание!',	content: 'ученик не выбран' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}
	}else if(name=="exitAccount"){
		show_loading_progress();
		$.ajax({
			url:"/userQuery",
			type: "POST",
			data: "unsetSessionInfo_f=1",
			cache: false,
			success: function(result){
				hide_loading_progress();
					go("");
			}
		});
	}else if(name=="load_photo_clicked") {
		if (photo) {
			show_loading_progress();
			var data = new FormData();
			data.append("photo", photo[0]);
			data.append("id", getCookie("selectedpupil"));

			$.ajax({
				url: "/photoLoader",
				type: "POST",
				data: data,
				cache: false,
				processData: false,
				contentType: false,
				success: function (result) {
					obj = jQuery.parseJSON(result);
					if (obj.message) {
						$("#pupil_photo").attr("src","resource/images/no-photo.png");
						$("#pupil_photo").attr("src", obj.message);
					} else {
						$.alert({title: 'Внимание!',	content: 'не удалось' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
					}
					$("#loadphoto").hide("slow");
					hide_loading_progress();
				}
			});
		}else{
			$("#loadphoto").hide("slow");
		}
	}else if(name=='newDiscipline'){
		$.confirm({
			title: 'Пожалуйста',
			boxWidth: '30%',
			type: 'green',
			useBootstrap: false,
			content: '' +
			'<form action="" class="formName">' +
			'<div class="form-group">' +
				'<label>Введите название новой дисциплины</label>' +
			'<input type="text" placeholder="Название" class="name form-control" required />' +
			'</div>' +
			'</form>',
			buttons: {
				formSubmit: {
					text: 'ок',
					btnClass: 'btn-blue',
					action: function () {
						var dis = this.$content.find('.name').val();
						if(dis){
							show_loading_progress();
							$.ajax({
								url:"/userQuery",
								type: "POST",
								data: "newDiscipline_f=1&name="+dis,
								cache: false,
								success: function(result){
									hide_loading_progress();
									obj = jQuery.parseJSON(result);
									if(obj.result){
										if(obj.result=='-1'){
											$.alert({title: 'Внимание!',	content: 'такая запись уже есть' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}else{
											$("#disciplines").append("<li  onclick='disciplineItemClicked("+obj.result+")'><a href='#' class='changediscipline' id='"+obj.result+"'oncontextmenu='return menu(4, event,"+obj.result+")'>"+dis+"</a></li>");
										}
									}
								}
							});
							return true;
						}
					}
				},
				отмена: function () {
				},
			},
			onContentReady: function () {
				// bind to events
				var jc = this;
				this.$content.find('form').on('submit', function (e) {
					// if the user submits the form by pressing enter in the field.
					e.preventDefault();
					jc.$$formSubmit.trigger('click'); // reference the button and click it
				});
			}
		});
	}else if(name=="addMaterials"){
		if(getCookie("selectedDiscipline")){
			$("#loadmaterials").show("slow");
		}else{
			$.alert({title: 'Внимание!',	content: 'дисциплина не выбрана' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}
	}else if(name=="load_materials_clicked") {
		if (photo) {
			show_loading_progress();
			var data = new FormData();
			$.each(photo, function( key, value ){
				data.append( key, value );
			});
			data.append("id", getCookie("selectedDiscipline"));

			$.ajax({
				url: "/fileLoader",
				type: "POST",
				data: data,
				cache: false,
				processData: false,
				contentType: false,
				success: function (result) {
					obj = jQuery.parseJSON(result);
					if (obj.result=="0") {
						$.alert({title: 'Внимание!',	content: 'в ходе выгрузки файлов возникли ошибки' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
					}
					disciplineItemClicked(getCookie("selectedDiscipline"));
					$("#loadmaterials").hide("slow");
					hide_loading_progress();
				}
			});
		}else{
			$("#loadmaterials").hide("slow");
		}
	}else if(name=="findevent") {
		eventtype = $(".findeventtype option:selected").attr("id");
		addeddiscipline = $(".finddiscipline option:selected").attr("id");
		addedgroup = $(".findgroup option:selected").attr("id");
		addeddate = $(".datepicker-here[name=datepicker2]").val();
		dontusetime = $("#cc").is(':checked');
		show_loading_progress();
		$('.eventcardshowevent button').remove();
		$.ajax({
			url: "/userQuery",
			type: "POST",
			data: "findEvent_f=1&eventtype=" + eventtype + "&addeddiscipline=" + addeddiscipline + "&addedgroup=" + addedgroup +"&addeddate=" + addeddate+"&dontusetime="+dontusetime,
			cache: false,
			success: function (result) {
				hide_loading_progress();
				obj = jQuery.parseJSON(result);
				str="";
				var isany_event=false;
				$.each(obj, function(key, value) {
					isany_event=true;
					values_array=value.split('_')
					str="";
					str=values_array[0]+" по предмету '"+values_array[1]+"' у группы '"+values_array[2]+"' "+values_array[3]+" в "+values_array[4];
					$(".eventcardshowevent").append("<button class='material_button' id='"+key+"' oncontextmenu='return menu(6, event,"+key+
						")'><span><img id='material_button_image' src='resource/images/event.png' alt='' style='vertical-align:middle'>"+
						str+"</span></button>");
				});
				if(!isany_event){
					$.alert({title: 'Внимание!',	content: 'ни одного события не найдено' ,	boxWidth: '30%', type: 'blue', useBootstrap: false,});
				}
			}
		});


	}else if(name=="addevent") {
		eventtype = $(".addeventtype option:selected").attr("id");
		addeddiscipline = $(".adddiscipline option:selected").attr("id");
		addedgroup = $(".addgroup option:selected").attr("id");
		addeddate = $(".datepicker-here[name=datepicker1]").val();
		addedinfo=$("#event_info_text").val();
		if (!(eventtype && addeddiscipline && addedgroup && addeddate)) {
			$.alert({title: 'Внимание!',	content: 'при добавлении необходимо выбрать все поля, поиск исходя из вашей фантазии' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		} else {
			show_loading_progress();
			$.ajax({
				url: "/userQuery",
				type: "POST",
				data: "newEvent_f=1&eventtype=" + eventtype + "&addeddiscipline=" + addeddiscipline + "&addedgroup=" + addedgroup +"&addedinfo="+addedinfo+"&addeddate=" + addeddate,
				cache: false,
				success: function (result) {
					hide_loading_progress();
					obj = jQuery.parseJSON(result);
					if (obj.result == "1") {
						$.alert({title: 'Мои поздравления!',	content: 'успешно' ,	boxWidth: '30%', type: 'green', useBootstrap: false,});
						$("#event_info_text").val("");
					} else {
						$.alert({title: 'Внимание!',	content: 'что-то пошло не так' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
						$("#event_info_text").val("");
					}

				}
			});
		}
	}else if(name=="showhidenew") {
		if(getCookie("neweventshow")){
			if(getCookie("neweventshow")==0){
				$(".eventcardnewevent").show("100");
				document.cookie = "neweventshow="+1;
			}else{
				$(".eventcardnewevent").hide("100");
				document.cookie = "neweventshow="+0;
			}
		}else{
			document.cookie = "neweventshow="+0;
			$(".eventcardnewevent").hide("100");
		}
	}else if(name=="showhideshow") {
		if(getCookie("showhideshow")){
			if(getCookie("showhideshow")==0){
				$(".eventcardshowevent").show("100");
				document.cookie = "showhideshow="+1;
			}else{
				$(".eventcardshowevent").hide("100");
				document.cookie = "showhideshow="+0;
			}
		}else{
			document.cookie = "showhideshow="+0;
			$(".eventcardshowevent").hide("100");
		}
	}else if(name=="showhidefind") {
		if(getCookie("findeventshow")){
			if(getCookie("findeventshow")==0){
				$(".eventcardfindevent").show("100");
				document.cookie = "findeventshow="+1;
			}else{
				$(".eventcardfindevent").hide("100");
				document.cookie = "findeventshow="+0;
			}
		}else{
			document.cookie = "findeventshow="+0;
			$(".eventcardfindevent").hide("100");
		}
	}else if(name=="makereport"){
		reportdisciplinetype = $(".reportdisciplinetype option:selected").attr("id");
		reporttype = $(".reporttype option:selected").attr("id");
		reportgroup = $(".reportgroup option:selected").attr("id");
		reportpupil = $(".reportobject option:selected").attr("id");
		reportdiscipline = $(".reportdiscipline option:selected").attr("id");
		fromdate = $(".datepicker-here[name=from]").val();
		todate = $(".datepicker-here[name=to]").val();

		fromdatearr=fromdate.split('.');
		todatearr=todate.split('.');

		if(!reportdisciplinetype){
			$.alert({title: 'Внимание!',	content: 'выберите тип занятия' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}else if(!reporttype){
			$.alert({title: 'Внимание!',	content: 'выберите тип отчёта' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}else if(!reportgroup){
			$.alert({title: 'Внимание!',	content: 'выберите группу' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}else if(!reportdiscipline){
			$.alert({title: 'Внимание!',	content: 'выберите дисциплину' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}else if(!fromdate || !todate){
			$.alert({title: 'Внимание!',	content: 'выберите промежуток формирования отчёта' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}else if((todatearr[2]<fromdatearr[2]) || (todatearr[2]<=fromdatearr[2] && todatearr[1]<fromdatearr[1]) ||(todatearr[2]<=fromdatearr[2] && todatearr[1]<=fromdatearr[1] && todatearr[0]<fromdatearr[0])){
			$.alert({title: 'Внимание!',	content: 'конечная дата меньше начальной' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
		}else{
			show_loading_progress();
			if(reportpupil){//посещаемость одного
				if(reporttype==1){//посещаемость
					$.ajax({
						url:"/userQuery",
						type: "POST",
						data: "pupil_absent_f=1&reportpupil="+reportpupil+"&reportdisciplinetype="+reportdisciplinetype+"&reportgroup="+reportgroup+"&reportdiscipline="+ reportdiscipline+"&fromdate="+fromdate+"&todate="+todate,
						cache: false,
						success: function(result) {
							hide_loading_progress();
							$("#pupil_info_text").val("");
							obj = jQuery.parseJSON(result);
							var resstring = "";
							var absentsumm = 0;
							var num = 0;
							$.each(obj, function (key, value) {
								ar = value.split("_");
								resstring = resstring + ar[0] + " : " + (ar[1] == "1" ? "не было" : "был") + "\n";
								absentsumm += ar[1] == "1" ? 1 : 0;
								num += 1;
							});
							if(num==0){
								$("#text_report").val("нет данных для формирования отчёта");
								new Chartist.Line('.ct-chart', {
									labels: ['Д', 'А', 'Н', 'Н', 'Ы', 'Х', '_', 'Н', 'Е', 'Т'],
									series: [
										[1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
										[10,9,8,7,6,5,4,3,2,1],
										[5,5,5,5,5,5,5,5,5,5],
										[1,1,1,1,1,1,1,1,1,1],
										[2,2,2,2,2,2,2,2,2,2],
										[3,3,3,3,3,3,3,3,3,3],
										[4,4,4,4,4,4,4,4,4,4],
										[6,6,6,6,6,6,6,6,6,6],
										[7,7,7,7,7,7,7,7,7,7],
										[8,8,8,8,8,8,8,8,8,8],
										[9,9,9,9,9,9,9,9,9,9],
										[10,10,10,10,10,10,10,10,10,10],
										[0,0,0,0,0,0,0,0,0,0]

									]
								}, {
									low: 0,
									showArea: true
								});
							}else {
								var percent = 100 / num * absentsumm;
								resstring += "процент пропущеных=" + percent;
								$("#text_report").val(resstring);

								var data = {
									series: [absentsumm, num - absentsumm]
								};
								var sum = function (a, b) {
									return a + b
								};
								new Chartist.Pie('.ct-chart', data, {
									labelInterpolationFnc: function (value) {
										if (value != 0)
											return Math.round(value / data.series.reduce(sum) * 100) + '%';
									}
								});
							}

						}
					});
				}else if(reporttype==2){
					$.ajax({
						url:"/userQuery",
						type: "POST",
						data: "pupil_marks_f=1&reportpupil="+reportpupil+"&reportdisciplinetype="+reportdisciplinetype+"&reportgroup="+reportgroup+"&reportdiscipline="+ reportdiscipline+"&fromdate="+fromdate+"&todate="+todate,
						cache: false,
						success: function(result) {
							hide_loading_progress();
							$("#pupil_info_text").val("");
							obj = jQuery.parseJSON(result);
							datearray=[];
							marksarray=[]
							var resstring = "";
							var markssumm = 0;
							var num = 0;
							$.each(obj, function (key, value) {
									ar = value.split("_");
								if(ar[1]){
									resstring = resstring + ar[0] + " : " + ar[1] + "\n";
									mrks=ar[1].split(",");
									mrks.forEach(function(mrk, i, mrks) {
										markssumm += Number(mrk);
										num += 1;
										datearray.push(ar[0]);
										marksarray.push(Number(mrk));
									});
								}
							});
							if(num==0){
								$("#text_report").val("нет данных для формирования отчёта");
								new Chartist.Line('.ct-chart', {
									labels: ['Д', 'А', 'Н', 'Н', 'Ы', 'Х', '_', 'Н', 'Е', 'Т'],
									series: [
										[1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
										[10,9,8,7,6,5,4,3,2,1],
										[5,5,5,5,5,5,5,5,5,5],
										[1,1,1,1,1,1,1,1,1,1],
										[2,2,2,2,2,2,2,2,2,2],
										[3,3,3,3,3,3,3,3,3,3],
										[4,4,4,4,4,4,4,4,4,4],
										[6,6,6,6,6,6,6,6,6,6],
										[7,7,7,7,7,7,7,7,7,7],
										[8,8,8,8,8,8,8,8,8,8],
										[9,9,9,9,9,9,9,9,9,9],
										[10,10,10,10,10,10,10,10,10,10],
										[0,0,0,0,0,0,0,0,0,0]

									]
								}, {
									low: 0,
									showArea: true
								});
							}else {
								resstring=resstring+"средний балл = "+markssumm/num;
								$("#text_report").val(resstring);
								new Chartist.Line('.ct-chart', {
									labels: datearray,
									series: [
										marksarray
									]
								}, {
									fullWidth: true,
									chartPadding: {
										right: 40
									}
								});
							}

						}
					});
				}
				//посещаемость всех
			}else{

				if(reporttype==1){
					$.ajax({
						url:"/userQuery",
						type: "POST",
						data: "all_pupil_absent_f=1"+"&reportdisciplinetype="+reportdisciplinetype+"&reportgroup="+reportgroup+"&reportdiscipline="+ reportdiscipline+"&fromdate="+fromdate+"&todate="+todate,
						cache: false,
						success: function(result){
							hide_loading_progress();
							var resstring="";
							var isanynotes=false;
							var names=[];
							var abs=[];
							var notabs=[];
							obj = jQuery.parseJSON(result);
								$.each(obj, function (key, value) {
									isanynotes=true;
									var nm=key.split("_");
									var ab=value.split("_");
									var notabsent=0;
									var absent=0;
									names.push(nm[1]);

									for(var i=0;i<ab.length;i++){
										if(ab[i]=="0"){
											notabsent++;
										}else if (ab[i]=="1"){
											absent++;
										}
									}
									resstring+=nm[1]+" : был = "+notabsent+"; не было = "+absent+"\n";
									abs.push(absent);
									notabs.push(notabsent);
								});

							if(isanynotes) {
								$("#text_report").val(resstring);
								new Chartist.Bar('.ct-chart', {
									labels: names,
									series: [
										notabs,
										abs
									]
								}, {
									seriesBarDistance: 10,
									axisX: {
										offset: 60
									},
									axisY: {
										offset: 80,
										labelInterpolationFnc: function (value) {
											return value
										},
										scaleMinSpace: 15
									}
								});
							}else {
								$("#text_report").val("нет данных для формирования отчёта");
								new Chartist.Line('.ct-chart', {
									labels: ['Д', 'А', 'Н', 'Н', 'Ы', 'Х', '_', 'Н', 'Е', 'Т'],
									series: [
										[1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
										[10,9,8,7,6,5,4,3,2,1],
										[5,5,5,5,5,5,5,5,5,5],
										[1,1,1,1,1,1,1,1,1,1],
										[2,2,2,2,2,2,2,2,2,2],
										[3,3,3,3,3,3,3,3,3,3],
										[4,4,4,4,4,4,4,4,4,4],
										[6,6,6,6,6,6,6,6,6,6],
										[7,7,7,7,7,7,7,7,7,7],
										[8,8,8,8,8,8,8,8,8,8],
										[9,9,9,9,9,9,9,9,9,9],
										[10,10,10,10,10,10,10,10,10,10],
										[0,0,0,0,0,0,0,0,0,0]

									]
								}, {
									low: 0,
									showArea: true
								});
							}
						}
					});
				}else if(reporttype==2){
					$.ajax({
						url:"/userQuery",
						type: "POST",
						data: "all_pupil_marks_f=1"+"&reportdisciplinetype="+reportdisciplinetype+"&reportgroup="+reportgroup+"&reportdiscipline="+ reportdiscipline+"&fromdate="+fromdate+"&todate="+todate,
						cache: false,
						success: function(result){
							hide_loading_progress();
							var resstring="";
							var isanynotes=false;
							var names=[];
							var mrks=[];
							obj = jQuery.parseJSON(result);
							$.each(obj, function (key, value) {
								isanynotes=true;
								var nm=key.split("_");
								var ab=value.split(",");
								var sum=0;
								var num=0;
								names.push(nm[1]);

								for(var i=0;i<ab.length;i++){
									if(ab[i]){
										num++;
										sum+=Number(ab[i]);
									}
								}
								aver=sum/num;
								if(!aver){
									aver="данных нет";
								}
								resstring+=nm[1]+" : "+aver+"\n";
								mrks.push(aver);
							});

							if(isanynotes) {
								$("#text_report").val(resstring);
								new Chartist.Bar('.ct-chart', {
									labels: names,
									series: mrks
								}, {
									distributeSeries: true
								});
							}else {
								$("#text_report").val("нет данных для формирования отчёта");
								new Chartist.Line('.ct-chart', {
									labels: ['Д', 'А', 'Н', 'Н', 'Ы', 'Х', '_', 'Н', 'Е', 'Т'],
									series: [
										[1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
										[10,9,8,7,6,5,4,3,2,1],
										[5,5,5,5,5,5,5,5,5,5],
										[1,1,1,1,1,1,1,1,1,1],
										[2,2,2,2,2,2,2,2,2,2],
										[3,3,3,3,3,3,3,3,3,3],
										[4,4,4,4,4,4,4,4,4,4],
										[6,6,6,6,6,6,6,6,6,6],
										[7,7,7,7,7,7,7,7,7,7],
										[8,8,8,8,8,8,8,8,8,8],
										[9,9,9,9,9,9,9,9,9,9],
										[10,10,10,10,10,10,10,10,10,10],
										[0,0,0,0,0,0,0,0,0,0]

									]
								}, {
									low: 0,
									showArea: true
								});
							}
						}
					});
				}
			}
		}
	}
}







//=================================================================================
// Функция для определения координат указателя мыши
function defPosition(event) {
    var x = y = 0;
    if (document.attachEvent != null) { // Internet Explorer & Opera
        x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
        y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
    } else if (!document.attachEvent && document.addEventListener) { // Gecko
        x = event.clientX + window.scrollX;
        y = event.clientY + window.scrollY;
    } else {
        // Do nothing
    }
    return {x:x, y:y};
}

//=================================================================================
function menu(type, evt, id) {
    // Блокируем всплывание события contextmenu
    evt = evt || window.event;
    evt.cancelBubble = true;
    // Показываем собственное контекстное меню
    var menu = document.getElementById("contextMenuId");
    var html = "";
    switch (type) {
        case (1) :
            html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'changeItem'"+','+id+')">изменить </button>';
            html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'removeItem'"+','+id+')">удалить </button>';
            break;
        case (2) :		
            html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'changeItem'"+','+id+')">изменить </button>';
            html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'removeItem'"+','+id+')">удалить </button>';
            break;
		case (3) :
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'changePhoto'"+','+id+')">загрузить </button>';
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'deletePhoto'"+','+id+')">очистить </button>';
			break;
		case (4) :
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'changeItem'"+','+id+')">изменить </button>';
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'removeItem'"+','+id+')">удалить </button>';
			break;
		case (5) :
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'downloadItem'"+','+id+')">скачать </button>';
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'removeItem'"+','+id+')">удалить </button>';
			break;
		case (6) :
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'removeItem'"+','+id+')"> &nbsp &nbsp удалить &nbsp &nbsp </button>';
			html += '<button id="contextmenuButton" onclick="onContextItemClick('+type+','+"'selectItem'"+','+id+')"> &nbsp &nbsp редактировать &nbsp &nbsp </button>';
			break;
        default :
            // Nothing
            break;
    }
    // Если есть что показать - показываем
    if (html) {
        menu.innerHTML = html;
        menu.style.top = defPosition(evt).y + "px";
        menu.style.left = defPosition(evt).x + "px";
        menu.style.display = "";
    }
    // Блокируем всплывание стандартного браузерного меню
    return false;
}


//=================================================================================
// Закрываем контекстное при клике левой или правой кнопкой по документу
// Функция для добавления обработчиков событий
function addHandler(object, event, handler, useCapture) {
    if (object.addEventListener) {
        object.addEventListener(event, handler, useCapture ? useCapture : false);
    } else if (object.attachEvent) {
        object.attachEvent('on' + event, handler);
    } else alert("что-то н так с контекстным меню");
}
addHandler(document, "contextmenu", function() {
    document.getElementById("contextMenuId").style.display = "none";
});
addHandler(document, "click", function() {
    document.getElementById("contextMenuId").style.display = "none";
});


//=================================================================================
function onContextItemClick(type,action, id){
    switch (type) {
        case (1) :
            if(action=="changeItem"){
				$.confirm({
					title: 'Пожалуйста',
					boxWidth: '30%',
					type: 'green',
					useBootstrap: false,
					content: '' +
					'<form action="" class="formName">' +
					'<div class="form-group">' +
					'<label>введите новое название</label>' +
					'<input type="text" placeholder="Название" class="name form-control" required />' +
					'</div>' +
					'</form>',
					buttons: {
						formSubmit: {
							text: 'ок',
							btnClass: 'btn-blue',
							action: function () {
								var newName = this.$content.find('.name').val();
								if(newName){
									show_loading_progress();
									$.ajax({
										url:"/userQuery",
										type: "POST",
										data: "changeGroup_f=1&id="+id+"&newName="+ newName,
										cache: false,
										success: function(result){
											hide_loading_progress();
											obj = jQuery.parseJSON(result);
											if(obj.result){
												if(obj.result=='1'){
													$(".changegroup#"+id).text(newName);
												}else{
													$.alert({title: 'Внимание!',	content: 'не удалось переименовать' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
												}
											}
										}
									});
									return true;
								}
							}
						},
						отмена: function () {
						},
					},
					onContentReady: function () {
						// bind to events
						var jc = this;
						this.$content.find('form').on('submit', function (e) {
							// if the user submits the form by pressing enter in the field.
							e.preventDefault();
							jc.$$formSubmit.trigger('click'); // reference the button and click it
						});
					}
				});
            }else  if(action=="removeItem"){
				$.confirm({
					title: 'Подтверждение',
					content: 'Удалить группу "'+($(".changegroup#"+id).text())+'"?',
					boxWidth: '30%',
					type: 'blue',
					useBootstrap: false,
					buttons: {
						ок: function () {
							show_loading_progress();
							$.ajax({
								url:"/userQuery",
								type: "POST",
								data: "removeGroup_f=1&id="+id,
								cache: false,
								success: function(result){
									hide_loading_progress();
									obj = jQuery.parseJSON(result);
									if(obj.result){
										if(obj.result=='1'){
											$(".changegroup#"+id).remove();
										}else{
											$.alert({title: 'Внимание!',	content: 'не удалось удалить' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}
									}
								}
							});
						},
						отмена: function () {
						}
					}
				});
            }
			break;
		case (2) :
            if(action=="changeItem"){
				$.confirm({
					title: 'Пожалуйста',
					boxWidth: '30%',
					type: 'green',
					useBootstrap: false,
					content: '' +
					'<form action="" class="formName">' +
					'<div class="form-group">' +
					'<label>введите новое имя</label>' +
					'<input type="text" placeholder="Название" class="name form-control" required />' +
					'</div>' +
					'</form>',
					buttons: {
						formSubmit: {
							text: 'ок',
							btnClass: 'btn-blue',
							action: function () {
								var newName = this.$content.find('.name').val();
								if(newName){
									show_loading_progress();
									$.ajax({
										url:"/userQuery",
										type: "POST",
										data: "changePupilName_f=1&id="+id+"&newName="+ newName,
										cache: false,
										success: function(result){
											hide_loading_progress();
											obj = jQuery.parseJSON(result);
											if(obj.result){
												if(obj.result=='1'){
													$("#"+id+".changepupil").text(newName);
													$("#pupil_ancet_name").text($("#"+id+".changepupil").text());   // Установить надрись
												}else{
													$.alert({title: 'Внимание!',	content: 'не удалось переименовать' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
												}
											}
										}
									});
									return true;
								}
							}
						},
						отмена: function () {
						},
					},
					onContentReady: function () {
						// bind to events
						var jc = this;
						this.$content.find('form').on('submit', function (e) {
							// if the user submits the form by pressing enter in the field.
							e.preventDefault();
							jc.$$formSubmit.trigger('click'); // reference the button and click it
						});
					}
				});
            }else  if(action=="removeItem"){
				$.confirm({
					title: 'Подтверждение',
					content: 'Удалить запись "'+($("#"+id+".changepupil").text())+'"?',
					boxWidth: '30%',
					type: 'blue',
					useBootstrap: false,
					buttons: {
						ок: function () {
							show_loading_progress();
							$.ajax({
								url:"/userQuery",
								type: "POST",
								data: "removePupil_f=1&id="+id,
								cache: false,
								success: function(result){
									hide_loading_progress();
									obj = jQuery.parseJSON(result);
									if(obj.result){
										if(obj.result=='1'){
											$("#"+id+".changepupil").remove();
										}else if(obj.result=='-1'){
											$.alert({title: 'Внимание!',	content: 'что-то пошло не так' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}else{
											$.alert({title: 'Внимание!',	content: 'не удалось удалить' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}
									}
								}
							});
						},
						отмена: function () {
						}
					}
				});
            }
			break;
		case (3) :
			pupil_id = getCookie("selectedpupil");
			if(pupil_id) {
				if (action == "changePhoto") {
					$("#loadphoto").show("slow");
				} else if (action == "deletePhoto") {
					$.confirm({
						title: 'Подтверждение',
						content: 'Вы действительно хотите удалить фотографию?',
						boxWidth: '30%',
						type: 'blue',
						useBootstrap: false,
						buttons: {
							ок: function () {
								$.ajax({
									url:"/userQuery",
									type: "POST",
									data: "removePhoto_f=1&id="+getCookie("selectedpupil"),
									cache: false,
									success: function(result){
										hide_loading_progress();
										obj = jQuery.parseJSON(result);
										if(obj.result){
											if(obj.result=='1'){
												$("#pupil_photo").attr("src","resource/images/no-photo.png");
											}else if(obj.result=='-1'){
												$.alert({title: 'Внимание!',	content: 'что-то пошло не так' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
											}
										}
									}
								});
							},
							отмена: function () {
							}
						}
					});
				}
			}else{
				$.alert({title: 'Внимание!',	content: 'выберите ученика' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
			}
			break;
		case(4):
			if(action=="changeItem"){
				$.confirm({
					title: 'Пожалуйста',
					boxWidth: '30%',
					type: 'green',
					useBootstrap: false,
					content: '' +
					'<form action="" class="formName">' +
					'<div class="form-group">' +
					'<label>введите новое название</label>' +
					'<input type="text" placeholder="Название" class="name form-control" required />' +
					'</div>' +
					'</form>',
					buttons: {
						formSubmit: {
							text: 'ок',
							btnClass: 'btn-blue',
							action: function () {
								var newName = this.$content.find('.name').val();
								if(newName){
									show_loading_progress();
									$.ajax({
										url:"/userQuery",
										type: "POST",
										data: "changeDiscipline_f=1&id="+id+"&newName="+ newName,
										cache: false,
										success: function(result){
											hide_loading_progress();
											obj = jQuery.parseJSON(result);
											if(obj.result){
												if(obj.result=='1'){
													$(".changediscipline#"+id).text(newName);
												}else{
													$.alert({title: 'Внимание!',	content: 'не удалось переименовать' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
												}
											}
										}
									});
									return true;
								}
							}
						},
						отмена: function () {
						},
					},
					onContentReady: function () {
						// bind to events
						var jc = this;
						this.$content.find('form').on('submit', function (e) {
							// if the user submits the form by pressing enter in the field.
							e.preventDefault();
							jc.$$formSubmit.trigger('click'); // reference the button and click it
						});
					}
				});
			}else  if(action=="removeItem"){
				$.confirm({
					title: 'Подтверждение',
					content: 'Удалить дисциплину "'+($(".changediscipline#"+id).text())+'"?',
					boxWidth: '30%',
					type: 'blue',
					useBootstrap: false,
					buttons: {
						ок: function () {
							show_loading_progress();
							$.ajax({
								url:"/userQuery",
								type: "POST",
								data: "removeDiscipline_f=1&id="+id,
								cache: false,
								success: function(result){
									hide_loading_progress();
									obj = jQuery.parseJSON(result);
									if(obj.result){
										if(obj.result=='1'){
											$(".changediscipline#"+id).remove();
										}else{
											$.alert({title: 'Внимание!',	content: 'не удалось удалить' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}
									}
								}
							});
						},
						отмена: function () {
						}
					}
				});
			}
			break;
			case(5):
			if(action=="removeItem"){
				$.confirm({
					title: 'Подтверждение',
					content: 'Удалить файл "'+($("#"+id+".material_button").text())+'"?',
					boxWidth: '30%',
					type: 'blue',
					useBootstrap: false,
					buttons: {
						ок: function () {
							show_loading_progress();
							$.ajax({
								url:"/userQuery",
								type: "POST",
								data: "removeMaterial_f=1&id="+id,
								cache: false,
								success: function(result){
									hide_loading_progress();
									obj = jQuery.parseJSON(result);
									if(obj.result){
										if(obj.result=='1'){
											$("#"+id+".material_button").remove();
										}else{
											$.alert({title: 'Внимание!',	content: 'не удалось удалить' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
										}
									}
								}
							});
						},
						отмена: function () {
						}
					}
				});
			}else if(action=="downloadItem"){
					$.ajax({
						url:"/userQuery",
						type: "POST",
						data: "make_download_link_f=1&id="+id+"&m_id="+getCookie("selectedDiscipline"),
						cache: false,
						success: function(result){
							go("downloadfile");
						}
					});		
			}
			break;
		case(6):
			if(action=="selectItem"){
				document.cookie = "selectedevent="+id;
				$.ajax({
					url:"/userQuery",
					type: "POST",
					data: "get_evet_details_f=1&id="+id,
					cache: false,
					success: function(result) {
						$(".event_info_editing").show(500);
						obj = jQuery.parseJSON(result);
						if (obj.type == "reminder") {
							$("#event_edit_info").val(obj.info);
							$(".event_editing").hide(500);
							scroll_to_bottom(700);
						} else {
							$(".event_editing").show(500);
							num=1;
							$("#events_table tr").remove();
							$("#events_table").append("<tr><td class='noedit'>УЧЕНИК</td><td class='noedit'>ОТСУТСТВУЕТ</td><td class='noedit'>ОЦЕНКИ</td><td class='noedit'>ЗАМЕТКИ</td></tr>");
							$.each(obj, function (key, value) {
								if (key != "type" && key != "info") {
									info=value.split('_');
									$("#events_table").append("<tr><td class='noedit'>" + num+". "+info[0] + "</td><td class='check'   id='"+key+"'><input type='checkbox' class='checker' id='"+key+"'></td><td class='marks' id='" + key + "'>"+info[2]+"</td><td class='info' id='" + key + "'>"+info[3]+" </td></tr>");
									if(info[1]==1) {
										$("#" + key + ".checker").prop("checked", true);
									}
									num++;
								}else if(key == "info"){
									$("#event_edit_info").val(value);
								}
							});
						}
						scroll_to_bottom(700);
					}
				});
			}else if(action=="removeItem") {
				$.confirm({
					title: 'Подтверждение',
					content: 'Удалить запись "' + ($("#"+id+".material_button").text()) + '"?',
					boxWidth: '30%',
					type: 'blue',
					useBootstrap: false,
					buttons: {
						ок: function () {
							$.ajax({
								url: "/userQuery",
								type: "POST",
								data: "remove_event_f=1&id=" + id,
								cache: false,
								success: function (result) {
									obj = jQuery.parseJSON(result);
									if (obj.result == 1) {
										$("#" + id + ".material_button").remove();
									}
								}
							});
						},
						отмена: function () {
						}
					}
				});



			}
    }
}
//=================================================================================
function loadGroups(){
	$.ajax({
							url:"/userQuery",
							type: "POST",
							data: "loadGroups_f=1",
							cache: false,
							success: function(result){	
								obj = jQuery.parseJSON(result);								
									str="";
									$.each(obj, function(key, value) {
									  str+=value;
									});
								$.alert({title: 'Внимание!',	content: str ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
							}
						});	
}


//=================================================================================
function groupItemClicked(id){
	$(".changegroup").css("background-color", "#dad2ca");
	$(".changegroup#"+id).css("background-color", "#ababab");
	show_loading_progress();
	$.ajax({
							url:"/userQuery",
							type: "POST",
							data: "loadPupil_f=1&id="+id,
							cache: false,
							success: function(result){
								hide_loading_progress();
								obj = jQuery.parseJSON(result);
								document.cookie = "selectedgroup="+id;
								str="";
									$('#pupils li').remove();
									$.each(obj, function(key, value) {
									  $("#pupils").append("<li onclick='pupilItemClicked("+key+")'><a class='changepupil' href='#' id='"+key+"'oncontextmenu='return menu(2, event,"+key+")'>"+value+"</a></li>");
									  
									});								
							}
						});	
}


//======================================================================================================================
function pupilItemClicked(id){
	show_loading_progress();
	$(".changepupil").css("background-color", "#dad2ca");
	$("#"+id+".changepupil").css("background-color", "#ababab");
	document.cookie = "selectedpupil="+id;
	$("#pupil_ancet_name").text($("#"+id+".changepupil").text());   // Установить надрись

	$.ajax({
		url:"/userQuery",
		type: "POST",
		data: "loadPupilInfo_f=1&id="+id,
		cache: false,
		success: function(result) {
			hide_loading_progress();
			obj = jQuery.parseJSON(result);
			$("#pupil_info_text").val("");
			$("#pupil_info_text").val(obj[3]);

			$("#pupil_photo").attr("src","resource/images/no-photo.png");
			$("#pupil_photo").attr("src",obj[2]);
		}
	});

}

//=================================================================================
function disciplineItemClicked(id){
	$(".changediscipline").css("background-color", "#dad2ca");
	$(".changediscipline#"+id).css("background-color", "#ababab");
	$("#loadmaterials").hide("slow");
	document.cookie = "selectedDiscipline="+id;
	show_loading_progress();
	$.ajax({
		url:"/userQuery",
		type: "POST",
		data: "loadMaterials_f=1&id="+id,
		cache: false,
		success: function(result){
			hide_loading_progress();
			obj = jQuery.parseJSON(result);
			document.cookie = "selectedgroup="+id;

			$("#materials_card").show();			
			$("#materials_card").text("");
			$('#materials_card button').remove();
			hasmaterials=0;			
			$.each(obj, function(key, value) {
				hasmaterials=1;
				$("#materials_card").append("<button class='material_button' id='"+key+"'oncontextmenu='return menu(5, event,"+key+
					")'><span><img id='material_button_image' src='resource/images/file.png' alt='' style='vertical-align:middle'>"+
				value+"</span></button>");
			});
			if(hasmaterials==0){				
				$("#materials_card").text("Материалов по данной дисциплине пока нет (⌒_⌒)");
			}
		}
	});
}

//=================================================================================
function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}



//=================================================================================
function delete_cookie ( cookie_name )
{
	var cookie_date = new Date ( );  // Текущая дата и время
	cookie_date.setTime ( cookie_date.getTime() - 1 );
	document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}

function show_loading_progress(){
	$("#header_loading").show();
}

function hide_loading_progress(){
	$("#header_loading").hide();
}

function scroll_to_bottom(speed) {
	var height= $("body").height();
	$("html,body").animate({"scrollTop":height},speed);
}



/*

$.confirm({
	title: 'Пожалуйста',
	boxWidth: '30%',
	type: 'green',
	useBootstrap: false,
	content: '' +
	'<form action="" class="formName">' +
	'<div class="form-group">' +
	'<label>Введите название новой дисциплины</label>' +
	'<input type="text" placeholder="Название" class="name form-control" required />' +
	'</div>' +
	'</form>',
	buttons: {
		formSubmit: {
			text: 'ок',
			btnClass: 'btn-blue',
			action: function () {
				var dis = this.$content.find('.name').val();
				if(dis){
					show_loading_progress();
					$.ajax({
						url:"/userQuery",
						type: "POST",
						data: "newDiscipline_f=1&name="+dis,
						cache: false,
						success: function(result){
							hide_loading_progress();
							obj = jQuery.parseJSON(result);
							if(obj.result){
								if(obj.result=='-1'){
									$.alert({title: 'Внимание!',	content: 'такая запись уже есть' ,	boxWidth: '30%', type: 'red', useBootstrap: false,});
								}else{
									$("#disciplines").append("<li  onclick='disciplineItemClicked("+obj.result+")'><a href='#' class='changediscipline' id='"+obj.result+"'oncontextmenu='return menu(4, event,"+obj.result+")'>"+dis+"</a></li>");
								}
							}
						}
					});
					return true;
				}
			}
		},
		отмена: function () {
		},
	},
	onContentReady: function () {
		// bind to events
		var jc = this;
		this.$content.find('form').on('submit', function (e) {
			// if the user submits the form by pressing enter in the field.
			e.preventDefault();
			jc.$$formSubmit.trigger('click'); // reference the button and click it
		});
	}
});
	*/

