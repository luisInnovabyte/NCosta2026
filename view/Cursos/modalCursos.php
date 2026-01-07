  <!-- ============================================================== -->
  <!-- MODAL AYUDA DEL DATATABLES  -->
  <!-- ============================================================== -->

  <div id="selectCurso1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Cursos</h4>
                <button type="button" class="close" data-dismiss="modal"  data-toggle="modal" data-target="#selectCurso1" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                
                <div  class="table-responsive ">
                            <?php
                                    $nombreTabla = "cursos_table";
                                    $nombreCampos = ["Id", "Idioma", "Tipo de Curso",  "Nivel", "Capacidad" , "Semana", "Fecha Curso", "Idtf.","Alumnos", "Codígo"];
                                    $nombreCamposFooter = [
                                        "Id", "Idioma", "Tipo de Curso",  "Nivel", "Capacidad" , "Semana", "Fecha Curso", "Idtf.","Alumnos", "Codígo" 
                                    ];

                                    $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter);

                                    echo $tablaHTML;
                            ?>
                    </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal" data-toggle="modal" data-target="#insertar-tipocurso-modal">Cerrar</button>
            </div>
        </div>
                            <!-- /.modal-content -->
    </div>
                        <!-- /.modal-dialog -->
  </div>