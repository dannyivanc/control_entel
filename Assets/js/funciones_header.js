function handleClick(e, data, vista) {
  e.preventDefault();
  
  const { rol, id_institucion, id_usuario } = data;

  if (rol === "cliente") {
      const url = `${base_url}ProyectoSucursal?view=${vista}`;
      const form = document.createElement('form');
      form.method = 'post';
      form.action = url;

      const input1 = document.createElement('input');
      input1.type = 'hidden';
      input1.name = 'id_institucion';
      input1.value = id_institucion;
      form.appendChild(input1);

      const input2 = document.createElement('input');
      input2.type = 'hidden';
      input2.name = 'id_usuario';
      input2.value = id_usuario;
      form.appendChild(input2);

      const input3 = document.createElement('input');
      input3.type = 'hidden';
      input3.name = 'view';
      input3.value = vista;
      form.appendChild(input3);

      document.body.appendChild(form);
      form.submit();
  } else if (rol === "admin " || rol === "supervisor") {
      const url = `${base_url}Proyectos?view=${vista}`;  
      const form = document.createElement('form');
      form.method = 'post';
      form.action = url;

      const input1 = document.createElement('input');
      input1.type = 'hidden';
      input1.name = 'id_institucion';
      input1.value = id_institucion;
      form.appendChild(input1);

      const input2 = document.createElement('input');
      input2.type = 'hidden';
      input2.name = 'id_usuario';
      input2.value = vista;
      form.appendChild(input2);

      document.body.appendChild(form);
      form.submit();
  }
}
