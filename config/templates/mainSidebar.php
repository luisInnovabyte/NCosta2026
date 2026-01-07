
<?php
session_start();

$rolUsuarioMenu = $_SESSION['usu_rol'];
$usuario = $_SESSION['usu_nom']; // Nombre de usuario
$apellido = $_SESSION['usu_ape']; // Nombre de usuario
$idUsuario = $_SESSION['usu_id']; // ID de usuario
$avatar = $_SESSION['usu_avatar']; // ID de usuario
$tokenUsu = $_SESSION['usu_token'];

/* $avatarUsuario = $_SESSION['usu_avatar'];  */ //

// SELECCION DE TEXTOS POR ROL //

/* 

https://fonts.google.com/icons

  $avatarUsuario = [
  '999' => 'superadmin.png',
  '2' => 'usuario.png',
  '1' => 'administrador.png',
];

$avatarRol = $avatarUsuario[$rolUsuarioMenu] ?? ''; */

// SELECCION DE AVATAR POR ROL //
/* $rolAvatar = [
    '0' => 'profesorAvatar.png', //'Profesor',
    '1' => 'adminAvatar.png', //'Administrador',
    '2' => 'jefeEstudiosAvatar.png', //'Jefe de Estudios',
    '3' => 'alumnoAvatar.png',  //'Alumno'
]; */

/* $rolAvatar = $_SESSION['usu_avatar']; */
?>
<aside class="sidebar-wrapper">
  <div class="sidebar-header">
    <div class="logo-icon">
      <img src="../../public/assets/images/<?php echo  $configJsonSetting['General']['logotipo']; ?>" class="logo-img" alt="">
    </div>
    <div class="logo-name flex-grow-1">
      <h5 class="mb-0"></h5>
    </div>
    <div class="sidebar-close ">
      <span class="material-symbols-outlined">close</span>
    </div>
  </div>
  <div class="sidebar-nav" data-simplebar="true">

    <!--navigation-->
    <ul class="metismenu" id="menu">
      <li>
        <a href="../../view/Home">
          <div class="parent-icon"><span class="material-symbols-outlined">home</span>
          </div>
          <div class="menu-title">Inicio</div>
        </a>
      </li>


      <?php if (isset($_SESSION['superadmin'])) { ?>

        <li class="menu-label">Ŝ̸̇U̷͘͝PȆ̶̈R̸̾̇A̵͋̀D̵̿͠M̴̂̏IN̴̽̏👹</li>
        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">hotel_class</span>

            </div>
            <div class="menu-title">Ǥ€ŞŦƗóŇ ΔĐΜƗŇ </div>
          </a>
          <ul>
            <li> <a href="../../view/SUPER"><span class="material-symbols-outlined">arrow_right</span>Módulos</a>
            </li>
            <li> <a href="../../view/Logs/"><span class="material-symbols-outlined">arrow_right</span>Logs</a>
            </li>
          </ul>
        </li>
      <?php } ?>



      <?php if ($_SESSION['usu_rol'] == 0) { ?>
        <li class="menu-label">GESTIÓN</li>

        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">settings</span>
            </div>
            <div class="menu-title">Mantenimientos</div>
          </a>
          <ul>

            <li> <a href="../../view/MntUsuarios/"><span class="material-symbols-outlined">arrow_right</span>Usuarios</a>


            </li>

            <li> <a href="../../view/Empresa/"><span class="material-symbols-outlined">arrow_right</span>Empresa</a>

            </li>
            <li> <a href="../../view/SMTP/"><span class="material-symbols-outlined">arrow_right</span>Config Correo</a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($educacion_m == 1) { ?>

        <?php if ($_SESSION['usu_rol'] == 1) { ?>

          <li class="menu-label">Escuela de Idiomas</li>
          <li>
            <a href="../../view/Interesados_Edu/">
              <div class="parent-icon"><span class="material-symbols-outlined">person_pin</span>
              </div>
              <div class="menu-title">Interesados </div>
            </a>
          </li>
          <!-- <li>
            <a href="../../view/ListadoProforma/">
              <div class="parent-icon"><span class="material-symbols-outlined">list_alt</span>
              </div>
              <div class="menu-title">Facturación </div>
            </a>
          </li> -->
          <!-- <li>
            <a href="../../view/TestDeNivel_Edu/">
              <div class="parent-icon"><span class="material-symbols-outlined">quiz</span>
              </div>
              <div class="menu-title">Test de Nivel  </div>
            </a>
          </li> -->



          <li>

            <?php if ($_SESSION['usu_rol'] == 1) { ?>

        <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><span class="material-symbols-outlined">school</span>
              </div>
              <div class="menu-title">Docencia </div>
            </a>
            <ul>
              <li> <a href="../../view/Grupos/"><span class="material-symbols-outlined">menu_book</span>Grupos </a></li>
              <!-- <li> <a href="../../view/Cursos/"><span class="material-symbols-outlined">menu_book</span>Cursos </a>

              </li>
               -->
              <li> <a href="../../view/Rutas/"><span class="material-symbols-outlined">conversion_path</span>Rutas </a>

              </li>
              <li> <a href="../../view/Calendar/"><span class="material-symbols-outlined">edit_calendar</span>Calendario </a>

              </li>
              <li> <a href="../../view/EvaluacionFinal/"><span class="material-symbols-outlined">workspace_premium</span>Evaluación Final </a>

              </li>
              
              <!-- <li> <a href="../../view/MntTarifa_Edu/"><span class="material-symbols-outlined">arrow_right</span>Listado de Docencia </a>
              </li>
              </li>
              <li> <a href="../../view/MntTipoContrato_Edu/"><span class="material-symbols-outlined">arrow_right</span>Titulares Contenidos</a>
              </li>
              <li> <a href="../../view/MntTipoCurso_Edu/"><span class="material-symbols-outlined">arrow_right</span>Contenidos</a>
              </li>
              <li> <a href="../../view/MntPagos_Edu/"><span class="material-symbols-outlined">arrow_right</span>Titulares Objetivos</a>
              </li>
              <li> <a href="../../view/MntSeries_Edu/"><span class="material-symbols-outlined">arrow_right</span>Objetivos</a>
              </li> -->

            </ul>
          </li> 

          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><span class="material-symbols-outlined">house</span>
              </div>
              <div class="menu-title">Alojamientos </div>
            </a>
            <ul>
              <li> <a href="../../view/Alojamientos/"><span class="material-symbols-outlined">menu_book</span>Gestionar Alojamientos </a></li>
              <!-- <li> <a href="../../view/Cursos/"><span class="material-symbols-outlined">menu_book</span>Cursos </a>

              </li>
               -->
              <li> <a href="../../view/MntTipoAloja/"><span class="material-symbols-outlined">conversion_path</span>Tipos de Alojamientos </a>

              </li>
        
            </ul>
          </li> 

              <!-- <li>
            <a href="#">
              <div class="parent-icon"><span class="material-symbols-outlined">luggage</span>
              </div>
              <div class="menu-title">Alojamientos </div>
            </a>
          </li> -->
          
          <li>
            <a href="../../view/GestionActividades/">
              <div class="parent-icon"><span class="material-symbols-outlined">hiking</span>
              </div>
              <div class="menu-title">Gestionar Actividades </div>
            </a>
          </li>
          <li>
            <a href="../../view/MntAlumnos/">
              <div class="parent-icon"><span class="material-symbols-outlined">diversity_3</span>
              </div>
              <div class="menu-title">Alumnos </div>
            </a>
          </li>
          <li>
            <a href="../../view/MntPersonal_Edu/">
              <div class="parent-icon"><span class="material-symbols-outlined">work</span>
              </div>
              <div class="menu-title">Personal </div>
            </a>
          </li> 
          <!--
          <li>
            <a href="../../view/MntFacturacion/">
              <div class="parent-icon"><span class="material-symbols-outlined">list_alt</span>
              </div>
              <div class="menu-title">Facturación </div>
            </a>
          </li>
          -->
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon">
                <span class="material-symbols-outlined">list_alt</span>
              </div>
              <div class="menu-title">Facturación</div>
            </a>
            <ul>
              <li>
                <a href="../../view/MntFacturacion/">
                  <span class="material-symbols-outlined">receipt_long</span>
                  Gestión general
                </a>
              </li>
              <li>
                <a href="../../view/MntFacturacion/sinFactura.php">
                  <span class="material-symbols-outlined">request_quote</span>
                  Gestión Proforma sin Factura
                </a>
              </li>
              <!-- Agrega más ítems aquí según necesites -->
            </ul>
          </li>


          <li>
            <a href="../../view/MntAsistencia/">
              <div class="parent-icon"><span class="material-symbols-outlined">pending_actions</span>
              </div>
              <div class="menu-title">Asistencias </div>
            </a>
          </li>

        <?php } ?>


        </li>
        <li>
          <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><span class="material-symbols-outlined">settings</span>
            </div>
            <div class="menu-title">Mantenimientos</div>
          </a>
          <ul>

            <li> <a href="../../view/MntPreinscriptores_Edu/"><span class="material-symbols-outlined">arrow_right</span>Varios - Interesados </a></li>
            <li> <a href="../../view/MntTarifa_Edu/"><span class="material-symbols-outlined">arrow_right</span>Tarifas </a></li>
              <hr>
           
            <li> <a href="../../view/MntAulas/"><span class="material-symbols-outlined">arrow_right</span>Aulas </a></li>
            <hr>
            <li> <a href="../../view/MntIdiomas_Edu/"><span class="material-symbols-outlined">arrow_right</span>Idiomas </a></li>
            <li> <a href="../../view/MntTipoCurso_Edu/"><span class="material-symbols-outlined">arrow_right</span>Tipos de Cursos  </a></li>
            <li> <a href="../../view/MntNiveles_Edu/"><span class="material-symbols-outlined">arrow_right</span>Niveles </a></li> 
            <li> <a href="../../view/MntPagos_Edu/"><span class="material-symbols-outlined">arrow_right</span>Medios de Pago </a></li> 

            <!-- <hr>
            <li> <a href="../../view/MntTipoContrato_Edu/"><span class="material-symbols-outlined">arrow_right</span>Tipos de Contrato</a></li>
           
            <li> <a href="../../view/MntPagos_Edu/"><span class="material-symbols-outlined">arrow_right</span>Medios de Pago</a></li>
           
            <li> <a href="../../view/MntGrupos_Edu/"><span class="material-symbols-outlined">arrow_right</span>Grupos</a></li> -->


             <!-- <li> <a href="../../view/MntSeries_Edu/"><span class="material-symbols-outlined">arrow_right</span>Series</a>
              </li> -->
            <!-- <li> <a href="../../view/MntTipoAloja_Edu/"><span class="material-symbols-outlined">arrow_right</span>Tipos de Alojamiento</a>
              </li> -->
            <!-- <li> <a href="../../view/MntMedidaAloja_Edu/"><span class="material-symbols-outlined">arrow_right</span>Medidas Aloja</a>
            </li> -->
            <!-- <li> <a href="../../view/MntNiveles_Edu/"><span class="material-symbols-outlined">arrow_right</span>Niveles</a>
              </li> -->
            <!-- <li> <a href="../../view/MntTitCont_Edu/"><span class="material-symbols-outlined">arrow_right</span>Titulares Contenido</a>
              </li> -->
            <!-- <li> <a href="../../view/MntTitObj_Edu/"><span class="material-symbols-outlined">arrow_right</span>Titulares Objetivos</a>
              </li> -->
            <!-- <li> <a href="../../view/MntContenido_Edu/"><span class="material-symbols-outlined">arrow_right</span>Contenidos</a>
              </li> -->
            <!-- <li> <a href="../../view/MntObjetivos_Edu/"><span class="material-symbols-outlined">arrow_right</span>Objetivos</a>
              </li> -->



          </ul>
        </li>
      <?php } ?>
      <?php
        if ($_SESSION['usu_rol'] == 3) {
          if (!empty($_SESSION['llegada_nombreDepartamento'])) {
      ?>
          <li>
            <a href="../../view/MisCursos/">
              <div class="parent-icon"><span class="material-symbols-outlined">school</span>
              </div>
              <div class="menu-title">Mis Cursos </div>
            </a>
          </li>
          <li>
            <a href="../../view/AlojaAlumn/">
              <div class="parent-icon">
                <span class="material-symbols-outlined">house</span>
              </div>
              <div class="menu-title">Alojamiento </div>
            </a>
          </li>
          <li>
            <a href="../../view/Actividades_Edu/">
              <div class="parent-icon">
                <span class="material-symbols-outlined">hiking</span>
              </div>
              <div class="menu-title">Actividades </div>
            </a>
          </li>
        <?php
          } else { ?>
          <a href="../../view/Home/">
            <div class="parent-icon">
              <span class="material-symbols-outlined">Close</span>
            </div>
            <div class="menu-title">Selecciona un Departamento </div>
          </a>
      <?php }
        }
      ?>
      <?php
        if ($_SESSION['usu_rol'] == 2) {
          if (!empty($_SESSION['llegada_nombreDepartamento'])) {
      ?>
          <li>
            <a href="../../view/MisCursosProfesor/">
              <div class="parent-icon"><span class="material-symbols-outlined">school</span>
              </div>
              <div class="menu-title">Docencia </div>
            </a>
          </li>
          <li>
            <a href="../../view/GestionActividades/">
              <div class="parent-icon">
                <span class="material-symbols-outlined">hiking</span>
              </div>
              <div class="menu-title">Actividades </div>
            </a>
          </li>
        <?php
          } else { ?>
          <a href="../../view/Home/">
            <div class="parent-icon">
              <span class="material-symbols-outlined">Close</span>
            </div>
            <div class="menu-title">Selecciona un Departamento </div>
          </a>
      <?php }
        }
      ?>

    <?php } ?>
    <!-- 
      <li class="menu-label">Hotel canino</li>

      <li>
        <a href="javascript:;" class="has-arrow">
          <div class="parent-icon"><span class="material-symbols-outlined">settings</span>
          </div>
          <div class="menu-title">Prueba</div>
        </a>
        <ul>

          <li> <a href="../../view/Calendario/"><span class="material-symbols-outlined">arrow_right</span>Calendario</a>
          </li>





        </ul> -->
    <!--end navigation-->


  </div>
  <div class="sidebar-bottom dropdown dropup-center dropup">
    <div class="dropdown-toggle d-flex align-items-center px-3 gap-1 w-100 h-100" data-bs-toggle="dropdown">
      <div class="user-img">
        <img src="../../public/assets/images/users/<?php echo $avatar ?>" alt="">
      </div>
      <div class="user-info">
        <h5 class="mb-0 user-name"><?php echo $usuario ?></h5>
        <p class="mb-0 user-designation"><?php echo $rolTexto ?></p>
      </div>
    </div>
    <ul class="dropdown-menu dropdown-menu-end">
      <?php if ($rolUsuarioMenu == 3) { ?>

        <li><a class="dropdown-item" href="../../view/Perfil/?tokenUsuario=<?php echo $tokenUsu; ?>"><span class="material-symbols-outlined me-2">
              account_circle
            </span><span>Perfil</span></a>
        </li>
      <?php } ?>


      <?php if ($rolUsuarioMenu == 1 || $rolUsuarioMenu == 2) { ?>


        <li>
          <a class="dropdown-item" id="asistenciaLink" data-bs-toggle="modal" data-bs-target="#modalOtros"><span class="material-symbols-outlined me-2">
              pending_actions
            </span><span>Inicio Asistencia</span></a>
        </li>
        <li>
          <a class="dropdown-item d-none" id="finalizarLink" data-bs-toggle="modal" data-bs-target="#modalFinalizar" onclick="guardarYMostrarHoraFinalizar()">
            <span class="material-symbols-outlined me-2">tune</span>
            <span>Finalizar Asistencia</span>
          </a>
        </li>
      <?php } ?>

      <li>
        <div class="dropdown-divider mb-0"></div>
      </li>
      <li><a class="dropdown-item" href="../../controller/logout.php"><span class="material-symbols-outlined me-2">
            logout
          </span><span>Cerrar sesión</span></a>
      </li>
    </ul>
  </div>


</aside>


<!-- Modal -->
<div id="modalOtros" class="modal fade" tabindex="-1" aria-labelledby="modalOtrosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalOtrosLabel">Asistencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label>¡Bienvenido!
          <?php
          session_start();
          $usu = $_SESSION["usu_nom"];
          echo $usu;
          ?>
        </label>
        <div class="mb-3">
          <label for="descripcionOtros">Inserte una descripción si fuese necesario.</label>
          <textarea rows="3" class="form-control" id="descripcionOtros" placeholder="Descripción de la asistencia..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id="asistencia" name="asistencia" type="button" onclick="guardarYMostrarHora()" class="btn btn-success">Guardar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div id="modalFinalizar" class="modal fade" tabindex="-1" aria-labelledby="modalFinalizarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modalFinalizarLabel">Finalizar Asistencia</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label>¡Adiós!
          <?php
          session_start();
          $usu = $_SESSION["usu_nom"];
          echo $usu;
          ?>
        </label>
        <div class="row">
          <div class="col-12">
            <label id="horactualFinalizar" class="tx-danger tx-bold">Salida registrada a las </label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="adios" name="adios" class="btn btn-warning btn-block" data-bs-dismiss="modal">Adiós</button>
      </div>
    </div>
  </div>
</div>