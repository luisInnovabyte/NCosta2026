
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
      { name: "Grupo", className: "text-center" },
      { name: "Fecha", className: "text-center" },
      { name: "Abonar", className: "text-center" },
      { name: "Pago Pendiente", className: "text-center d-none" },
      { name: "Ver Factura", className: "text-center" },

    ],
    columnDefs: [
      { targets: [0], visible: false, orderable: false },
      { targets: [1], orderData: [1], visible: true },
      { targets: [2], orderData: [1], visible: true },
      { targets: [3], orderData: [3], visible: true },
      { targets: [4], orderData: [4], visible: true },
      { targets: [5], orderData: [5], visible: true },
      { targets: [6], orderData: [6], visible: true },
      { targets: [7], orderData: [7], visible: true },

    ],
    ajax: {
      url: "../../controller/proforma.php?op=listarProformaEnFacturacion",
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
    order: [[0, "ASC"]], // columna 1 → Número Factura
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

  $('#tableAbonoProforma').DataTable({
    columns: [
      { name: "ID Factura", className: "text-center", visible: false },
      { name: "Abonado Factura", className: "text-center" },
      { name: "Número Factura", className: "text-center" },
      { name: "Nombre", className: "text-center" },
      { name: "Cif", className: "text-center" },
      { name: "A Quien Factura", className: "text-center" },
      { name: "Fecha", className: "text-center" },
      { name: "Abonado Fecha Factura", className: "text-center" },
      { name: "Abonado Motivo Factura", className: "text-center" },
      { name: "Mostrar Abono", className: "text-center" },

    ],
    columnDefs: [
      { targets: [0], visible: false},
      { targets: [1], orderData: [1], visible: true },
      { targets: [2], orderData: [1], visible: true },
      { targets: [3], orderData: [3], visible: true },
      { targets: [4], orderData: [4], visible: true },
      { targets: [5], orderData: [5], visible: true },
      { targets: [6], orderData: [6], visible: true },
      { targets: [7], orderData: [7], visible: true },
      { targets: [8], orderData: [8], visible: true },
        { targets: [9], orderData: [9], visible: true }

    ],
    ajax: {
      url: "../../controller/proforma.php?op=listarProformaAbonoEnFacturacion",
      type: "GET",
      dataType: "json",
      cache: false,
      serverSide: true,
      processData: true,
      beforeSend: function () {
        // Loader opcional
      },
      complete: function (data) {
        console.log("Datos cargados:", data);
      },
      error: function (e) {
        console.error("Error cargando DataTable:", e.responseText);
      }
    },
    order: [[1, "desc"]]
  });

  // Asignar ancho al DataTable
  $("#tableAbonoProforma").addClass("width-100");

  /**************************************************/
  /************ FILTRO DE LOS PIES tableAbonoProforma ***************/
  /**************************************************/
  var tableAbonoProforma = $('#tableAbonoProforma').DataTable();

  $('#FootAbonoIDProforma').on('keyup', function () {
    tableAbonoProforma
      .columns(0)
      .search(this.value)
      .draw();
  });

  $('#FootAbonado').on('keyup', function () {
    tableAbonoProforma
      .columns(1)
      .search(this.value)
      .draw();
  });

  $('#FootAbonoNumeroProforma').on('keyup', function () {
    tableAbonoProforma
      .columns(2)
      .search(this.value)
      .draw();
  });

  $('#FootAbonoNombre').on('keyup', function () {
    tableAbonoProforma
      .columns(3)
      .search(this.value)
      .draw();
  });

  $('#FootAbonoCIF').on('keyup', function () {
    tableAbonoProforma
      .columns(4)
      .search(this.value)
      .draw();
  });

  $('#FootAbonoFecha').on('keyup', function () {
    tableAbonoProforma
      .columns(5)
      .search(this.value)
      .draw();
  });

  $('#FootAbonadoFecha').on('keyup', function () {
    tableAbonoProforma
      .columns(6)
      .search(this.value)
      .draw();
  });

  $('#FootAbonadoMotivo').on('keyup', function () {
    tableAbonoProforma
      .columns(7)
      .search(this.value)
      .draw();
  });

  /************************************************/
  /*    FIN DE LOS FILTROS DE LOS PIES tableAbonoProforma        ****/
  /**********************************************/

  $('#tableAbonoProforma').DataTable().on('draw.dt', function () {
    controlarFiltros('tableAbonoProforma');
  });
  
  //////////////////////////////////////
  /// FACTURAS                      ///
  ////////////////////////////////////
  $('#tableFacturas').DataTable({
    columns: [
      { name: "ID Factura", className: "text-center" },
      { name: "Número Factura", className: "text-center" },
      { name: "Nombre", className: "text-center" },
      { name: "Cif", className: "text-center" },
      { name: "A Quien Factura", className: "text-center" },
      { name: "Fecha", className: "text-center" },
      { name: "Número Proforma", className: "text-center" },
      { name: "Pagado", className: "text-center" },
      { name: "Marcar Pagado", className: "text-center d-none" },
      { name: "Abonar", className: "text-center" },
      { name: "Pago Pendiente", className: "text-center" },
      { name: "VerFacturas", className: "text-center" },

    ],
    columnDefs: [
      { targets: [0], visible: false, orderable: false, className: 'secundariaDef' },
      { targets: [1], orderData: [1], visible: true },
      { targets: [2], orderData: [2], visible: true },
      { targets: [3], orderData: [3], visible: true },
      { targets: [4], orderData: [4], visible: true },
      { targets: [5], orderData: [5], visible: true },
      { targets: [6], orderable: true, visible: true },
      { targets: [7], orderable: false, visible: true },
      { targets: [8], orderable: false, visible: true },
      { targets: [9], orderable: false, visible: true },
      { targets: [10], orderable: false, visible: true },

    ],
    ajax: {
      url: "../../controller/proforma.php?op=listarFacturaEnFacturacion",
      type: "GET",
      dataType: "json",
      cache: false,
      serverSide: true,
      processData: true,
      beforeSend: function () {
        // Loader opcional
      },
      complete: function (data) {
        console.log("Datos cargados:", data);
      },
      error: function (e) {
        console.error("Error cargando DataTable:", e.responseText);
      }
    },
    order: [0, "DESC"],  // Ordena primero Pagado ascendente (no pagados primero), luego Fecha ascendente
  });

  // Asignar ancho al DataTable
  $("#tableFacturas").addClass("width-100");

  /**************************************************/
  /************ FILTRO DE LOS PIES TABLA FACTURAS ***/
  /**************************************************/

  var tableFacturas = $('#tableFacturas').DataTable();

  $('#FootFactID').on('keyup', function () {
    tableFacturas
      .columns(0)
      .search(this.value)
      .draw();
  });
  $('#FootFactNumFactura').on('keyup', function () {
    tableFacturas
      .columns(1)
      .search(this.value)
      .draw();
  });
  $('#FootFactNombre').on('keyup', function () {
    tableFacturas
      .columns(2)
      .search(this.value)
      .draw();
  });
  $('#FootFactCIF').on('keyup', function () {
    tableFacturas
      .columns(3)
      .search(this.value)
      .draw();
  });
  $('#FootFactFecha').on('keyup', function () {
    tableFacturas
      .columns(4)
      .search(this.value)
      .draw();
  });
  $('#FootFactNumProforma').on('keyup', function () {
    tableFacturas
      .columns(5)
      .search(this.value)
      .draw();
  });
  $('#FootFactPagado').on('keyup', function () {
    tableFacturas
      .columns(6)
      .search(this.value)
      .draw();
  });
  $('#FootFactMarcarPagado').on('keyup', function () {
    tableFacturas
      .columns(7)
      .search(this.value)
      .draw();
  });
  $('#FootFactAbonar').on('keyup', function () {
    tableFacturas
      .columns(8)
      .search(this.value)
      .draw();
  });


  $('#tableFacturas').DataTable().on('draw.dt', function () {
    controlarFiltros('tableFacturas');
  });

       function imprimirFacturaDatatablePro(idFactura, tipoFactura, idLlegada) {
            
        console.log("Función llamada con:", idFactura, tipoFactura, idLlegada);

        if (!idFactura) {
            console.warn("idFactura no encontrado en la URL");
            return;
        }

        const nuevaVentana = window.open(
            `../FacturaPro_Edu/factura.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}&idLlegada=${idLlegada}`,
            "_blank",
            "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
        );

    }
       function imprimirFacturaDatatable(idFactura, tipoFactura, idLlegada) {
            
        console.log("Función llamada con:", idFactura, tipoFactura, idLlegada);

        if (!idFactura) {
            console.warn("idFactura no encontrado en la URL");
            return;
        }

        const nuevaVentana = window.open(
            `../Factura_Edu/factura.php?idFactura=${idFactura}&tipoFactura=${tipoFactura}&idLlegada=${idLlegada}`,
            "_blank",
            "width=1920,height=1080,top=0,left=0,scrollbars=yes,resizable=yes"
        );

    }
  //////////////////////////////////////
  /// ABONO FACTURAS                ///
  ////////////////////////////////////

  $('#tableAbonoFactura').DataTable({
    columns: [
      { name: "ID Factura", className: "text-center", visible: false },
      { name: "Abonado Factura", className: "text-center" },
      { name: "Número Factura", className: "text-center" },
      { name: "Nombre", className: "text-center" },
      { name: "Cif", className: "text-center" },
      { name: "AQuienFactura", className: "text-center" },
      { name: "Fecha", className: "text-center" },
      { name: "Número de Proforma", className: "text-center" },
      { name: "Abonado Fecha Factura", className: "text-center" },
      { name: "Abonado Motivo Factura", className: "text-center" },
      { name: "Mostrar Abono", className: "text-center" },

    ],
    columnDefs: [
      { targets: [0], visible: false},
      { targets: [1], orderData: [1], visible: true },
      { targets: [2], orderData: [1], visible: true },
      { targets: [3], orderData: [3], visible: true },
      { targets: [4], orderData: [4], visible: true },
      { targets: [5], orderData: [5], visible: true },
      { targets: [6], orderData: [6], visible: true },
      { targets: [7], orderData: [7], visible: true },
      { targets: [8], orderData: [8], visible: true },
      { targets: [9], orderData: [9], visible: true },
    
    ],
    ajax: {
      url: "../../controller/proforma.php?op=listarFacturaAbonoEnFacturacion",
      type: "GET",
      dataType: "json",
      cache: false,
      serverSide: true,
      processData: true,
      beforeSend: function () {
        // Loader opcional
      },
      complete: function (data) {
        console.log("Datos cargados:", data);
      },
      error: function (e) {
        console.error("Error cargando DataTable:", e.responseText);
      }
    },
    order: [[0, "desc"]]
  });

  // Asignar ancho al DataTable
  $("#tableAbonoFactura").addClass("width-100");

  /**************************************************/
  /************ FILTRO DE LOS PIES TABLA ABONO *******/
  /**************************************************/

  var tableAbonoFactura = $('#tableAbonoFactura').DataTable();

  $('#FootAbonoFactID').on('keyup', function () {
    tableAbonoFactura
      .columns(0)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactAbonado').on('keyup', function () {
    tableAbonoFactura
      .columns(1)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactNumFactura').on('keyup', function () {
    tableAbonoFactura
      .columns(2)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactNombre').on('keyup', function () {
    tableAbonoFactura
      .columns(3)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactCIF').on('keyup', function () {
    tableAbonoFactura
      .columns(4)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactFecha').on('keyup', function () {
    tableAbonoFactura
      .columns(5)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactNumProforma').on('keyup', function () {
    tableAbonoFactura
      .columns(6)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactAbonadoFecha').on('keyup', function () {
    tableAbonoFactura
      .columns(7)
      .search(this.value)
      .draw();
  });
  $('#FootAbonoFactAbonadoMotivo').on('keyup', function () {
    tableAbonoFactura
      .columns(8)
      .search(this.value)
      .draw();
  });

  $('#tableAbonoFactura').DataTable().on('draw.dt', function () {
    controlarFiltros('tableAbonoFactura');
  });
  

    ///////////////////////////////////////
    //   INICIO ZONA ACTIVAR FACTURA  //
    /////////////////////////////////////
    function activarFactura(idPie) {
        Swal.fire({
            title: 'Activar',
            text: `¿Desea activar la factura con ID ${idPie}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Acción cuando responde "Sí"
                $.post("../../controller/proformaAle.php?op=activarFactura", { idPie: idPie }, function (data) {
                    $('#tableProformas').DataTable().ajax.reload();
                    $('#tableFacturas').DataTable().ajax.reload();

                    Swal.fire(
                        'Activado',
                        'La factura ha sido activada correctamente.',
                        'success'
                    );
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Acción cuando responde "No"
                $.post("../../controller/proformaAle.php?op=desactivarFactura", { idPie: idPie }, function (data) { // Cambiado a prod_id

                    $('#tableProformas').DataTable().ajax.reload();
                    $('#tableFacturas').DataTable().ajax.reload();

                    swal.fire(
                        'Desactivado',
                        'La factura ha sido desactivada',
                        'success'
                    )
                });
            }
        });
    }

     // CAPTURAR EL EVENTO DE DESACTIVAR FACTURA
    function marcarPagado(idPie){
      activarFactura(idPie);
    }
    
    ////////////////////////////////////
    //   FIN ZONA ACTIVAR FACTURA    //
    //////////////////////////////////

    /*
    ESTE CÓDIGO ERA PARA ACTIVAR/DESACTIVAR EL PAGAR EN LA TABLA PROFORMA
    NO SE DEBE PODER HACER ESO EN PROFORMA, POR ESO ESTA COMENTADO
    ///////////////////////////////////////
    //   INICIO ZONA ACTIVAR FACTURA PROFORMA  //
    /////////////////////////////////////
    function activarFacturaProforma(idPie) {
        Swal.fire({
            title: 'Activar',
            text: `¿Desea activar la factura con ID ${idPie}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Acción cuando responde SÍ
                $.post("../../controller/proformaAle.php?op=activarFacturaProforma", { idPie: idPie }, function (data) {
                    $('#tableProformas').DataTable().ajax.reload();
                    $('#tableFacturas').DataTable().ajax.reload();

                    Swal.fire(
                        'Activado',
                        'La factura ha sido activada correctamente.',
                        'success'
                    );
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Acción cuando responde NO
                $.post("../../controller/proformaAle.php?op=desactivarFacturaProforma", { idPie: idPie }, function (data) { // Cambiado a prod_id

                    $('#tableProformas').DataTable().ajax.reload();
                    $('#tableFacturas').DataTable().ajax.reload();

                    swal.fire(
                        'Desactivado',
                        'La factura ha sido desactivada',
                        'success'
                    )
                });
            }
        });
    }



     // CAPTURAR EL EVENTO DE DESACTIVAR FACTURA PROFORMA
     
    function marcarPagadoProforma(idPie){
      activarFacturaProforma(idPie);
    }

    
    /////////////////////////////////////////////
    //   FIN ZONA ACTIVAR FACTURA PROFORMA    //
    ///////////////////////////////////////////
    */

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


  $(document).ready(function () {

    //////////////////////////////
  // FUNCIONES DE VISIBILIDAD //
  //////////////////////////////

  // Mostrar Facturas por defecto al cargar (cambio: antes era mostrarProforma)
  mostrarFacturas();

  // Botón para volver a mostrar proformas
  $('#botonMostrarProforma').on('click', function () {
    mostrarProforma();
  });

  // Botón para mostrar facturas
  $('#botonMostrarFacturas').on('click', function () {
    mostrarFacturas();
  });

  function mostrarFacturas() {
    // Actualizar estados de tabs
    $('#botonMostrarFacturas').addClass('active');
    $('#botonMostrarProforma').removeClass('active');
    
    // Mostrar/ocultar contenedores
    $('#contenedorProforma').addClass('d-none');
    $('#contenedorFacturas').removeClass('d-none');
  }

  function mostrarProforma() {
    // Actualizar estados de tabs
    $('#botonMostrarProforma').addClass('active');
    $('#botonMostrarFacturas').removeClass('active');
    
    // Mostrar/ocultar contenedores
    $('#contenedorProforma').removeClass('d-none');
    $('#contenedorFacturas').addClass('d-none');
  }

});

    