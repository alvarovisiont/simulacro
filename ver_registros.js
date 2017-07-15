function actualizar_registros()
{
    
     $.ajax({
        url: 'buscar_estadisticas.php',
        type: 'GET',
        data: {action:'buscar_estadisticas'},
        dataType: 'JSON',
        cache: false,
        success: function(data)
        {
          var filas = "";
          $.grep(data, function(i,e){
            filas+="<tr><td>"+i.municipio+"</td><td>"+i.cantidad+"</td></tr>"
          })

          $("#tabla_estadistica tbody").empty().html(filas)
          $("#barra_oculta1").hide('slow/400/fast')
        }
      })
}

function ver_detalles(muni)
{
  $("#tabla_personas").DataTable().destroy()

    $("#tabla_personas").dataTable({
        language: {url: 'json/esp.json'},
        ajax: {
          url: 'buscar_estadisticas.php',
          type: 'GET',
          data: function(d)
          {
            d.action = 'buscar_detalles'
            d.municipio = muni
          },
          dataSrc: ''
        },
        columns:[
          {data: 'nac'},
          {data: 'cedula'},
          {data: 'nombre'},
          {data: 'telefono'},
          {data: 'carnet_patria'},
          {data: 'serial_carnet'},
          {data: 'trabaja_gobierno'},
          {data: 'posicion_trabajo'},
          {data: 'parroquia'}
        ]
    })
}