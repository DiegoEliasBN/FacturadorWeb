$(function () {
  'use strict';
  var colores = ["red","green","yellow","aqua","purple","blue","cyan","magenta","orange","gold"];
  var CodAlmacen = $("#CodAlmacen").val();
  console.log("CodAlmacen",CodAlmacen);
  var datos = new FormData();
  datos.append("idMovimiento", CodAlmacen);
    $.ajax({
      url:"ajax/grafico.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
          // -------------
          // - PIE CHART -
          // -------------
          // Get context with jQuery - using jQuery's .get() method.
          var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
          var pieChart       = new Chart(pieChartCanvas);
          var PieData        = []
          for( var i = 0; i < 10; i++){
            PieData.push({ "value" : respuesta[i]["ventasa"] , 
                           "color" : colores[i],
                           "highlight" : colores[i],
                           "label" : respuesta[i]["descripcion"]
                            })
          }
          var pieOptions     = {
            // Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            // String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            // Number - The width of each segment stroke
            segmentStrokeWidth   : 1,
            // Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            // Number - Amount of animation steps
            animationSteps       : 100,
            // String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            // Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            // Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            // Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : false,
            // String - A legend template
            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            // String - A tooltip template
            tooltipTemplate      : '<%=value %> <%=label%>'
          };
          // Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          pieChart.Doughnut(PieData, pieOptions);
          // -----------------
          // - END PIE CHART -
          // -----------------
    }
    })
});