<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Cobro a Clientes
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Administrar Cobro a Clientes</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
         <a href="cobroclientes">
          <button class="btn btn-primary">
            Agregar Cobro
          </button>
        </a>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Monto Pago</th>
                <th>Fecha</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  $item=null;
                  $valor=null;
                  $item1="CodAlmacen";
                  $valor1=$_SESSION["CodAlmacen"];
                  $usuarios=ControladorCobros::ctrMostrarCobros($item,$item1, $valor,$valor1);
                  foreach ($usuarios as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["nombre"].'</td>';
                                  $itemCliente = "id";
                                  $valorCliente = $value["id_cliente"];
                                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                                 echo '<td>'.$respuestaCliente["nombre"].'</td>
                                  <td>$ '.number_format($value["CantidadPago"],2).'</td>
                                  <td>'.$value["fechaCobro"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class=" btnEditarAlmacen btn btn-warning" idAlmacen="'.$value["CodAlmacen"].'"   ><i class="fa fa-pencil"></i></button>
                                      <button class="btn btn-danger btnEliminarCobro" idCobro="'.$value["CodCobro"].'" idAlmacen="'.$value["CodAlmacen"].'"><i class="fa fa-times "></i></button>
                                      </div>
                                  </td>
                              </tr>
                    ';
                  }
               ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
</div>
