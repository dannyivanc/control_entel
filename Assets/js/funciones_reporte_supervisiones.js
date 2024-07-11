let tblRepSupervisiones;
document.addEventListener("DOMContentLoaded",function(){
        tblRepSupervisiones=$('#tblRepSupervisiones').DataTable( {
        responsive: true,
        ajax: {
            url: base_url+"ReporteSupervisiones/listar",
            dataSrc: ''
        },
        columns: [
          { 
            'data':'index','width': '1%','className': 'text-end',
          },
          {
            'data':'fecha','width': '6%','className': 'text-end',
          },
          {
            'data':'id_sucursal','width': '5%','className': 'text-end',
          },
          {
            'data':'id_vigilante','width': '5%','className': 'text-end',
          },
          {
            'data':'puntualidad','width': '4%','className': 'text-end',
          },
          {
            'data':'pres_per','width': '10%','className': 'text-end',
          },
          {
            'data':'patrulla','width': '10%','className': 'text-end',
          },
          {
            'data':'epp','width': '10%','className': 'text-end',
          },
          {
            'data': 'libro','width': '5%','className': 'text-center',
          },
          {
            'data': 'verif_vehi','width': '5%','className': 'text-center',
          },
          // {
          //   'data':'Ver ubicacion','width': '3%','className': 'text-center',
          // }
      ],
      language: {
        "decimal": "",
        "emptyTable": "No hay datos disponibles en la tabla",
        "info": "Mostrando _START_ - _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ ",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": activar para ordenar la columna de manera ascendente",
            "sortDescending": ": activar para ordenar la columna de manera descendente"
        }
    }
    });
    //  }
})



async function descargarPdf (){
  const url = base_url + "ReporteSupervisiones/generarPdf";
  try {
      const response = await fetch(url, {
          method: "GET"
      });
      if (response.ok) {
        const blob = await response.blob();
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'reporte_vigilantes.pdf'; // Especifica el nombre del archivo
        link.click();


          // const blob = await response.blob();
          // const url = window.URL.createObjectURL(blob);
          // window.open(url);
      } else {
          mostrarAlerta("error", "Error en la solicitud");
      }
  } catch (error) {
      mostrarAlerta("error", "Error de servidor");
  }
}
    
