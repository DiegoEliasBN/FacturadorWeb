<?php 
  session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<meta name="facebook-domain-verification" content="7gi5k7beftbui4gdhedfu2z8tazc4t" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SystSolutions</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="vistas/img/plantilla/LogoSoloColor.png">
  <!--=====================================
          css
  ======================================-->
  <link rel="stylesheet" href="vistas/css/extra.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- select2-->
  <link rel="stylesheet" href="vistas/bower_components/select2/dist/css/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- autocomplete -->
  <link rel="stylesheet" href="vistas/bower_components/ui/jquery-ui.css">
  <link rel="stylesheet" href="vistas/bower_components/Autocomplete/easy-autocomplete.themes.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!--=====================================
  js
  ======================================-->
  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>
  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <!-- sweetalert -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
   <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>
   <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
   <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>
   <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
   <!-- autocomplete-->
  <script src="vistas/bower_components/ui/jquery-ui.min.js"></script>
  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>
  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/chart.js/Chart.js"></script>
  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/select2/dist/js/select2.min.js"></script>
</head>
 <!--=====================================
  Cuerpo
  ======================================-->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
<?php
                if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"]=="ok") {
                  if (isset($_SESSION["almacenes"])) {
                        echo '<div class="wrapper">';
                        include "modulos/cabezote.php";
                        include "modulos/menu.php";
                        if (isset($_GET["ruta"])) {
                          if ($_GET["ruta"]=="inicio" ||
                              $_GET["ruta"]=="usuarios" ||
                              $_GET["ruta"]=="categorias"|| 
                              $_GET["ruta"]=="productos" || 
                              $_GET["ruta"]=="clientes" ||
                              $_GET["ruta"]=="proveedor" ||
                              $_GET["ruta"]=="turnos" || 
                              $_GET["ruta"]=="compras" ||
                              $_GET["ruta"]=="cobroclientes" ||
                              $_GET["ruta"]=="cobroclientetabla" ||
                              $_GET["ruta"]=="facturasdeuda" || 
                              $_GET["ruta"]=="ventas" ||
                              $_GET["ruta"]=="usuarioturno" ||
                              $_GET["ruta"]=="mefectivo" ||
                              $_GET["ruta"]=="crear-venta"||
                              $_GET["ruta"]=="crear-liquidacion"||
                              $_GET["ruta"]=="crear-compra"||
                              $_GET["ruta"]=="aperturacaja"||
                              $_GET["ruta"] =="editar-venta"||
                              $_GET["ruta"] =="stock"||
                              $_GET["ruta"] =="almacen"||
                              $_GET["ruta"] =="Usuarioalmacen"||
                              $_GET["ruta"] =="crear-traspaso"||
                              $_GET["ruta"] =="liquidaciones"||
                              $_GET["ruta"] =="traspasos"||
                              $_GET["ruta"] =="guia-remision"||
                              $_GET["ruta"] =="retencion"||
                              $_GET["ruta"] =="crear-guia-remision"||
                              $_GET["ruta"] =="productosAlmacen"||
                              $_GET["ruta"] =="crear-retencion"||
                              $_GET["ruta"] =="cierredecajaf"||
                              $_GET["ruta"] =="cierrecaja"||
                              $_GET["ruta"]=="reportes" ||
                              $_GET["ruta"]=="salir" ||
                              $_GET["ruta"]=="transporte" ||
                              $_GET["ruta"]=="nalmacen") {
                              include "modulos/".$_GET["ruta"].".php";
                          }else{
                            include "modulos/404.php";
                          }
                        }else{
                          include "modulos/inicio.php";
                        }
                        include "modulos/footer.php";
                        echo '</div>';
                  }else{
                    include "modulos/cabezote.php";
                    include "modulos/menu.php";
                    include "modulos/nalmacen.php";
                    if ($_GET["ruta"]=="salir") {
                     include "modulos/salir.php";
                    }
                  }
                }elseif (isset($_GET["ruta"]) && $_GET["ruta"]=="consultas") {
                  include "modulos/consulta-cliente.php";
                }else if (isset($_GET["ruta"]) && $_GET["ruta"]=="facturas-cliente") {
                  include "modulos/facturasdeudaF.php";
                }
                elseif (isset($_GET["ruta"]) && $_GET["ruta"]=="f-electronica") {
                  include "modulos/consulta-factura-electronica.php";
                }
                elseif (isset($_GET["ruta"]) && $_GET["ruta"]=="f-electronicas") {
                  include "modulos/facturas-electronicas.php";
                }else{
                  include "modulos/login.php";
                }
?>
<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/categorias.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/compras.js"></script>
<script src="vistas/js/mefectivo.js"></script>
<script src="vistas/js/grafico.js"></script>
<script src="vistas/js/traspaso.js"></script>
<script src="vistas/js/remision.js"></script>
<script src="vistas/js/retencion.js"></script>
<script src="vistas/js/reportes.js"></script>
<script src="vistas/js/cobroclientes.js"></script>
<script src="vistas/js/stock.js"></script>
<script src="vistas/js/facturaelectronica-consulta.js"></script>
<script src="vistas/js/almacen.js"></script>
<script src="vistas/js/ualmacen.js"></script>
<script src="vistas/js/proveedores.js"></script>
<script src="vistas/js/turno.js"></script>
<script src="vistas/js/uturno.js"></script>
<script src="vistas/js/aperturacaja.js"></script>
<script src="vistas/js/transporte.js"></script>
<script src="vistas/js/cierrecaja.js"></script>
<script src="vistas/js/liquidacion.js"></script>
<script src="vistas/js/productosAlmacen.js"></script>
</body>
</html>
