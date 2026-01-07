var contenido_table = $('#contenido_table').DataTable({

    columns: [

        { name: "idTipo" },
        { name: "descrTipo" },
        { name: "codTipo" },
        { name: "estTipoCurso", "className": "text-center" },
        { name: "accion", "className": "text-center" }
    ],
    columnDefs: [
        //idTipo
        { targets: [0], orderData: [0], visible: false,type: 'num', className: 'secundariaDef' },
        //descrTipo
        { targets: [1], orderData: [1], visible: true },
        //codTipo
        { targets: [2], orderData: [2], visible: true, className:"d-none" },
        //textTipo
        { targets: [3], orderData: [3], visible: true },
        //Accion
        { targets: [4], orderData: false, visible: true,className: 'secundariaDef' }
    ],

    "ajax": {

        url: "../../controller/titContenido.php?op=listarContenido",
        type: "get",
        dataType: "json",
        cache: false,
        serverSide: true,
        processData: true,
        beforeSend: function () {
            //    $('.submitBtn').attr("disabled","disabled");
            //    $('#usuario_data').css("opacity","");
        }, complete: function (data) {
        },
        error: function (e) {
            console.log(e.responseText);
        },
         orderFixed: [[1, "asc"]],
        searchBuilder: {  // Las columnas que van a aparecer en el desplegable para ser buscadas
            columns: [1, 2, 3, 4]
        }
    }
}); // del DATATABLE

/***************************************/
/*********** RESPONSIVE DATATABLE *********/
/*************************************/
$('#contenido_table').addClass('width-100'); //responsive


/**************************************************/
/************ FILTRO DE LOS  PIES  ***************/
/************************************************/
// BUSCAR POR DESCRIPCION
$('#FootDescripcion').on('keyup', function () {
    contenido_table
        .columns(1)
        .search(this.value)
        .draw();
});

// BUSCAR POR CODIGO de IDIOMA
$('#FootCodigo').on('keyup', function () {
    contenido_table
        .columns(2)
        .search(this.value)
        .draw();
});
/************************************************/
/*    FIN DE LOS FILTROS DE LOS PIES        ****/
/**********************************************/


$('#contenido_table').DataTable().on('draw.dt', function () {
    controlarFiltros('contenido_table');
    // La función está en el mainJs.php, es común para todos
    // El index debe tener el botón de ayuda y el cartel de FILTRO ACTIVADO !!!
});
$(".select2").select2();
function agregarTitContenido(){
    let titular = $("#titCont").val();
    if(titular == ""){
        toastr.error("Tienes campos sin completar");
    } else {
        
        $.post("../../controller/titContenido.php?op=insertar",{titular:titular},function (data) {
            contenido_table.ajax.reload();
        });
    }
}
function editarContenido(idTitular,nombreTit){
    $("#updateRow").removeClass("d-none");
    $("#addRow").addClass("d-none");
    $("#text-editar").val(nombreTit);
    $("#idTit").val(idTitular);
}
function cambiarEstado(titularID){
    
    $.post("../../controller/titContenido.php?op=cambiarEstado",{titularID:titularID},function (data) {
        contenido_table.ajax.reload();
    });
}
function insertarEditar(){
    let titular = $("#text-editar").val();
    let titularID = $("#idTit").val();
        
    $.post("../../controller/titContenido.php?op=editar",{titularID:titularID,titular:titular},function (data) {
        contenido_table.ajax.reload();
    });

}
function ocultarEditar(){
    $("#updateRow").addClass("d-none");
    $("#addRow").removeClass("d-none");
}