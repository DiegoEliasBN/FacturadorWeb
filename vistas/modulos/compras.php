<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Compras
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar ventas</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-compra">
          <button class="btn btn-primary">
            Agregar Compra
          </button>
        </a>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Código Compra</th>
           <th>Proveedor</th>
           <th>Usuario</th>
           <th>Forma de pago</th>
           <th>Neto</th>
           <th>Total</th> 
           <th>Fecha</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = null;
          $valor = null;
          $item1="CodAlmacen";
          $valor1=$_SESSION["CodAlmacen"];
          $respuesta = ControladorCompras::ctrMostrarCompras($item,$item1, $valor,$valor1);
          foreach ($respuesta as $key => $value) {
           echo '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';
                  $itemCliente = "id";
                  $valorCliente = $value["id_proveedor"];
                  $respuestaCliente = ControladorProveedores::ctrMostrarProveedores($itemCliente, $valorCliente);
                  echo '<td>'.$respuestaCliente["razon_social"].'</td>';
                  $itemUsuario = "CodUsuario";
                  $valorUsuario = $value["id_vendedor"];
                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                  echo '<td>'.$respuestaUsuario["nombre"].'</td>
                  <td>'.$value["metodo_pago"].'</td>
                  <td>$ '.number_format($value["neto"],2).'</td>
                  <td>$ '.number_format($value["total"],2).'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-info"><i class="fa fa-print btnImprimirCompra-carta" idAlmacen="'.$value["CodAlmacen"].'" codigoCompra="'.$value["id"].'"></i></button>
                      <button class="btn btn-warning btnEditarCompra" idCompra="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnEliminarCompra" idAlmacen="'.$value["CodAlmacen"].'" idCompra="'.$value["id"].'"><i class="fa fa-times"></i></button>
                    </div>  
                  </td>
                </tr>';
            }
        ?>
        </tbody>
       </table>
       <?php
      $eliminarVenta = new ControladorCompras();
      $eliminarVenta -> ctrEliminarCompra();
      ?>
      </div>
    </div>
  </section>
</div>
