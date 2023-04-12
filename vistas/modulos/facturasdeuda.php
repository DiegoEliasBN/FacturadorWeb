<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar ventas
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar ventas</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="cobroclientes">
          <button class="btn btn-primary">
            Regresar
          </button>
        </a>
         <!-- <button type="button" class="btn btn-default pull-right" id="daterange-btn">
              <span>
                <i class="fa fa-calendar"></i> Rango de fecha
              </span>
              <i class="fa fa-caret-down"></i>
          </button>-->
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Código factura</th>
           <th>Cliente</th>
           <th>Vendedor</th>
           <th>Forma de pago</th>
           <th>Total</th>
           <th>Deuda</th>
           <th>Fecha</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = "saldo";
          $item1="id_cliente";
          $valor1=$_GET["idCliente"];
          $respuesta = ControladorVentas::ctrMostrarVentasFiadas($item,$item1,$valor1);
          foreach ($respuesta as $key => $value) {
           echo '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';
                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];
                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);
                  echo '<td>'.$respuestaCliente["nombre"].'</td>';
                  $itemUsuario = "CodUsuario";
                  $valorUsuario = $value["id_vendedor"];
                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                  echo '<td>'.$respuestaUsuario["nombre"].'</td>
                  <td>'.$value["metodo_pago"].'</td>
                  <td>$ '.number_format($value["total"],2).'</td>
                  <td>$ '.number_format($value["saldo"],2).'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btnImprimirFactura" codigoVenta="'.$value["id"].'" idAlmacen="'.$value["CodAlmacen"].'"><i class="fa fa-print "></i></button>
                      <button class="btn btn-info btnImprimirFactura-carta" codigoVenta="'.$value["id"].'" idAlmacen="'.$value["CodAlmacen"].'"><i class="fa fa-print "></i></button>
                    </div>  
                  </td>
                </tr>';
            }
        ?>
        </tbody>
       </table>
       <?php
      $eliminarVenta = new ControladorVentas();
      $eliminarVenta -> ctrEliminarVenta();
      ?>
      </div>
    </div>
  </section>
</div>
