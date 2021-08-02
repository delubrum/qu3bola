<head>
<title>Qu3bola - Pagos</title>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<link rel="icon" sizes="192x192" href="assets/img/ico.png" />
<link href="assets/css/register.css" rel="stylesheet" type="text/css" media="screen" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">
<meta name="robots" content="noindex">
</head>

<body>

<div class="contact">

<center>
<img src="assets/img/logo.png">
<br>
<div id="hide">
<form id="register" name="register">
<center>
<input type="text" name="name" id="name" placeholder="Nombre" autofocus>

<div><input type="email" name="email" id="email" placeholder="Email"></div>
<label id="email_exist" class="error_label">Email Previamente Registrado</label>
<label id="email_invalid" class="error_label">Email Inválido</label>

<input type="hidden" name="phone_code" value="<?php echo $countrydata['CountryCode'] ?>">
<div><img style="display:inline !important;margin:0 4px 0 10px;width:15px" src="assets/plugins/flag-icon-css/flags/1x1/<?php echo mb_convert_case($countryISO, MB_CASE_LOWER, "UTF-8"); ?>.svg">
<div style="display:inline !important;font-style: normal;font-weight: bold;font-size: 14px;color: #CCCC;margin: 10px 20px 0 px 20px !important">+ <?php echo $countrydata['CountryCode'] ?>
</div>&nbsp;<input style="display:inline !important;width:185px!important" id="phone" autocomplete="off" name="phone" type="text" data-value="<?php echo $countrydata['CountryCode'] ?>" maxlength="<?php echo $countrydata['MaxDigits'] ?>"
step="1" inputmode="numeric" pattern="<?php echo $countrydata['MobileRegex'] ?>" placeholder="Teléfono / Whatsapp" /></div>
<label id="phone_exist" class="error_label">Teléfono Previamente Registrado</label>

<input type="password" id="pass" name="pass" placeholder="Contraseña">
<br>
<input type="password"  id="cpass" name="cpass" placeholder="Confirma tu contraseña">
<br><br>
<input type="submit" class="send" value="Registrate"></input>
</form>
<br>
<br>
¿Ya eres miembro?
<br><a href="?c=Login&a=Index" style="color:#278dc1;text-decoration:none">¡Ingresa! </a>
</center>
</div>
<div id="registered" style="display:none;width:100%;color: #ffffff!important;font-size: 16px;font-weight: 600; font-size: 20px; text-shadow: 0em 0.1em 0.1em rgba(0,0,0,0.4);">Gracias!</div>
</div>
</div>
</body>

<script>
//METODO REGEX PARA LOS PHONE
var patt = new RegExp($('#phone').attr('pattern'));
jQuery.validator.addMethod("regex2", function(value, element) {
return this.optional(element) || patt.test( $("#phone").data("value").toString()+value.toString());
});

function Regex() {
var str = $("#phone").data("value").toString() + $('#phone').val().toString();
var patt = new RegExp($('#phone').attr('pattern'));
var res = patt.test(str);
}
//NO COPY / PASTE
$('input[type=text]').bind("cut copy paste",function(e) {
e.preventDefault();
});
//NO RIGHT CLICK
$('input[type=text]').bind("contextmenu",function(e) {
e.preventDefault();
});



$('#email').on('keypress', function(e) {
if (e.which == 32){
return false;
}
});

$('#email').on('blur', function() {
str = $(this).val()
$('#email').val(str.toLowerCase());
});


max = $('#phone').attr('max');

$('#register').validate({
rules: {
'name': 'required',
'pass' : {
required: true,
minlength : 5
},
'cpass' : {
required: true,
minlength : 5,
equalTo : "#pass"
},
'email': { required: true, email: true },
'phone': {
required: true,
maxlength: max,
minlength: 3,
regex2: true,
}
},
messages: {
'name': 'Nombre Requerido',
'pass' : {
required: 'Contraseña requerida',
minlength : 'Minimo 5 Caracteres'
},
'cpass' : {
required: 'Confirmación requerida',
minlength : 'Minimo 5 caracteres',
equalTo : "Contraseña y confirmación deben ser iguales"
},
'email': { required: 'Email Requerido', email: 'Formato invalido' },
'phone': {
required: 'Telefono Requerido',
minlength: 'Minimo de caracteres no completado',
maxlength: 'Telefono mas caracteres de los validos',
regex2: 'Formato invalido',
}
},

submitHandler: function() {
$.ajax({
type: 'POST',
url: '?c=Login&a=Register',
data: $("#register").serialize(),
success: function(data) {
if(data == "yes") {
$('#hide').css("display", "none");
$('#registered').css("display", "block");
} else if(data=="phone_exist"){
$("#phone_exist").show(10);
}	else if(data=="email_exist"){
$("#email_exist").show(10);
}	else if(data=="Error al enviar Email"){
alert('correo');
}

 else{
alert('Ocurrio un error datos no salvados');
}
}
});
}
});

$(document).ready(function() {
$("#email_exist").hide();
$("#email_invalid").hide();
$("#phone_exist").hide();
// OCULTAR LABELS DE MENSAJES
$("#email").focus(function() {
$("#email_exist").hide();
$("#email_invalid").hide();
$("#phone_exist").hide();
});

// OCULTAR LABELS DE MENSAJES
$("#phone").focus(function() {
$("#email_exist").hide();
$("#email_invalid").hide();
$("#phone_exist").hide();
});

$("#phone").keydown(function(e) {
// Allow: backspace, delete, tab, escape, enter and .
if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
// Allow: Ctrl+A
(e.keyCode == 65 && e.ctrlKey === true) ||
// Allow: home, end, left, right
(e.keyCode >= 35 && e.keyCode <= 39)) {
// let it happen, don't do anything
return;
}
// Ensure that it is a number and stop the keypress
if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
e.preventDefault();
}
});

$('#name').keydown(function(e) {
if((e.which >= 65 && e.which <= 90) || (e.which >= 35 && e.which <= 40) || (e.which == 8) || (e.which == 46) || (e.which == 32) || (e.which == 190) || (e.which == 9)){
return true;
} else {
return false;
}
});

$('#name').blur(function(e) {
$('#name').val(toTitleCase($('#name').val()));
});
});

function toTitleCase(str){
return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

</script>
