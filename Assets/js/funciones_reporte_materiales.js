let tblReportMateriales;
function mostrarAlerta(icon, title, timer = 2000,position="top") {
  Swal.fire({    
      icon: icon,
      title: title,
      position: position,
      showConfirmButton: false,
      timer: timer
  });
}
document.addEventListener("DOMContentLoaded",function(){
        tblReportMateriales=$('#tblReportMateriales').DataTable( {
        responsive: true,
        ajax: {
            url: base_url+"ReporteMateriales/listar",
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
            'data':'movimiento','width': '5%','className': 'text-end',
          },
          {
            'data':'descripcion','width': '4%','className': 'text-end',
          },
          {
            'data':'cantidad','width': '4%','className': 'text-end',
          },
          {
            'data':'persona','width': '10%','className': 'text-end',
          },
          {
            'data':'destino','width': '10%','className': 'text-end',
          },
          {
            'data':'observacion','width': '10%','className': 'text-end',
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
async function enviarRango(e){
  e.preventDefault();
  const inicio= document.getElementById('inicio').value;
  const fin=document.getElementById('fin').value;

  if(inicio=="" ||fin==""){
    mostrarAlerta("error", "Ingrese el rango de fechas");
  }else{
    const url = base_url + "ReporteMateriales/fechasReporte";
    const frm=document.getElementById("frmReporte");
    const formData = new FormData(frm);
    try {
       const response = await fetch(url, {
            method: "POST",
            body: formData
        });
        if (response.ok) {
            const res = await response.json();
            tblReportMateriales.clear();
            tblReportMateriales.rows.add(res);
            tblReportMateriales.draw();
        } else {
            mostrarAlerta("error", res);
        }
    } catch (error) {
            mostrarAlerta("error","Error de servidor");
    }
     
  }

}

async function descargarPdf (){
  const url = base_url + "ReporteMateriales/generarPdf";
  try {
    const frm=document.getElementById("frmReporte");
    const formData = new FormData(frm);
      const response = await fetch(url, {
        method: "POST",
        body: formData

      });
      if (response.ok) {
        const blob = await response.blob();
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'reporte_materiales.pdf'; // Especifica el nombre del archivo
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
    
