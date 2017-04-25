//отключим стандартную обработку формы
$('.login-form').submit(function (e) {
   e.preventDefault();
});

$('.register-form').submit(function (e) {
   e.preventDefault();
});

$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});


