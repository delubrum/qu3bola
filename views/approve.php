<?php if ($alm->ID == 1) { ?>
<head>
	<link href="assets/css/body.css" rel="stylesheet">
	<script src="assets/tablefilter/dist/tablefilter/tablefilter.js"></script>
</head>
<br>
<center>

<form name="newarte" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" id="arra" name="arra">
<input type="submit" id="login" value="Aprobar Mostradas">
</form>


<table class="tablacal" style="width:50%">
<tr>
<th>Cantidad
<th>Saldo
<tr>
<td id="cantidad">
<td id="valortotal">
</table>
<br>
<table class="tabla" style="padding:2px;color:#000;border-collapse:collapse;font-size:12px;width:100%" id="demo">
<thead>
<tr>
<th>ID</th>
<th>Fecha Creación</th>
<th>Fecha de Solicitud</th>
<th>Asesor</th>
<th>Ciudad</th>
<th>Monto</th>
<th>Comisión</th>
<th>Total</th>
<th>Observaciones</th>
<th>Foto</th>
<th>Aprobar</th>
<th></th>
</tr>
</thead>
<tbody>


<?php
foreach($this->model->List_Approve() as $r):
?>

<tr>
<td><?php echo $r->ID; ?></td>
<td><?php echo $r->creation_date; ?></td>
<td><?php echo date("Y-m-d",strtotime($r->request_date)); ?></td>
<td><?php echo mb_convert_case($this->model->Obtener($r->user)->name, MB_CASE_TITLE, "UTF-8"); ?></td>
<td><?php echo ($r->city == 1) ? "Havana" : "Camauguay"; ?></td>
<td><?php echo number_format($r->amount); ?></td>
<td><?php echo number_format($r->commission, 1, "." , ","); ?></td>
<td class="valorcolumna"><?php echo number_format(($r->commission*($r->amount/100)) + $r->amount); ?></td>
<td><?php echo mb_convert_case($r->obs, MB_CASE_TITLE, "UTF-8"); ?></td>
<td style="text-align:center">

	<?php
	 $directorio = "files/$r->ID/";
if (file_exists($directorio))
	if ($gestor = opendir($directorio)) {
	$list=array();
	while (false !== ($arch = readdir($gestor)))
	{ if ($arch != "." && $arch != "..")
	{ $list[]=$arch; } }
	sort($list);
	foreach($list as $fileName)
	{echo "<a href='$directorio$fileName' target='blank' style='text-decoration:none'><i class='fa fa-image fa-2x'></i></a>"; }
	closedir($gestor);
	}
	?>


</td>
<td class="acciones" style="text-align:center"><i onclick='AprobarCoin(<?php echo $r->ID; ?>)' style='display:inline;color:green;cursor:pointer' class='fa fa-check-square-o fa-2x'></i>  &nbsp; &nbsp; &nbsp;<i onclick='EliminarCoin(<?php echo $r->ID; ?>)' style='display:inline;color:red;cursor:pointer' class='fa fa-close fa-2x'></i></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>



<script>
var tfConfig = {
base_path: 'assets/tablefilter/dist/tablefilter/',
auto_filter: true,
auto_filter_delay: 1, //milliseconds
filters_row_index: 1,
auto_filter: true,
auto_filter_delay: 1, //milliseconds
filters_row_index: 1,
extensions: [{
name: 'sort',
types: ['number','date','date','string','string',
{ type: 'formatted-number', decimal: '.', thousands: ',' },
{ type: 'formatted-number', decimal: '.', thousands: ',' },
{ type: 'formatted-number', decimal: '.', thousands: ',' },]
}]
};
var tf = new TableFilter('demo', tfConfig);
tf.init();











$(document).ready(function(){
var filas = $("#demo tr").length;
var filas = filas-2;
$("#cantidad").html(filas);

var totalDeuda=0;
$(".valorcolumna").each(function(){
	totalDeuda+=parseInt($(this).html().replace(/,/g, "")) || 0;
});

$("#valortotal").html(totalDeuda.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));


var totalDeuda=0;
$(".gananciacolumna").each(function(){
	totalDeuda+=parseInt($(this).html().replace(/,/g, "")) || 0;
});


});


$(document).on('keydown','#demo :input', function() {
var filas = $("#demo tr:visible").length;
var filas = filas-2;
$("#cantidad").html(filas);

var totalDeuda=0;
$(".valorcolumna:visible").each(function(){
	totalDeuda+=parseInt($(this).html().replace(/,/g, "")) || 0;
});

$("#valortotal").html(totalDeuda.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));

var totalDeuda=0;
$(".gananciacolumna:visible").each(function(){
	totalDeuda+=parseInt($(this).html().replace(/,/g, "")) || 0;
});

});


$(document).on('click','#login', function() {
if (confirm("¿Realmente desea Aprobar las solicitudes mostradas?")) {
$( "#loading" ).fadeIn( "slow" );
$('#arra').val($('#demo td:nth-child(1):visible').map(function(){
   return $(this).text();
}).get());
document.newarte.action='?c=Grnte&a=Save_Approve_All';
}
else {
event.preventDefault();
}
});

function AprobarCoin(que) {
if (confirm("¿Realmente desea Aprobar el ingreso?")) {
window.location='?c=Grnte&a=Save_Approve&status=1&id=' + que;
}
else {
event.preventDefault();
}
}

function EliminarCoin(que) {
if (confirm("¿Realmente desea Desea Eliminar el Ingreso?")) {
window.location='?c=Grnte&a=Save_Approve&status=2&id=' + que;
}
else {
event.preventDefault();
}
}






</script>

<?php } ?>
