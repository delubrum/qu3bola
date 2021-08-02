<head>
<style>
table.TF th {
background: #333;
}

#cantidad,#valortotal {display:inline-block}
</style>

<link href="assets/css/body.css" rel="stylesheet">
<script src="assets/tablefilter/dist/tablefilter/tablefilter.js"></script>
</head>
<br>
<center>
<table class="tabla" style="width:50%">
<tr>
<th>#
<th>Total
<th>Pending
<tr>
<td><div id="cantidad"></div>
<td><div id="valortotall"></div></div>
<td><div id="valortotal"></div></div>
</table>

<br>
<table style="padding:2px;color:#000;border-collapse:collapse;font-size:12px;width:100%" id="demo" class="my-table">
<thead>
<tr>
<th>ID</th>
<th>Project Name</th>
<th>Who Follows up?</th>
<th>Request date</th>
<th>Submit date</th>
<th>Currency</th>
<th>Rate</th>
<th>Total Quote</th>
<th>Partial Invoice</th>
<th>Pending Invoice</th>
<th>
</tr>
</thead>
<tbody>


<?php

foreach($this->model->Listar_Solicitudes() as $r):

$CCom=explode('||',$r->CC);
if ($r->estado == 3){

?>

<tr style='cursor:pointer' >
<td onclick="location.href='?c=Grnte&a=Detalles&i=<?php echo $_REQUEST['i'] ?>&id=<?php echo $r->ID ?>'"><?php echo $r->ID; ?></td>
<td onclick="location.href='?c=Grnte&a=Detalles&i=<?php echo $_REQUEST['i'] ?>&id=<?php echo $r->ID ?>'"><?php echo $r->proyecto ?></td>
<td><?php echo ucwords($this->model->Obtener($r->asesor)->usuario) ?></td>
<td><?php echo date("Y-m-d", strtotime($r->fecha)) ?></td>
<td><?php echo ($r->aprobada == null) ? "" : date("Y-m-d", strtotime($r->aprobada)) ?></td>

<td><?php echo (!empty($CCom[3])) ? $CCom[3] : 'USD' ?></td>
<td><?php echo ($r->aprobada == null) ? " " : number_format($CCom[0],0,'','.') ?></td>

<td class="valorcolumna">

<?php 


$total = 0;
foreach($this->model->Listar_Tempi($r->ID,$r->causap) as $q) {
    
$margen = $this->model->Obtener_TempiV($q->ID)->margen;
if (!empty($CCom[3])) { ($CCom[3] == 'USD')  ? $rate=$CCom[0] : $rate = 1; } else { $rate=$CCom[0]; }
$totalusd=$q->valor/$rate;
$margenusd=($totalusd/(1-($margen/100)))- $totalusd;
$com1usd=($totalusd+$margenusd)*($CCom[1]/100);
$com2usd=($totalusd+$margenusd)*($CCom[2]/100);
$pventausd=$totalusd+$margenusd+$com1usd+$com2usd;    

$total =  $total+ceil($pventausd);    
}
echo number_format($total,0,'','.'); 
 ?>
</td>

<td contenteditable="true" class="partial"><?php echo $r->parcial ?></td>
<td class="pending"></td>

<td style="text-align:center"><i onclick='Aprobar(<?php echo $r->ID; ?>)' style='display:inline;color:green;cursor:pointer' class='fa fa-check-square-o fa-2x'></i></td>
</tr>
<?php } endforeach; ?>









</tbody>
</table>



<script>
$(document).ready(function(){

$(".valorcolumna").each(function(){
total = parseInt($(this).html().replace(/\./g,''));
val = $(this).parent().find('.partial').html();
valor = total-val;
$(this).parent().find('.pending').html(valor)
});
});

$(document).on('input','.partial', function() {
link = $(this);
val = link.html();
id= link.parent().find('td:first').html();


$.ajax({
  url: "?c=Grnte&a=Guardar_Parcial&id=" + id + "&val=" + val,
  context: document.body
}).done(function() {



total = parseInt(link.parent().find('.valorcolumna').html().replace(/\./g,''));
valor = total-val;

link.parent().find('.pending').html(valor)

});


});




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
types: ['number','string','string','string','string',
{ type: 'formatted-number', decimal: ',', thousands: '.' },
{ type: 'formatted-number', decimal: ',', thousands: '.' },
{ type: 'formatted-number', decimal: ',', thousands: '.' },]
}]
};
var tf = new TableFilter('demo', tfConfig);
tf.init();











$(document).ready(function(){
var filas = $("#demo tr").length;
var filas = filas-2;
$("#cantidad").html(filas);

var total=0;
$(".pending:visible").each(function(){
	total+=parseInt($(this).html().replace(/\./g,''));
});

$("#valortotal").html(total.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));

var totall=0;
$(".valorcolumna:visible").each(function(){
	totall+=parseInt($(this).html().replace(/\./g,''));
});

$("#valortotall").html(totall.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
});


$(document).on('keydown','#demo :input', function() {
var filas = $("#demo tr:visible").length;
var filas = filas-2;
$("#cantidad").html(filas);

var total=0;
$(".pending:visible").each(function(){
	total+=parseInt($(this).html().replace(/\./g,''));
});

$("#valortotal").html(total.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));

var totall=0;
$(".valorcolumna:visible").each(function(){
	totall+=parseInt($(this).html().replace(/\./g,''));
});

$("#valortotall").html(totall.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
});


function Aprobar(que) {
if (confirm("¿Close order?")) {
window.location='?c=Grnte&a=Actualizar_Cierret&id=' + que;
}
else {
event.preventDefault();
}
}



</script>