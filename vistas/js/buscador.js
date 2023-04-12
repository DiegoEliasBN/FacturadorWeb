$(document).ready(function() {
        $('#color').autocomplete({
            source: function(request, response){
                $.ajax({
                    url:"ajax/clientes.ajax.php",
                    dataType:"json",
                    data:{q:request.term},
                    success: function(data){
                        var hola ={"nombre":{"nombre":data.nombre},
                                    "id":{"nombre":data.id}};
                        response($.map(hola, function (item) {
                            return {
                                //Indicamos el Valor
                                value: item.nombre,
                                //el Label si lo desean
                                label: item.id,
                                //y el ID
                                id: item.id
                            }
                        }))
                        /*var hola ={"nombre":{"nombre":data.nombre},
                                    "id":{"nombre":data.id}};
                        console.log(hola);
                        //response(data);
                        response(hola.nombre);*/
                    }
                });
            },
            minLength: 1,
            select: function(event,ui){
                alert("Selecciono: "+ ui.item);
                console.log(ui.item);
            }
        });
    });
/*var options = {
  url: function(phrase) {
    return "ajax/clientes.ajax.php";
  },
  getValue: function(element) {
    return element.name;
  },
  ajaxSettings: {
    dataType: "json",
    method: "POST",
    data: {q:getValue()}
  },
  preparePostData: function(data) {
    data.phrase = $("#example-ajax-post").val();
    return data;
  },
  requestDelay: 400
};
$("#example-ajax-post").easyAutocomplete(options);*/