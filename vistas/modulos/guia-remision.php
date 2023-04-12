<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Guia De Remision
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Guia De Remision</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-guia-remision">
          <button class="btn btn-primary">
            Agregar Guia De Remision
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
           <th>Trasporte</th>
           <th>Cliente</th>
           <th>Fecha Inicio</th>
           <th>Fecha Fin</th>
           <th>Direccion Salida</th>
           <th>Direccion Destino</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = null;
          $valor = null;
          $item1="id_local";
          $valor1=$_SESSION["CodAlmacen"];
          $respuesta = ControladorRemisiones::ctrMostrarRemisiones($item,$item1, $valor,$valor1);
          foreach ($respuesta as $key => $value) {
           echo '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["nombre_chofer"].'</td>
                  <td>'.$value["nombre"].'</td>
                  <td>'.$value["fecha_inicio"].'</td>
                  <td>'.$value["fecha_fin"].'</td>
                  <td>'.$value["direccion_inicio"].'</td>
                  <td>'.$value["direccion_destino"].'</td>
                  <td>
                    <div class="btn-group">';
                    if($value["procesado_sri"]==0){
                        echo '<button class="btn btn-danger btnAutorizarGuia" idGuia="'.$value["id"].'"><i class="fa fa-upload "></i></button>';
                    }
                      echo '<button class="btn btn-danger btnImprimirGuiaPDF" idGuia="'.$value["claveacceso"].'" idAlmacen="'.$value["codigo_almacen"].'">PDF</button>
                      <button class="btn btn-info btnImprimirGuiaXML" idGuia="'.$value["claveacceso"].'" idAlmacen="'.$value["codigo_almacen"].'">XML</button>
                      </div>  
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
