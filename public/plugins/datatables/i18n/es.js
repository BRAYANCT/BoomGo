(function(dt){

dt.es = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de 0 ",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "<span class='d-none d-sm-inline-block'>Buscar en tabla:</span><span class='d-inline-block d-sm-none'>Buscar:</span>",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "&raquo;",
        "sPrevious": "&laquo;"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

  // ut.max = function(array){
  //   var a = array.sort();
  //   return a[a.length-1];
  // };
  // ut.min = function(array){
  //   var a = array.sort();
  //   return a[0];
  // };
  // ut.unique = function(array){
  //   return array.filter(function(v, i, a) { 
  //                 return a.lastIndexOf(v) === i; })
  //               .sort();
  // }
  return dt;
})(typeof exports === "undefined" ? datatable_es = {} : exports);

