<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar Proveedor
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar Proveedores</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor">
          Agregar Proveedor
        </button>
      </div>
      <div class="box-body">
       <table class="table table-bordered table-striped tablas dt-responsive" width="100%">
        <thead>
         <tr>
           <th style="width:10px">#</th>
           <th>Razon Social</th>
             <th>RUC</th>
           <th>Teléfono</th>
           <th>Email</th>
             <th>Dirección</th>
           <th>Acciones</th>
         </tr> 
        </thead>
        <tbody>
        <?php
          $item = null;
          $valor = null;
          $item1 = "CodAlmacen";
          $valor1 =$_SESSION["CodAlmacen"];
          $proveedores = ControladorProveedores::ctrMostrarProveedoresAlmacen($item, $item1, $valor, $valor1);
          foreach ($proveedores as $key => $value) {
            echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["razon_social"].'</td>
                   <td>'.$value["identificacion_proveedor"].'</td>
                    <td>'.$value["telefono"].'</td>
                    <td>'.$value["email"].'</td>
                    <td>'.$value["direccion_proveedor"].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarProveedor" data-toggle="modal" data-target="#modalEditarProveedor" idProveedor="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarProveedor" idProveedor="'.$value["id"].'"><i class="fa fa-times"></i></button>
                      </div>  
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
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Proveedor</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoProveedor" placeholder="Ingresar Razon Social" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
              <div class="form-group">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-address-card-o"></i></span>
                      <input type="number" min="0" class="form-control input-lg" name="nuevoRUC" placeholder="Ingresar RUC" required>
                  </div>
              </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" >
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask >
                <input type="hidden" name="nuevoAlmacen" value=" <?php echo $_SESSION["CodAlmacen"];  ?>">
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
              <div class="form-group">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                      <input type="text" class="form-control input-lg" name="nuevaDireccionP" placeholder="Ingresar dirección" >
                  </div>
              </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
        </div>
      </form>
      <?php
        $crearCliente = new ControladorProveedores();
        $crearCliente -> ctrCrearProveedor();
      ?>
    </div>
  </div>
</div>
<!--=====================================
MODAL EDITAR CLIENTE
======================================-->
<div id="modalEditarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar cliente</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                <input type="text" class="form-control input-lg" name="editarProveedor" id="editarProveedor" required>
                <input type="hidden" id="idProveedor" name="idProveedor">
              </div>
            </div>
            <!-- ENTRADA PARA EL DOCUMENTO ID -->
              <div class="form-group">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-key"></i></span>
                      <input type="number" min="0" class="form-control input-lg" name="editarRUC" id="editarRUC" required>
                  </div>
              </div>
            <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="text" class="form-control input-lg" name="editarEmail" id="editarEmail" >
              </div>
            </div>
            <!-- ENTRADA PARA EL TELÉFONO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 
                <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(999) 999-9999'" data-mask >
              </div>
            </div>
            <!-- ENTRADA PARA LA DIRECCIÓN -->
              <div class="form-group">
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                      <input type="text" class="form-control input-lg" name="editarDireccionP" id="editarDireccionP"  >
                  </div>
              </div>
             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
      <?php
        $editarProveedor = new ControladorProveedores();
        $editarProveedor -> ctrEditarProveedor();
      ?>
    </div>
  </div>
</div>
<?php
  $eliminarProveedor = new ControladorProveedores();
  $eliminarProveedor -> ctrEliminarProveedor();
?>
