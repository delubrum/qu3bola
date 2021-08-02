<head>
<link href="assets/css/body.css" rel="stylesheet" type="text/css" media="screen" />
<script src="assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="assets/css/jquery-ui.css"/>
<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/jeoquery.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<style>
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 200px;
	}

	table tr {padding:0;margin:0}
	</style>

</head>
<body style="overflow-x:hidden">
<div style="padding:15px">
<br>
<form name="newarte" method="post" enctype="multipart/form-data" autocomplete="off">

<?php if ($alm->ID=="1") { ?>
		<label>* Empresa / Sede / Usuario</label>
    <select class="sede" name="sede" required >
            <option value=""></option>
      <?php
      foreach($this->model->Listar_Sedes() as $r) {
      ?>
      <option value="<?php echo $r->ID ?>"><?php echo $this->model->Obtener_Empresaid($r->empresa)->nombre ?> / <?php echo $r->nombre ?> / <?php echo $r->usuario ?></option>
      <?php } ?>
    </select>
<?php } ?>

<label>Fecha de Recogida:</label>
<input type="date" name="fecha_recogida" required >
<br>




    <table class="calculadora tablacal" style="width:100%;">
    <tr><th style='width:30%'>Residuo<th style='width:10%'>Cantidad<th style='width:10%'>Unidad<th style="width:50%">Observaciones
<?php foreach($this->model->Listar_Residuos() as $r) { ?>
		<tr><td><input name='residuos[]' style="height:30px;text-transform: uppercase;" value="<?php echo $r->nombre ?>" readonly>
			<td><input name='cantidad[]' style="height:30px" value="0" type="number" step="0.01" required>
			<td><select style="width:100% !important;margin:0;height:30px" name='unidades[]' required>
				<option></option>
<?php foreach($this->model->Listar_Unidades() as $b) { ?>
<option <?php echo ($b->ID == 4) ? ' selected' : '' ?>><?php echo $b->codigo ?></option>
<?php } ?>
</select>
<td><textarea style="width:100%;height:30px !important;margin:0" name="obs[]"></textarea>
<?php } ?>


    </table>

<br>

<center>

<input type="submit" id="login" value="Guardar" onclick ="Guardar()" style="padding:10px;width:100px"></input></center>
</center>
</form>

</div>

<div id="loading"></div>

<script>

$(document).ready(function() {
    $('.sede').select2();
});

$(document).ready(function() {
$(window).keydown(function(event){
if(event.keyCode == 13) {
event.preventDefault();
return false;
}
});
});

$(document).on("keydown", function (e) {
if (e.which === 8  && !$(e.target).is("input:not([readonly]):not([type=radio]):not([type=checkbox]), textarea,[contentEditable], [contentEditable=true]")) {
e.preventDefault();
}
});

$(document).on("keydown", function (e) {
if (e.which === 116) {
e.preventDefault();
}
});

function Guardar() {
if(document.newarte.checkValidity()){
if (confirm("¿Realmente desea Guardar los datos ingresados?")) {
$( "#loading" ).fadeIn( "slow" );
document.newarte.action='?c=Grnte&a=Guardar_Solicitud';
}
else {
event.preventDefault();
}
}
}

</script>
