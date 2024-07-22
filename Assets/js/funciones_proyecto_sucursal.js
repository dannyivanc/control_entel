function viewInstitucion(id,vista) { 

    if(vista=="reporteVehiculos"){
        console.log(id,vista)
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteVehiculos";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }


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