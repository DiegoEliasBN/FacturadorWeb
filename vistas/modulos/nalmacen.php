<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sucursales Asignadas
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped tablas dt-responsive" width="100%" >
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>RUC</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                  foreach ($_SESSION["valorAlmacen"] as $key => $value) {
                     echo '
                              <tr>
                                  <td>'.($key+1).'</td>
                                  <td>'.$value["NombreAlmacen"].'</td>
                                  <td>'.$value["DireccionAlmacen"].'</td>
                                  <td>'.$value["telefono"].'</td>
                                  <td>'.$value["email"].'</td>
                                  <td>'.$value["ruc"].'</td>
                                  <td>
                                      <div class="btn-group">
                                      <button class="btn btn-primary btnEntrar" idAlmacenn="'.$value["CodAlmacen"].'"><i class="fa  fa-hand-peace-o "></i> Entrar</button>
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
 <?php
  $borrarAlmacen = new ControladorAlmacenes();
  $borrarAlmacen -> ctrCreaVa();
?>  
 