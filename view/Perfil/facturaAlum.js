  
  
  idTokenUsu = $('#idTokenUsu').val();
  $('#tableFacturas').DataTable({
    columns: [
      { name: "ID Factura", className: "text-center" },
      { name: "Número Factura", className: "text-center" },
      { name: "Nombre", className: "text-center" },
      { name: "Cif", className: "text-center" },
      { name: "Fecha", className: "text-center" },
      { name: "Número Proforma", className: "text-center d-none" },
      { name: "Pagado", className: "text-center d-none" },
      { name: "Marcar Pagado", className: "text-center d-none" },
      { name: "Abonar", className: "text-center d-none" },
      { name: "Pago Pendiente", className: "text-center" },
      { name: "Imprimir", className: "text-center" },
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
      url: "../../controller/proforma.php?op=listarFacturaPerfilAlum",
      type: "GET",
      dataType: "json",
      data: function (d) {
        d.idTokenUsu = idTokenUsu;  // 👈 aquí pasas el valor de tu input
      },
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
    order: [1, "desc"],  // Ordena primero Pagado ascendente (no pagados primero), luego Fecha ascendente
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