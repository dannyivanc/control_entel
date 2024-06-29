// function frmLogin (e){
//     e.preventDefault();
//     const usuario = document.getElementById("usuario");
//     const clave = document.getElementById("clave");
//     if(usuario.value==""){
//         clave.classList.remove("is-invalid");      
//         usuario.classList.add("is-invalid");
//         usuario.focus();
//     } else if(clave.value==""){
//         usuario.classList.remove("is-invalid");   
//         clave.classList.add("is-invalid");
//         clave.focus();
//     }else{
//         const url = base_url + "Usuarios/validar";  
//         const frm=document.getElementById("frmLogin");     
//         const formData = new FormData(frm);
//         fetch(url, {
//             method: "POST",
//             body: formData
//           })
//           .then(response => {
        
//             if (response.ok) {
//               return response.json();
//             } else {
//               throw new Error("Error en la solicitud");
//             }
//           })
//           .then(data => {
//             if (data === "ok") {
//               window.location = base_url + "Usuarios";
//             } else {
//               document.getElementById("alerta").classList.remove("d-none");
//               document.getElementById("alerta").innerHTML = data;
//             }
//           })
//           .catch(error => {
//             console.error("Error:", error);
//           });
//     }
// }

 function frmLogin(e) {
            e.preventDefault();
        
            const usuario = document.getElementById("usuario");
            const clave = document.getElementById("clave");
        
            if (usuario.value.trim() === "" || clave.value.trim() === "") {
                document.getElementById("alerta").classList.remove("d-none");
                document.getElementById("alerta").innerHTML = "Por favor, complete todos los campos.";
                return;
            }
        
            const url = base_url + "Usuarios/validar";
            const formData = new FormData(document.getElementById("frmLogin"));
        
            fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Error en la solicitud");
                }
            })
            .then(data => {
                if (data === "ok") {
                    window.location = base_url + "Usuarios";
                } else {
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = data;
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
