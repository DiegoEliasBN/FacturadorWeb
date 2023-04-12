<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar movimiento de efectivo
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar movimiento de efectivo</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMefectivo">
          Agregar movimiento
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Descripcion</th>
           <th>Cantidad</th>
           <th>Fecha</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = null;
          $valor = null;
          $item2="CodAlmacen";
          $valor2=$_SESSION["CodAlmacen"];
          $categorias = ControladorMefectivo::ctrMostrarMefectivo($item,$item2, $valor,$valor2);
          //var_dump($valor2);
          foreach ($categorias as $key => $value) {
            echo ' <tr>
                    <td>'.($key+1).'</td>
                    <td class="text-uppercase">'.$value["descripcionMovimiento"].'</td>
                    <td class="text-uppercase">'.$value["valorMovimiento"].'</td>
                    <td class="text-uppercase">'.$value["fechaMovimiento"].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-success btnImprimirMovimiento" codigoMovimiento="'.$value["CodMovimiento"].'" idAlmacen="'.$value["CodAlmacen"].'"><i class="fa fa-print "></i></button>
                        <button class="btn btn-warning btnEditarMovimiento" idMovimiento="'.$value["CodMovimiento"].'" data-toggle="modal" data-target="#modalEditarMovimiento"><i class="fa fa-pencil"></i></button>';
                          $item="CodUsuario";
                          $valor=$_SESSION["id"];
                          $usuario=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
                          if ($usuario["perfil"]=="Administrador") {
                            echo '<button class="btn btn-danger btnEliminarMovimiento" idMovimiento="'.$value["CodMovimiento"].'"><i class="fa fa-times"></i></button>';
                          }
                      echo ' </div>  
                    </td>
                  </tr>';
          }
        ?>
        </tbody>
       </table>
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR CATEGORÍA
======================================-->
<div id="modalAgregarMefectivo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar movimiento de efectivo</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaDescripcionM" placeholder="Ingresar descripcion del movimiento" required>
              </div>
            </div>
             <?php 
                      $item="CodUsuario";
                      $valor=$_SESSION["id"];
                      $item2="CodAlmacen";
                      $valor2=$_SESSION["CodAlmacen"];
                      $caja=ControladorACaja::ctrMostrarACajaAbierta($item,$item2,$valor,$valor2); 
              ?>
             <div class="input-group row">
                          <div class="col-xs-12 col-sm-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="number" class="form-control input-lg" id="" min="" step="any" name="valorMovimiento" placeholder="Valor del movimiento" required>
                              <input type="hidden" value="<?php echo $caja; ?>" name="CodCajaM" >
                              <input type="hidden" value="<?php echo $_SESSION["CodAlmacen"]; ?>" name="CodAlmacen" >
                            </div>
                          </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Movimiento</button>
        </div>
        <?php
          $crearCategoria = new ControladorMefectivo();
          $crearCategoria -> ctrCrearMefectivo();
        ?>
      </form>
    </div>
  </div>
</div>
<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->
<div id="modalEditarMovimiento" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar categoría</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 
                <input type="text" class="form-control input-lg" name="editarDescripcionM" id="editarDescripcionM" required>
              </div>
            </div>
             <div class="input-group row">
                          <div class="col-xs-12 col-sm-12">
                            <div class="input-group">
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                              <input type="number" class="form-control input-lg" id="evalorMovimiento" min="" step="any" name="evalorMovimiento" required>
                              <input type="hidden"  name="eCodCajaM" id="eCodCajaM" >
                              <input type="hidden"  name="eCodAlmacen" id="eCodAlmacen" >
                              <input type="hidden"  name="CodMovimiento" id="CodMovimiento" >
                            </div>
                          </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      <?php
          $editarCategoria = new ControladorMefectivo();
          $editarCategoria -> ctrEditarMefectivo();
        ?> 
      </form>
    </div>
  </div>
</div>
<?php
  $borrarCategoria = new ControladorMefectivo();
  $borrarCategoria -> ctrBorrarMefectivo();
?>
