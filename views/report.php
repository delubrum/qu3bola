<?php if ($alm->ID == 1) { ?>
<head>
	<link href="assets/css/body.css" rel="stylesheet">
	<script src="assets/tablefilter/dist/tablefilter/tablefilter.js"></script>
</head>

<center>
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
<th>Estado</th>
<th>Fecha Estado</th>
</tr>
</thead>
<tbody>


<?php
foreach($this->model->List_Approved() as $r):
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
<td>
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

<td><?php echo ($r->status == 1) ? 'Aprobado' : 'Rechazado'; ?></td>
<td><?php echo $r->approved; ?></td>
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
</script>

<?php } ?>
