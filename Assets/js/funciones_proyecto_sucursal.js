function mostrarLista(id,vista) {
    if(vista=="ReporteVehiculos"){
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

    else if(vista=="ReporteMateriales"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteMateriales";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

    else if(vista=="ReporteVisitas"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteVisitas";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

    else if(vista=="RegistroVehiculo"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Vehiculos";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="RegistroMaterial"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Materiales";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="RegistroVisita"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Visitas";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
}
