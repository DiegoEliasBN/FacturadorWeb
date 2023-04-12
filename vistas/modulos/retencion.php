<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Retencion
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Retencion</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <a href="crear-retencion">
          <button class="btn btn-primary">
            Agregar Retencion
          </button>
        </a>
        <button type="button" class="btn btn-default pull-right" id="daterangeR-btn">
              <span>
                <i class="fa fa-calendar"></i> Rango de fecha
              </span>
              <i class="fa fa-caret-down"></i>
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Acreedor</th>
           <th>Tipo de comprobante</th>
           <th>Numero de comprobante</th>
           <th>Fecha de comprobante</th>
           <th>Fecha</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item="id_almacen";
          $itemp="id";
          $itemt="ID";
          $valor=$_SESSION["CodAlmacen"];
          if(isset($_GET["fechaInicial"])){
            $fechaInicial = $_GET["fechaInicial"];
            $fechaFinal = $_GET["fechaFinal"];
          }else{
            $fechaInicial = null;
            $fechaFinal = null;
          }
          $respuesta = ControladorRetenciones::ctrRangoFechasRetenciones($fechaInicial, $fechaFinal,$item,$valor);
          foreach ($respuesta as $key => $value) {
            $proveedor = ControladorProveedores::ctrMostrarProveedores($itemp, $value["AcreedorID"]);
            $tipocomprobante=ControladorRetenciones::ctrMostrarTipoComprobanteF($itemt,$value["TipoComprobanteID"]);
           echo '<tr>
                  <td>'.($key+1).'</td>
                  <td>'.$proveedor["razon_social"].'</td>
                  <td>'.$tipocomprobante["Comprobante"].'</td>
                  <td>'.$value["numeroComprobante"].'</td>
                  <td>'.$value["fechaEmisionComprobante"].'</td>
                  <td>'.$value["fecha"].'</td>
                  <td>
                     <div class="btn-group">';
                    if($value["procesado_sri"]==0){
                        echo '<button class="btn btn-danger btnAutorizarRetencion" idRetencion="'.$value["id"].'"><i class="fa fa-upload "></i></button>';
                    }
                      echo '<button class="btn btn-success btnImprimirRetencion" idRetencion="'.$value["ID"].'" idAlmacen="'.$value["id_almacen"].'"><i class="fa fa-print "></i></button>
                      <button class="btn btn-danger btnImprimirRetencionPDF" idRetencion="'.$value["claveacceso"].'" idAlmacen="'.$value["codigo_almacen"].'">PDF</button>
                      <button class="btn btn-info btnImprimirRetencionXML" idRetencion="'.$value["claveacceso"].'" idAlmacen="'.$value["codigo_almacen"].'">XML</button>
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
