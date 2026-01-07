
  console.log("he entrado en el js de index 1");

  //////////////////////////////////////
  /// FACTURAS PROFORMAS            ///
  ////////////////////////////////////
    $('#tableProformas').DataTable({
    columns: [
      { name: "ID Factura", className: "text-center"},
      { name: "Número Factura", className: "text-center" },
      { name: "Nombre", className: "text-center" },
      { name: "Cif", className: "text-center" },
      { name: "Fecha", className: "text-center" },
      { name: "Verproforma", className: "text-center" }
    ],
    columnDefs: [
      { targets: [0], visible: false, orderable: false },
      { targets: [1], orderData: [1], visible: true },
      { targets: [2], orderData: [1], visible: true },
      { targets: [3], orderData: [3], visible: true },
      { targets: [4], orderData: [4], visible: true },
      { targets: [5], orderData: [5], visible: true }
    ],
    ajax: {
      url: "../../controller/proforma.php?op=listarProformaSinFacturaEnFacturacion",
      type: "GET",
      dataType: "json",
      cache: false,
      serverSide: true,
      processData: true,
      beforeSend: function () {},
      complete: function (data) {
        console.log("Datos cargados:", data);
      },
      error: function (e) {
        console.error("Error cargando DataTable:", e.responseText);
      }
    },
    order: [[1, "desc"]], // columna 1 → Número Factura
  });


  $("#tableProformas").addClass("width-100");

  /**************************************************/
  /************ FILTRO DE LOS PIES tableProformas ***************/
  /**************************************************/
  var tableProformas = $('#tableProformas').DataTable();

  $('#FootIDProforma').on('keyup', function () {
    tableProformas
      .columns(0)
      .search(this.value)
      .draw();
  });

  $('#FootNumeroProforma').on('keyup', function () {
    tableProformas
      .columns(1)
      .search(this.value)
      .draw();
  });

  $('#FootNombreProforma').on('keyup', function () {
    tableProformas
      .columns(2)
      .search(this.value)
      .draw();
  });

  $('#FootCIFProforma').on('keyup', function () {
    tableProformas
      .columns(3)
      .search(this.value)
      .draw();
  });

  $('#FootFechaProforma').on('keyup', function () {
    tableProformas
      .columns(4)
      .search(this.value)
      .draw();
  });
  /************************************************/
  /*    FIN DE LOS FILTROS DE LOS PIES tableProformas        ****/
  /**********************************************/


  $('#tableProformas').DataTable().on('draw.dt', function () {
    controlarFiltros('tableProformas');
  });

  //////////////////////////////////////
  /// ABONO FACTURAS PROFORMAS      ///
  ////////////////////////////////////

    // ESTE REALIZAR ABONO TIENE QUE SER ALGO DISTINTO AL DE LAS VISTAS Factura_Edu y FacturaPro_Edu,
    // AHORA NO SE DISPONE DEL ID LLEGADA EN LA URL COMO EN ESAS VISTAS, SE OBTIENE EN EL TR DEL DATATABLE,
    // POR ELLO TAMPOCO SE PUEDE OBTENER EL ID DEPARTAMENTO, NECESARIO PARA PODER REALIZAR EL ABONO,
    // POR ELLO, SE TIENE QUE PASAR EL ID LLEGADA POR EL DATATABLE DIRECTAMENTE, Y HACER OTRO AJAX PARA OBTENER
    // A TRAVÉS DE AHORA SI EL OBTENIBLE ID LLEGADA, EL ID DEPARTAMENTO
    // ADEMÁS, DEPENDIENDO DEL TIPO, DIRECTAMENTE EN UN MISMO MÉTODO SE HACE O EL ABONO PRO O EL REAL

    function realizarAbono(idPie, numFactura, idLlegada, tipo = 'Real') {

      // Primero, obtenemos los datos completos de la llegada con AJAX
      $.post("../../controller/llegadas.php?op=getDepartamentoByLlegada", { idLlegada: idLlegada}, function(datosLlegada) {
        // 'datosLlegada' ya es un objeto porque jQuery parsea JSON automáticamente

        // Aquí ya tienes todos los datos de la llegada, por ejemplo:
        // console.log(datosLlegada);

        // Supongamos que quieres el idDepartamento de la primera posición
        const idDepartamento = datosLlegada[0].iddepartamento_llegadas;

        // Ahora sí, lanzamos el SweetAlert para abonar
        setTimeout(() => {
          swal.fire({
            title: 'Abonar',
            html: `
              <p>¿Desea abonar la factura con Nº ${numFactura}?</p>
              <textarea id="motivoAbono" class="swal2-textarea" placeholder="Motivo del abono"></textarea>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Abonar',
            cancelButtonText: 'No',
            reverseButtons: true,
            focusConfirm: false,
            didOpen: () => {
              $('#motivoAbono').focus();
            }
          }).then((result) => {
            if (result.isConfirmed) {
              const motivoAbono = $('#motivoAbono').val().trim();
              if (!motivoAbono) {
                swal.fire('Error', 'Debe ingresar un motivo para el abono', 'error');
                return;
              }

              // Elegimos la URL según el tipo
              let url = "../../controller/proforma.php?op=abonarFacturaReal";
              if (tipo === 'Pro') {
                url = "../../controller/proforma.php?op=abonarFacturaPro";
              }

              // Hacemos el POST para abonar la factura
              $.post(url, {
                idPie: idPie,
                motivo: motivoAbono,
                idDepartamento: idDepartamento
              }, function(data) {
                $('#tableProformas').DataTable().ajax.reload();
                $('#tableFacturas').DataTable().ajax.reload();

                Swal.fire(
                  'Abonada',
                  'La factura ha sido abonada',
                  'success'
                ).then(() => {
                 
                });
              });
            }
          });
        }, 300); // Retraso para que el modal se cierre bien

      }, 'json'); // Forzar que jQuery interprete JSON automáticamente
    }

        function imprimirFacturaAbonoDatatable(idFactura, tipoFactura, idLlegada, realOProforma) {
          console.log("Función llamada con:", idFactura, tipoFactura, idLlegada, realOProforma);

          if (!idFactura) {
              console.warn("idFactura no encontrado en la URL");
              return;
          }

          const nuevaVentana = window.open(
              `facturaAbono.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}&idLlegada=${idLlegada}&realOProforma=${realOProforma}`,
              "_blank",
              "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
          );
      }


    