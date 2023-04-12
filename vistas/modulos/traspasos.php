<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Traspaso
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar traspaso</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-traspaso">
          <button class="btn btn-primary">
            Agregar Traspaso
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
           <th>Código Traspaso</th>
           <th>Usuario</th>
           <th>Almacen Salida</th>
           <th>Almacen Entrada</th>
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
          $respuesta = ControladorTraspasos::ctrMostrarTraspasos($item,$item1, $valor,$valor1);
          //var_dump( $respuesta);
          foreach ($respuesta as $key => $value) {
           echo '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';
                  $itemUsuario = "CodUsuario";
                  $valorUsuario = $value["id_usuario"];
                  $item12="CodAlmacen";
                  $valor12=$value["CodAlmacenEntrada"];
                  $almacen=ControladorAlmacenes::ctrMostrarAlmacenes($item12,$valor12);
                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
                  echo '<td>'.$respuestaUsuario["nombre"].'</td>
                  <td>'.$almacen[0]["NombreAlmacen"].'</td>
                  <td>'.$value["NombreAlmacen"].'</td>
                  <td>'.$value["fechaTraspaso"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-info btnImprimirTraspaso-carta" codigoTraspaso="'.$value["CodTraspaso"].'" idAlmacen="'.$value["CodAlmacen"].'"><i class="fa fa-print "></i></button>
                      ';
                      $item="CodUsuario";
                      $valor=$_SESSION["id"];
                      $usuario=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                      if ($usuario["perfil"]=="Administrador") {
                        echo '<button class="btn btn-danger btnEliminarTraspaso" idAlmacen="'.$value["CodAlmacen"].'" idTraspaso="'.$value["CodTraspaso"].'"><i class="fa fa-times"></i></button>';
                      }
                      echo '</div>  
                          </td>
                      </tr>';
            }
        ?>
        </tbody>
       </table>
       <?php
      $eliminarVenta = new ControladorTraspasos();
      $eliminarVenta -> ctrEliminarTraspaso();
      ?>
      </div>
    </div>
  </section>
</div>
