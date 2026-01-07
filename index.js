  function cargarPedidos() {
            $.ajax({
                url: "controller/backend.php",
                method: "GET",
                dataType: "json",
                success: function(data) {
                  console.log(data); 
                    let tbody = $("#tablaUsuarios tbody");
                    tbody.empty();

                    $.each(data, function(index, usuario) {
                        tbody.append(`
                            <tr>
                                <td>${usuario.codigo}</td>
                                <td>${usuario.nombre}</td>
                                <td>${usuario.nif}</td>
                                <td>${usuario.idPedido}</td>

                            </tr>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar usuarios:", error);
                }
            });
        }

      cargarPedidos();