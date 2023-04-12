<?php
$item = "CodAlmacen";
$valor = $_SESSION["CodAlmacen"];
$orden = "ventas";
$productos = ControladorProductos::ctrMostrarStockdinamico($item, $valor);
$colores = array("red","green","yellow","aqua","purple","blue","cyan","magenta","orange","gold");
$totalVentas = ControladorProductos::ctrSumaTotalVentasa($item,$valor);
?>
<!--=====================================
PRODUCTOS MÁS VENDIDOS
======================================-->
<div class="box box-default">
	<div class="box-header with-border">
      <h3 class="box-title">Productos más vendidos</h3>
    </div>
	<div class="box-body">
    <input type="hidden"  id="CodAlmacen" value=" <?php echo $_SESSION["CodAlmacen"]; ?> ">
    <div class="row">
	    <div class="col-md-7">
	 			<div class="chart-responsive">
	        <canvas id="pieChart" height="150"></canvas>
	      </div>
	    </div>
		  <div class="col-md-5">
		  	 	<ul class="chart-legend clearfix">
		  	 	<?php
					for($i = 0; $i < 10; $i++){
					echo ' <li><i class="fa fa-circle-o text-'.$colores[$i].'"></i> '.$productos[$i]["descripcion"].'</li>';
					}
		  	 	?>
		  	 	</ul>
		  </div>
		</div>
  </div>
  <div class="box-footer no-padding">
		<ul class="nav nav-pills nav-stacked">
			 <?php
          	for($i = 0; $i <5; $i++){
          		echo '<li>
						 <a>
						 <img src="'.$productos[$i]["imagen"].'" class="img-thumbnail" width="60px" style="margin-right:10px"> 
						 '.$productos[$i]["descripcion"].'
						 <span class="pull-right text-'.$colores[$i].'">   
						 '.ceil($productos[$i]["ventasa"]*100/$totalVentas["ventasa"]).'%
						 </span>
						 </a>
      				</li>';
			}
			?>
		</ul>
  </div>
</div>
