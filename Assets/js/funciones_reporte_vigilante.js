let tblUsuarios;
document.addEventListener("DOMContentLoaded",function(){
      tblUsuarios=$('#tblUsuarios').DataTable( {
        responsive: true,
        ajax: {
            url: base_url+"Usuarios/listar",
            dataSrc: ''
        },
        columns: [ 
        { 
          'data':'index','width': '2%','className': 'text-end',
        },
        {
          'data':'nombre','className': 'text-end',
        },
        {
          'data':'nombre','className': 'text-end',
        },
        {
          'data':'carnet','className': 'text-end',
        },
        {
          'data':'cel','className': 'text-end',
        },
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
  const url = base_url + "ReporteVigilantes/generarPdf";
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



  // const url = base_url + "ReporteVigilantes/generarPdf";
  // try {
  //     const response = await fetch(url, {
  //         method: "GET"
  //     });
  //     if (response.ok) {
  //         const blob = await response.blob();
  //         const url = window.URL.createObjectURL(blob);
  //         window.open(url); // Abre el PDF en una nueva pestaña
  //     } else {
  //         mostrarAlerta("error", "Error en la solicitud");
  //     }
  // } catch (error) {
  //     mostrarAlerta("error", "Error de servidor");
  // }
}
    
