<?php
require_once '../../vendor/autoload.php';
ini_set('display_errors', 1);
use DB\Eloquent;
use Strana\Paginator;
use Models\Categoria;
use Models\Producto;
use Models\Rubro;
new Eloquent();
session_start();
extract($_GET);
extract($_POST);
$productos = Producto::where('eliminar',0)->get();
?>
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/css/beyond.min.css">
<link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../../assets/bower/trumbowyg/dist/ui/trumbowyg.min.css">
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/beyond.js"></script>
<br>
<div class="widget-header bordered-left bordered-darkorange">
	<span class="widget-caption"><a class="btn btn-danger shiny fa fa-home" href="../"></a><strong> PRODUCTO</strong></span>
	<button class="btn btn-danger shiny" data-toggle="modal" data-target="#agregarRubro"><i class="fa fa-plus"></i> AGREGAR PRODUCTO</button>
</div>
<div class="widget-body bordered-left">
	<table class="table  table-hover table-bordered" id="simpledatatable" style="font-size: 1em;color: #555;">
		<thead>
			<tr role="row">
				<th width='20%'><i class="fa fa-file"></i> TIPO</th>
				<th width='20%'><i class="fa fa-address-card" aria-hidden="true"></i>
				CANTIDAD</th>
				<th width='5%'><i class="fa fa-gear"></i> Opciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$strana = new Paginator();
			$records = array_reduce((array) $productos, 'array_merge', array());
			$paginator = $strana->perPage(4)->make($records);
			?>
			<?php foreach ($paginator as $key => $p): ?>
			<tr>
				<td width='20%' >
					<?php echo $p->producto ?>
				</td>
				<td width='10%' >
					<?php echo $p->cantidad ?>
				</td>
				<td>
					<div class="col-md-12">
						<div class="col-md-6">
							<!-- Trigger the modal with a button -->
							<button type="button" class="btn btn-info fa fa-pencil" data-toggle="modal" data-target="#editarProducto<?php echo $p->id ?>"></button>
							<!-- Modal -->
							<div id="editarProducto<?php echo $p->id ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">ACTUALIZAR PRODUCTO</h4>
										</div>
										<div class="modal-body">
											<form action="update.php" method="POST">
												<div class="form-group">
													<input type="text" class="form-control" placeholder="Tipo de Producto" name='tipo' required="required" value="<?php echo $p->producto ?>" required autofocus onChange="javascript:this.value=this.value.toUpperCase();" style="width:280px;height:34px">
												</div>
												
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-danger shiny"><i class="fa fa-save"></i> ACTUALIZAR</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<form action="delete.php" method="POST">
								<input type="hidden" name="id" value="<?php echo $p->id ?>">
								<button class="btn btn-danger fa fa-times" type="submit"></button>
							</form>
						</div>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
<!-- Select Categoria -->
<script language="javascript">
$(document).ready(function(){
$("#categoria").change(function () {
$("#categoria option:selected").each(function () {
idcategoria = $(this).val();
$.post("../../select/rubros.php", { idcategoria:idcategoria }, function(data){
$("#rubros").html(data);
});
window.console&&console.log(idcategoria);
});
})
});
</script>
<!-- Modal -->
<div id="agregarRubro" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title"><b>AGREGAR PRODUCTO</b></h4>
</div>
<form action="store.php" method="POST">
	<div class="modal-body">
		<div class="form-group">
			<?php $categorias = Categoria::all(); ?>
			<select name="categoria" id="categoria" style="width:280px;height:34px">
				<option value="">CATEGORIA</option>
			<optgroup label='-------'></optgroup>
			<?php foreach ($categorias as $cat): ?>
			<option value="<?php echo $cat->id ?>"><?php echo $cat->categoria ?></option>
			<?php endforeach ?>
		</select>
		<select
			name="rubro" id="rubros" style="width:280px;height:34px">
			<option value="">RUBRO</option>
		</select>
	</div>
	<div class="form-group">
		<select style="width:280px;height:34px">
			<option value="">TIPO</option>
			<option value="1">Regulado</option>
			<option value="2">No Regulado</option>
		</select>
	</div>

	<div class="form-group">
		<select style="width:280px;height:34px">
			<option value="">PRESENTACION +</option>
			<option value="1">1*12</option>
			<option value="2"></option>
		</select>
	</div>

	<div class="form-group">
		<select style="width:280px;height:34px">
			<option value="">PRESENTACION -</option>
			<option value="1">1</option>
			<option value="2">No Regulado</option>
		</select>
	</div>
	<div>
		<input type="text" class="form-control" name='nombre' required="required" required autofocus onChange="javascript:this.value=this.value.toUpperCase();" style="width:280px;height:34px">
	</div>
	
</div>
<div class="modal-footer">
	<button type="submit" class="btn btn-danger shiny"><i class="fa fa-save"></i> GUARDAR</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
</form>
</div>
</div>
</div>
<script src="../../assets/bower/trumbowyg/dist/trumbowyg.min.js"></script>
<script>
/** Default editor configuration **/
$('.editor').trumbowyg();
</script>