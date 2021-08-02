<head>
<link href="assets/css/body.css" rel="stylesheet" type="text/css" media="screen" />
<script src="assets/tablefilter/dist/tablefilter/tablefilter.js"></script>
</head>

<div style="padding:10px">
<br><br>
<a href="?c=Grnte&a=Crud_Usuario&i=en" style="text-decoration:none;color:black"><i class="fa fa-user-plus fa-2x"></i> Nuevo Usuario</a>
<br>
<br>

<table style="padding:2px;color:#000;border-collapse:collapse;font-size:12px;width:100%" id="demo" class="my-table">
<thead>
<tr>
<th>Nombre</th>
<th>Tipo</th>
<th>Clave</th>
<th>Correo</th>
<th>Clave Correo</th>
<th></th>
</tr>
</thead>
<tbody>


<?php foreach($this->model->Listar_Usuario() as $r): ?>

<tr style="cursor:pointer;" onclick="location.href='?c=Grnte&a=Crud_Usuario&id=<?php echo $r->ID ?>&i=en'">

<td><?php echo mb_convert_case($r->usuario, MB_CASE_TITLE, "UTF-8"); ?></td>
<td><?php switch ($r->tipo ) {
    case 1:
        echo "Administrador";
        break;
    case 2:
        echo "Costeador";
        break;
    case 3:
        echo "Asesor";
        break;
        case 4:
        echo "Diseñador";
        break;
} ?></td>
<td><?php echo $r->clave; ?></td>
<td><?php echo $r->email; ?></td>
<td><?php echo $r->pmail; ?></td>
<td style="text-align:center;width:5%;"><a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href='?c=Grnte&a=Eliminar_Usuario&id=<?php echo $r->ID ?>'><i class="fa fa-times fa-2x" style="color:red"></i></a></td>
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
alternate_rows: true,
extensions: [{
name: 'sort',
types: ['number','string','string','string','number','string','string','string' ]
}]
};
var tf = new TableFilter('demo', tfConfig);
tf.init();
</script>