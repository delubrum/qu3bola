<header>
<script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
</header>

<!-- Content Header (Page header) -->
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0 text-dark">Crédito</h1>
</div>
</div>
</div>
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
<h3 class="card-title"> Datos de la Solicitud</h3>
</div>
<form>
<div class="card-body">
<div class="row">

<div class="col-sm-4 mt-1">
<label>* Monto del Crédito</label>
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="nav-icon fas fa-dollar-sign"></i></span>
</div>
<input id="amount" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 0, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'"  class="form-control" name="amount" placeholder="$ 0" required>
</div>
</div>

<div class="col-sm-4 mt-1">
<label for="exampleInputEmail1">Divisa</label>
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="nav-icon fas fa-money-bill-alt"></i></span>
</div>
<select id="comision" class="form-control" name='comision' required>
<option value=""></option>
<option value="3">USD (Comisión 3%)</option>
<option value="13">CUC (Comisión 13%)</option>
</select>
</div>
</div>

<div class="col-sm-4 mt-1">
<label>Total Crédito - Comisión</label>
<div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text"><i class="nav-icon fas fa-dollar-sign"></i></span>
</div>
<input id="total" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 0, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'" class="form-control" placeholder="$ 0" disabled>
</div>
</div>


</div>

<div class="row">
	<div class="col-sm-12 mt-1">
<div class="form-group">
                        <label>Observaciones</label>
                        <textarea class="form-control" rows="3" placeholder="Observaciones ..."></textarea>
                      </div>
</div>
</div>

</div>
<div class="card-footer">
<button type="submit" class="btn btn-primary">Solicitar!</button>
</div>

</div>
</div>
</div>
</div>

<!-- ./wrapper -->
</div>
</body>
</html>

<script language="javascript">
$(document).ready(function(){
  $(":input").inputmask();
});

$(document).on('input','#comision,#amount', function() {
	if ($('#comision').val() != '') {
amount = $('#amount').val().replace(/\D/g, '');
total = (amount*($('#comision').val()/100));
$("#total").val(Number(amount)-Number(total));
}
});
</script>
