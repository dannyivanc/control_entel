function viewInstitucion(id,vista) { 
    if(vista=="reporteVehiculos"){
      var form = document.createElement('form');
      form.method = 'post';
      // form.action =  base_url+"ReporteVehiculos";
      // form.action = vista === "reporteVehiculos" ? base_url + "ReporteVehiculos" : base_url + "Errors";
      form.action =  base_url+"ReporteVehiculos";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

    window.addEventListener('popstate', function(event) {
      // Redirigir a la URL deseada
      window.location.href = '<?php echo base_url; ?>OtraRuta'; // Cambia 'OtraRuta' a la URL a la que deseas redirigir
  });

    // else if(vista=="reporteVehiculos"){
    //   var form = document.createElement('form');
    //   form.method = 'post';
    //   form.action =  base_url+"ReporteVehiculos";
    //   var input = document.createElement('input');
    //   input.type = 'hidden';
    //   input.name = 'id_institucion';
    //   input.value = id;
    //   form.appendChild(input);
    //   document.body.appendChild(form);
    //   form.submit();
    // }

  
}
