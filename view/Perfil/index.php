<!doctype html>
<html lang="es" data-bs-theme="light">

<head>    

  <?php include("../../config/templates/mainHead.php") ?>
  <?php include("../Home/asignacionColorPrincipal.php"); ?>


  <?php checkAccess(['0','1','2','3']);
  
    $tokenIdUrl = $_GET['tokenUsuario'];

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    
    require_once("../../models/Usuario.php");

    $usuObjeto = new Usuario();


    $datosUsuario = $usuObjeto->getUsuario_x_idTokenView($tokenIdUrl);

    // Verificar si los datos están vacíos
    if (empty($datosUsuario)) {
      // Redirección a ../Home/
      header("Location: ../Home/");
      exit(); // Asegurarse de que el script se detenga después de la redirección
    }
   
?>

</head>

<body>
  <link href="../Transportes/firma/assets/jquery.signaturepad.css" rel="stylesheet">
  <!--start header-->
  <?php include("../../config/templates/mainHeader.php"); ?>

  <!--end header-->


  <!--start sidebar-->
  <?php include("../../config/templates/mainSidebar.php"); ?>
  <!--end sidebar-->


  <!--start main content-->
  <main class="page-content">
    <!--breadcrumb-->
    
    <input type="hidden" id="idUsu" value="<?php echo $_GET['idAlumno']; ?>">
    <input type="hidden" id="idUsuSession" value="<?php echo $_SESSION['usu_id']; ?>">
    <input type="hidden" id="idUsuToken" value="<?php echo $tokenIdUrl; ?>">


    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Perfil</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Perfil de Usuario</li>
          </ol>
        </nav>
      </div>
      
    </div>
    <!--end breadcrumb-->


    <hr>
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-success" role="tablist">
          <li class="nav-item" role="presentation1">
            <a class="nav-link active" data-bs-toggle="tab" href="#perfil" role="tab" aria-selected="true">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                </div>
                <div class="tab-title">Perfil</div>
              </div>
            </a>
          </li>
          <li class="nav-item" role="presentation1">
            <a class="nav-link" data-bs-toggle="tab" href="#editarPerfil" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                </div>
                <div class="tab-title">Cuenta</div>
              </div>
            </a>
          </li>
          <li class="nav-item" role="presentation1">
            <a class="nav-link" data-bs-toggle="tab" href="#todoEducacion" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                </div>
                <div class="tab-title">Preferencias</div>
              </div>
            </a>
          </li>
          <li class="nav-item" role="educacion">
            <a class="nav-link" data-bs-toggle="tab" href="#educacion" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bx-book font-18 me-1'></i>
                </div>
                <div class="tab-title">Educación</div>
              </div>
            </a>
          </li>
          <?php 
            session_start(); 

            // Verifica que el usuario haya iniciado sesión y tenga el rol adecuado
            if (isset($_SESSION['usu_rol']) && $_SESSION['usu_rol'] == 1) { 
            ?>
          <li class="nav-item" role="presentation1">
            <a class="nav-link" data-bs-toggle="tab" href="#administración" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                </div>
                <div class="tab-title">Administración</div>
              </div>
            </a>
          </li>
            <?php } ?>
        </ul>
        <div class="tab-content py-3">

          <div class="tab-pane fade show active" id="perfil" role="tabpanel">
            <div class="row">
              <div class="col-12 col-lg-12 col-xl-12">
                <div class="card overflow-hidden">
                  <div class="profile-cover bg-dark position-relative mb-4">
                    <div class="user-profile-avatar shadow position-absolute top-50 start-0 translate-middle-x">
                      <img src="../../public/assets/images/users/<?php echo $datosUsuario[0]['avatarUsu'] ; ?>" alt="...">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="mt-5 d-flex align-items-start justify-content-between">
                      <div class="">
                        <h3 class="mb-2"><?php echo $datosUsuario[0]['nomAlumno'] . ' ' . $datosUsuario[0]['apeAlumno'] ;?></h3>
                        <p class="mb-1">Nick de inicio de sesión: <?php echo $datosUsuario[0]['nomUsuario']?></p>
                        <p class="mb-1">Correo de contacto: <?php echo $datosUsuario[0]['emailUsuario']?></p>
                        <!-- <p>Valencia, España</p>
                        <div class="">
                          <span class="badge rounded-pill bg-primary">Junion</span>
                          <span class="badge rounded-pill bg-primary">Cualidades</span>
                          <span class="badge rounded-pill bg-primary">Otras cualidades</span>
                        </div> -->
                      </div>
                      
                      <!-- <div class="">
                        <a href="javascript:;" class="btn btn-primary"><i class="bi bi-chat me-2"></i>Enviar mensaje</a>
                      </div> -->
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-9">
                            <label for="profilePicture" class="col-sm-3 col-form-label">Cambiar foto de perfil</label>
                            <div class="d-flex align-items-center">
                              <img
                                id="profilePreview"
                                src="../../public/assets/images/users/<?php echo $datosUsuario[0]['avatarUsu']; ?>"
                                alt="Foto de perfil"
                                class="img-thumbnail me-3"
                                style="width: 100px; height: 100px;"
                              />
                              <input
                                type="file"
                                class="form-control"
                                id="profilePicture"
                                accept="image/*"
                                onchange="previewProfilePicture(event)"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-12">
                            <button type="submit" id="guardarAvatarBtn" class="btn btn-info">Actualizar Avatar</button>
                          </div>
                        </div>
                  </div>
                </div>
                <!-- <div class="card">
                  <div class="card-body">
                    <h4 class="mb-2">Drescripcion</h4>
                    <p class="">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                  </div>
                </div> -->
              </div>
              <div class="col-12 col-lg-4 col-xl-3">

                <?php if($transporte_m == 1){ ?>
               <!--  <div class="card">
                  <div class="card-body">
                    <h5 class="mb-3">Firma General <i class="bi signature me-2"></i></h5>
                    
                    <div class="row">
                      <?php if($datosUsuario[0]['firmaTransportista_transportistasTransporte'] != ''){ ?>
                        <small>Esta es la firma que se mostrará automáticamente en todas las ordenes. </small>
                        <img id="imgFirmaGeneral" src="<?php //echo $datosUsuario[0]['firmaTransportista_transportistasTransporte']; ?>" style="max-height: 125px" alt="">
                      <?php }else{ ?> 
                        
                        <small class="tx-danger">Sin firma general. Por favor, firme en el apartado 'Editar Perfil' > 'Firma Digital'.</small>

                      <?php } ?>
                    </div>

                  </div>
                </div> -->
                <?php } ?>

                    <!--  <div class="card">
                        <div class="card-body">
                          <h5 class="mb-3">Connect</h5>
                          <p class=""><i class="bi bi-browser-edge me-2"></i>www.example.com</p>
                          <p class=""><i class="bi bi-facebook me-2"></i>Facebook</p>
                          <p class=""><i class="bi bi-twitter me-2"></i>Twitter</p>
                          <p class="mb-0"><i class="bi bi-linkedin me-2"></i>LinkedIn</p>
                        </div>
                      </div> -->
                    <!-- 
                      <div class="card">
                        <div class="card-body">
                          <h5 class="mb-3">Skills</h5>
                          <div class="mb-3">
                            <p class="mb-1">Web Design</p>
                            <div class="progress" style="height: 5px;">
                              <div class="progress-bar" role="progressbar" style="width: 45%"></div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <p class="mb-1">HTML5</p>
                            <div class="progress" style="height: 5px;">
                              <div class="progress-bar" role="progressbar" style="width: 55%"></div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <p class="mb-1">PHP7</p>
                            <div class="progress" style="height: 5px;">
                              <div class="progress-bar" role="progressbar" style="width: 65%"></div>
                            </div>
                          </div>
                          <div class="mb-3">
                            <p class="mb-1">CSS3</p>
                            <div class="progress" style="height: 5px;">
                              <div class="progress-bar" role="progressbar" style="width: 75%"></div>
                            </div>
                          </div>
                          <div class="mb-0">
                            <p class="mb-1">Photoshop</p>
                            <div class="progress" style="height: 5px;">
                              <div class="progress-bar" role="progressbar" style="width: 85%"></div>
                            </div>
                          </div>

                        </div>
                      </div> -->

              </div>
            </div><!--end row-->
          </div>
          <div class="tab-pane fade" id="editarPerfil" role="tabpanel">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body p-4">
                    <h5 class="mb-4">Editar perfil</h5>
                      <form id="insertar-cuenta-form" class="form-horizontal form-material">
                        <!-- Foto de perfil -->
                       

                        <!-- Campo oculto -->
                        <input
                          type="hidden"
                          name="idUsuario"
                          value="<?php echo $datosUsuario[0]['idAlumno']; ?>"
                          class="form-control"
                        />

                        <!-- Información básica -->
                        <div class="row pt-3">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Usuario (Username for Login)</label>
                              <input
                                type="text"
                                value="<?php echo $datosUsuario[0]['nomUsuario']; ?>"
                                class="form-control"
                                disabled
                              />
                              <small class="form-control-feedback">Usuario para iniciar sesión.</small>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group has-danger">
                              <label class="control-label">Contraseña (Password)</label>
                              <a
                                href="../CambiarPass/?tokenidusu=<?php echo $tokenIdUrl; ?>"
                                class="btn btn-outline-primary px-4 form-control"
                              >
                                Pulsa aquí para cambiar la contraseña <i class="bi bi-lock-fill"></i>
                              </a>
                            </div>
                          </div>
                        </div>

                        <hr />

                        <!-- Información personal -->
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Apodo (Nickname)</label>
                              <input
                                type="text"
                                name="nomUsuario"
                                value="<?php echo $datosUsuario[0]['nomUsuario']; ?>"
                                id="nomUsuario"
                                class="form-control" disabled
                              />
                              <small class="form-control-feedback">Nombre de usuario</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Nombre (Name)</label>
                              <input
                                type="text"
                                name="nomAlumno"
                                value="<?php echo $datosUsuario[0]['nomAlumno']; ?>"
                                id="nomAlumno"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Nombre personal</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Apellido (Surname)</label>
                              <input
                                type="text"
                                name="apeAlumno"
                                id="apeAlumno"
                                value="<?php echo $datosUsuario[0]['apeAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Apellidos personales</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Teléfono (Phone)</label>
                              <input
                                type="tel"
                                name="teleAlumno"
                                id="teleAlumno"
                                value="<?php echo $datosUsuario[0]['teleAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Número de contacto</small>
                              <span id="valid-msg" class="hide" style="color:green">✓</span>
                              <span id="error-msg" class="hide" style="color:red"></span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Nacionalidad (Nationality)</label>
                              <input
                                type="text"
                                name="nacioAlumno"
                                id="nacioAlumno"
                                value="<?php echo $datosUsuario[0]['nacioAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Nacionalidad (Española, Inglesa, etc.)</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Fecha de Nacimiento (Date of Birth)</label>
                              <input
                                type="date"
                                name="fecNacAlumno"
                                id="fecNacAlumno"
                                value="<?php echo $datosUsuario[0]['fecNacAlumno']; ?>"
                                class="form-control"
                                required
                              />
                            </div>
                          </div>
                        </div>

                        <!-- Más información -->
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Profesión o Estudios (Occupation/Studies)</label>
                              <input
                                type="text"
                                name="ProfeEstuAlumno"
                                id="ProfeEstuAlumno"
                                value="<?php echo $datosUsuario[0]['ProfeEstuAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Profesión, Estudios máximos</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Nombre de Empresa (Company Name)</label>
                              <input
                                type="text"
                                name="EmpresaAlumno"
                                id="EmpresaAlumno"
                                value="<?php echo $datosUsuario[0]['EmpresaAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Deja vacío si no trabajas</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group has-success">
                              <label class="control-label">Nombre de Universidad (University Name)</label>
                              <input
                                type="text"
                                name="UniAlumno"
                                id="UniAlumno"
                                value="<?php echo $datosUsuario[0]['UniAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">Deja vacío si no estudias</small>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group has-success">
                              <label class="control-label">Domicilio en Valencia (Address in Valencia)</label>
                              <input
                                type="text"
                                name="domValAlumno"
                                id="domValAlumno"
                                value="<?php echo $datosUsuario[0]['domValAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">¿Dónde resides actualmente?</small>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group has-success">
                              <label class="control-label">Domicilio en tu país (Address in your country)</label>
                              <input
                                type="text"
                                name="domOrigenAlumno"
                                id="domOrigenAlumno"
                                value="<?php echo $datosUsuario[0]['domOrigenAlumno']; ?>"
                                class="form-control"
                              />
                              <small class="form-control-feedback">¿Cuál es tu dirección en tu país de origen?</small>
                            </div>
                          </div>
                        </div>

                        <!-- Botón de envío -->
                        <div class="form-group">
                          <div class="col-sm-12">
                            <button type="submit" id="agregarGuardar" class="btn btn-success">Actualizar Datos</button>
                          </div>
                        </div>
                      </form>


                          
                  </div>
                  
                </div>

              </div>
            </div><!--end row-->

          </div>
          <!-- CONOCIMIENTOS APARTAdo estudiante  -->          
          <div class="tab-pane fade" id="todoEducacion" role="tabpanel">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body p-4">

                      <!-- UL DE EDUCACION -->
                      <ul class="nav nav-tabs nav-danger" role="tablist">
                        <li class="nav-item" role="presentation">
                          <a class="nav-link active" data-bs-toggle="tab" href="#conocimientos" role="tabpanel" aria-selected="true">
                            <div class="d-flex align-items-center">
                              <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                              </div>
                              <div class="tab-title">CONOCIMIENTOS</div>
                            </div>
                          </a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" data-bs-toggle="tab" href="#aprendizaje" role="tabpanel" aria-selected="false">
                            <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">APRENDIZAJE</div>
                            </div>
                          </a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" data-bs-toggle="tab" href="#objetivos" role="tabpanel" aria-selected="false">
                            <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">OBJETIVOS</div>
                            </div>
                          </a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" data-bs-toggle="tab" href="#actividades" role="tabpanel" aria-selected="false">
                            <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">ACTIVIDADES</div>
                            </div>
                          </a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" data-bs-toggle="tab" href="#adaptaciones" role="tabpanel" aria-selected="false">
                            <div class="d-flex align-items-center">
                              <div class="tab-icon">
                              </div>
                              <div class="tab-title">ADAPTACIONES</div>
                            </div>
                          </a>
                        </li>
                      </ul>
                      <!-- FIN UL EDUCACION -->
                      <div class="tab-content py-3">

                              <!-- CONOCIMIENTOS  -->          
                              <div class="tab-pane fade show active" id="conocimientos" role="tabpanel">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="card">
                                      <div class="card-body p-4">

                                                <form id="insertar-conocimientos-form" class="form-horizontal form-material">
                                                    <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario[0]['idAlumno'] ?>" class="form-control" placeholder="example@gmail.com">

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group has-success">
                                                                <label class="control-label">Lengua(s) materna(s) (Mother tongue)</label>
                                                                <input type="text" name="lenMatAlumno" id="lenMatAlumno" value="<?php echo $datosUsuario[0]['lenMatAlumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">¿Cual es tu lengua materna?</small>
                                                            </div>
                                                        </div>

                                                    </div> <!-- FIN ROW -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Lenguas que conozco (Languages I know):</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-group has-success">
                                                                <input type="text" name="lenCon1Alumno" id="lenCon1Alumno" value="<?php echo $datosUsuario[0]['lenCon1Alumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">1.- Lenguaje</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group has-success">
                                                                <input type="text" name="lenCon2Alumno" id="lenCon2Alumno" value="<?php echo $datosUsuario[0]['lenCon2Alumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">2.- Lenguaje</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group has-success">
                                                                <input type="text" name="lenCon3Alumno" id="lenCon3Alumno" value="<?php echo $datosUsuario[0]['lenCon3Alumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">3.- Lenguaje</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">

                                                            <div class="form-group has-success">
                                                                <input type="text" name="lenCon4Alumno" id="lenCon4Alumno" value="<?php echo $datosUsuario[0]['lenCon4Alumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">4.- Lenguaje</small>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="control-label">Sobre el español (About Spanish)</h5>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-t-10">
                                                        <div class="col-md-12">
                                                            <label class="control-label">¿Has estudiado antes español? Have you ever studied Spanish before?</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bt-switch mg-t-20 mg-b-20 mg-mb-l-50">
                                                            <input type="checkbox" id="estudiadoSpanish" value="<?php echo $datosUsuario[0]['estEspAlumno'] ?>" data-on-text="No" data-off-text="Yes" checked data-on-color="danger" data-off-color="success"><br>
                                                            <small class="form-control-feedback">Presiona para cambiar la opción</small>
                                                        </div>
                                                        <div class="col-md-4 mg-b-10 onSpanish">
                                                            <label class="control-label">Nivel alcanzado (Level achieved)</label>

                                                            <select class="form-control" name="nivEspAlumno" value="<?php echo $datosUsuario[0]['nivEspAlumno']; ?>" id="nivEspAlumno">
                                                                <option value="0" <?php echo $datosUsuario[0]['nivEspAlumno'] == '0' ? 'selected' : ''; ?>>Seleccione un Nivel (Select language proficiency level)</option>
                                                                <option value="A1" <?php echo $datosUsuario[0]['nivEspAlumno'] == 'A1' ? 'selected' : ''; ?>>A1 (Principiante)</option>
                                                                <option value="A2" <?php echo $datosUsuario[0]['nivEspAlumno'] == 'A2' ? 'selected' : ''; ?>>A2 (Elemental)</option>
                                                                <option value="B1" <?php echo $datosUsuario[0]['nivEspAlumno'] == 'B1' ? 'selected' : ''; ?>>B1 (Intermedio)</option>
                                                                <option value="B2" <?php echo $datosUsuario[0]['nivEspAlumno'] == 'B2' ? 'selected' : ''; ?>>B2 (Intermedio-avanzado)</option>
                                                                <option value="C1" <?php echo $datosUsuario[0]['nivEspAlumno'] == 'C1' ? 'selected' : ''; ?>>C1 (Avanzado)</option>
                                                                <option value="C2" <?php echo $datosUsuario[0]['nivEspAlumno'] == 'C2' ? 'selected' : ''; ?>>C2 (Maestría)</option>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-4 onSpanish">
                                                            <label class="control-label">¿Cuánto tiempo? (For how long?)</label>

                                                            <div class="form-group has-success">
                                                                <input type="text" name="tiemEspAlumno" id="tiemEspAlumno" value="<?php echo $datosUsuario[0]['tiemEspAlumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">Ej. 3 Meses</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5 onSpanish">
                                                            <label class="control-label">¿Dónde? (Where?)</label>

                                                            <div class="form-group has-success">
                                                                <input type="text" name="lugEspAlumno" id="lugEspAlumno" value="<?php echo $datosUsuario[0]['lugEspAlumno'] ?>" class="form-control" placeholder="">
                                                                <small class="form-control-feedback">¿Dónde has estudiado español?</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-7">
                                                            <label class="control-label">¿Por qué quieres aprender español? (Why do you want to learn Spanish?)</label>

                                                            <div class="form-group has-success">
                                                                <input type="text" name="porEspAlumno" id="porEspAlumno" value="<?php echo $datosUsuario[0]['porEspAlumno'] ?>" class="form-control" placeholder="">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mg-b-10">
                                                            <label class="control-label">¿Qué crees que necesitas mejorar en español? What do you need to improve in Spanish?</label>

                                                            <select class="form-control" name="mejEspAlumno" value="<?php echo $datosUsuario[0]['mejEspAlumno'] ?>" id="mejEspAlumno">
                                                                <option value="0" <?php echo $datosUsuario[0]['mejEspAlumno'] == '0' ? 'selected' : ''; ?>>Seleccione una opción (Select an option)</option>
                                                                <option value="1" <?php echo $datosUsuario[0]['mejEspAlumno'] == '1' ? 'selected' : ''; ?>>Comprensión auditiva (Listening comprehension)</option>
                                                                <option value="2" <?php echo $datosUsuario[0]['mejEspAlumno'] == '2' ? 'selected' : ''; ?>>Comprensión lectora (Reading comprehension)</option>
                                                                <option value="3" <?php echo $datosUsuario[0]['mejEspAlumno'] == '3' ? 'selected' : ''; ?>>Expresión oral (Speaking skills)</option>
                                                                <option value="4" <?php echo $datosUsuario[0]['mejEspAlumno'] == '4' ? 'selected' : ''; ?>>Expresión escrita (Writing skills)</option>
                                                                <option value="5" <?php echo $datosUsuario[0]['mejEspAlumno'] == '5' ? 'selected' : ''; ?>>Pronunciación (Pronunciation)</option>
                                                                <option value="6" <?php echo $datosUsuario[0]['mejEspAlumno'] == '6' ? 'selected' : ''; ?>>Vocabulario (Vocabulary)</option>
                                                                <option value="7" <?php echo $datosUsuario[0]['mejEspAlumno'] == '7' ? 'selected' : ''; ?>>Gramática (Grammar)</option>
                                                                <option value="8" <?php echo $datosUsuario[0]['mejEspAlumno'] == '8' ? 'selected' : ''; ?>>Cultura (Culture)</option>
                                                            </select>

                                                        </div>

                                                        <div class="form-group ">
                                                            <div class="col-sm-12">
                                                                <button type="submit" class="btn btn-success" >Actualizar Datos</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>


                                      </div>
                                    </div>

                                  </div>
                                </div><!--end row-->

                              </div>
                              <!-- FIN CONOCIMIENTOS  -->     

                              <!-- APRENDIZAJE  -->          
                              <div class="tab-pane fade" id="aprendizaje" role="tabpanel">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="card">
                                      <div class="card-body p-4">

                                                <form id="insertar-aprendizaje-form" class="form-horizontal form-material">
                                                    <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario[0]['idAlumno'] ?>" class="form-control">
                                                    <div class="row">
                                                        <div class="col-md-12 mg-b-20">
                                                            <h3 class="control-label">¿CÓMO APRENDO? - HOW DO I LEARN?</h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="control-label">Para aprender lenguas prefiero (To learn languages I prefer):</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mg-b-20">

                                                        <div class="col-12 col-md-6 ">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="aprEspAlumno1" name="aprEspAlumno" value="1" class="custom-control-input" <?php if ($datosUsuario[0]['aprEspAlumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="aprEspAlumno1">Leer (Reading)</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="aprEspAlumno3" name="aprEspAlumno" value="3" class="custom-control-input" <?php if ($datosUsuario[0]['aprEspAlumno'] == 3) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="aprEspAlumno3">Escribir (Writing)</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="aprEspAlumno4" name="aprEspAlumno" value="4" class="custom-control-input" <?php if ($datosUsuario[0]['aprEspAlumno'] == 4) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="aprEspAlumno4">Hablar (Speaking)</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="aprEspAlumno2" name="aprEspAlumno" value="2" class="custom-control-input" <?php if ($datosUsuario[0]['aprEspAlumno'] == 2) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="aprEspAlumno2">Escuchar (Listening)</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="aprEspAlumno5" name="aprEspAlumno" value="5" class="custom-control-input" <?php if ($datosUsuario[0]['aprEspAlumno'] == 5) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="aprEspAlumno5">Traducir a mi idioma (Translating)</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="aprEspAlumno6" name="aprEspAlumno" value="6" class="custom-control-input" <?php if ($datosUsuario[0]['aprEspAlumno'] == 6) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="aprEspAlumno6">Estar con nativos (Being with natives)</label>
                                                            </div>
                                                        </div>



                                                    </div> <!-- FIN ROW -->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="control-label">¿Qué actividades te gustan hacer en clase? What kind of activities do you like to do?</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row  mg-b-20">
                                                        <div class="col-12 col-md-6">

                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act1Alumno" <?php if ($datosUsuario[0]['act1Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act1Alumno">Actividades comunicativas (Communicative activities)</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act2Alumno" <?php if ($datosUsuario[0]['act2Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act2Alumno">Aprender vocabulario (Learning vocabulary)</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act3Alumno" <?php if ($datosUsuario[0]['act3Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act3Alumno">Aprender con juegos (Learning with games)</label>
                                                            </div>


                                                        </div>

                                                        <div class=" col-12 col-md-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act4Alumno" <?php if ($datosUsuario[0]['act4Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act4Alumno">Practicar gramática (Grammar practice)</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act5Alumno" <?php if ($datosUsuario[0]['act5Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act5Alumno">Actividades audiovisuales (Audiovisual)</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act6Alumno" <?php if ($datosUsuario[0]['act6Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act6Alumno">Actividades interactivas (Interactive)</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="act7Alumno" <?php if ($datosUsuario[0]['act7Alumno'] == 1) echo "checked"; ?>>
                                                                <label class="custom-control-label" for="act7Alumno">Hacer deberes (Doing homework)</label>
                                                            </div>
                                                        </div>

                                                    </div> <!-- FIN ROW -->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="control-label">¿Cómo te gusta trabajar? How do you like to work?</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row  mg-b-20 mg-10">


                                                        <div class="custom-control custom-radio col-12 col-md-4">
                                                            <input type="radio" id="gustaTraAlumno1" name="gustaTraAlumno" value="1" class="custom-control-input" <?php if ($datosUsuario[0]['gustaTraAlumno'] == 1) echo "checked"; ?>>
                                                            <label class="custom-control-label" for="gustaTraAlumno1">Solo (Alone)</label>
                                                        </div>

                                                        <div class="custom-control custom-radio  col-12 col-md-4">
                                                            <input type="radio" id="gustaTraAlumno2" name="gustaTraAlumno" value="2" class="custom-control-input" <?php if ($datosUsuario[0]['gustaTraAlumno'] == 2) echo "checked"; ?>>
                                                            <label class="custom-control-label" for="gustaTraAlumno2">En parejas (in pairs)</label>
                                                        </div>

                                                        <div class="custom-control custom-radio  col-12 col-md-4">
                                                            <input type="radio" id="gustaTraAlumno3" name="gustaTraAlumno" value="3" class="custom-control-input" <?php if ($datosUsuario[0]['gustaTraAlumno'] == 3) echo "checked"; ?>>
                                                            <label class="custom-control-label" for="gustaTraAlumno3">Grupos (groups)</label>
                                                        </div>


                                                    </div> <!-- FIN ROW -->


                                                    <div class="row">
                                                        <div class="col-md-12 mg-t-20">
                                                            <div class="form-group has-success">
                                                                <button type="submit" class="btn btn-success">Actualizar Datos</button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>


                                      </div>
                                    </div>

                                  </div>
                                </div><!--end row-->

                              </div>
                              <!-- FIN APRENDIZAJE  -->    

                              <!-- OBJETIVOS  -->          
                              <div class="tab-pane fade" id="objetivos" role="tabpanel">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="card">
                                      <div class="card-body p-4">

                                        <form id="insertar-objetivos-form" class="form-horizontal  form-material">

                                            <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario[0]['idAlumno'] ?>" class="form-control">

                                            <div class="row">
                                                <div class="col-12 col-md-12 mg-b-20">
                                                    <h3 class="control-label">OBJETIVOS DEL CURSO - COURSE AIMS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 col-md-12 mg-b-20">
                                                    <h4 class="control-label">Durante mi curso de español me gustaría... In my Spanish course I’d like to...</h4>
                                                </div>
                                            </div>

                                            <div class="row  mg-b-20">
                                                <div class="col-12 col-md-6">

                                                    <div class="custom-control custom-checkbox mg-b-10">
                                                        <input type="checkbox" class="custom-control-input" id="gus1EspAlumno" <?php if ($datosUsuario[0]['gus1EspAlumno'] == 1) echo "checked"; ?>>
                                                        <label class="custom-control-label" for="gus1EspAlumno">Ganar fluidez y seguridad al comunicarme (Improve my fluency and confidence when I speak)</label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox mg-b-10">
                                                        <input type="checkbox" class="custom-control-input" id="gus2EspAlumno" <?php if ($datosUsuario[0]['gus2EspAlumno'] == 1) echo "checked"; ?>>
                                                        <label class="custom-control-label" for="gus2EspAlumno">Revisar contenidos difíciles para mí (Review the most difficult Spanish contents for me)</label>
                                                    </div>



                                                </div>

                                                <div class=" col-12 col-md-6">

                                                    <div class="custom-control custom-checkbox mg-b-10">
                                                        <input type="checkbox" class="custom-control-input" id="gus3EspAlumno" <?php if ($datosUsuario[0]['gus3EspAlumno'] == 1) echo "checked"; ?>>
                                                        <label class="custom-control-label" for="gus3EspAlumno">Mejorar mis calificaciones en español (Improve my Spanish qualifications)</label>
                                                    </div>

                                                    <div class="custom-control custom-checkbox mg-b-10">
                                                        <input type="checkbox" class="custom-control-input" id="gus4EspAlumno" <?php if ($datosUsuario[0]['gus4EspAlumno'] == 1) echo "checked"; ?>>
                                                        <label class="custom-control-label" for="gus4EspAlumno">Aprender nuevos contenidos (Learning new contents)</label>
                                                    </div>

                                                </div>

                                            </div> <!-- FIN ROW -->

                                            <div class="row  mg-b-20">
                                                <div class="col-12 col-md-6">

                                                    <div class="custom-control custom-checkbox mg-b-10">
                                                        <input type="checkbox" class="custom-control-input" id="gus5EspAlumno" <?php if ($datosUsuario[0]['gus5EspAlumno'] == 1) echo "checked"; ?>>
                                                        <label class="custom-control-label" for="gus5EspAlumno">Otros (Other):</label>
                                                    </div>

                                                </div>

                                                <div class=" col-12 col-md-6">

                                                    <div id="gusTextEspAlumnoDiv" class="form-group has-success  d-none">
                                                        <input type="text" name="gusTextEspAlumno" id="gusTextEspAlumno" value="<?php echo $datosUsuario[0]['gusTextEspAlumno'] ?>" class="form-control " placeholder="">
                                                        <small class="form-control-feedback">Escribe tu sugerencia. Please provide your suggestion.</small>
                                                    </div>

                                                </div>

                                            </div> <!-- FIN ROW -->

                                            <hr>

                                            <div class="row">
                                                <div class="col-12 col-md-12 mg-b-20">
                                                    <h3 class="control-label">¿CÓMO NOS HAS CONOCIDO? HOW DID YOU HEAR ABOUT US?</h3>
                                                </div>
                                            </div>

                                            <div class="row  mg-b-20 mg-10">


                                                <div class="custom-control custom-radio col-12 col-md-3">
                                                    <input type="radio" id="conAlumno1" name="conAlumno" value="1" class="custom-control-input" <?php if ($datosUsuario[0]['conAlumno'] == 1) echo "checked"; ?>>
                                                    <label class="custom-control-label" for="conAlumno1">Internet</label>
                                                </div>

                                                <div class="custom-control custom-radio  col-12 col-md-3">
                                                    <input type="radio" id="conAlumno2" name="conAlumno" value="2" class="custom-control-input" <?php if ($datosUsuario[0]['conAlumno'] == 2) echo "checked"; ?>>
                                                    <label class="custom-control-label" for="conAlumno2">Recomendacion</label>
                                                </div>

                                                <div class="custom-control custom-radio  col-12 col-md-3">
                                                    <input type="radio" id="conAlumno3" name="conAlumno" value="3" class="custom-control-input" <?php if ($datosUsuario[0]['conAlumno'] == 3) echo "checked"; ?>>
                                                    <label class="custom-control-label" for="conAlumno3">Agencia</label>
                                                </div>

                                                <div class="custom-control custom-radio  col-12 col-md-3">
                                                    <input type="radio" id="conAlumno4" name="conAlumno" value="4" class="custom-control-input" <?php if ($datosUsuario[0]['conAlumno'] == 4 ) echo "checked"; ?>>
                                                    <label class="custom-control-label" for="conAlumno4">Anuncio</label>
                                                </div>



                                            </div> <!-- FIN ROW -->

                                            <div id="conRecoAlumnoDiv" class="row mg-b-20 mg-10 d-flex justify-content-center d-none">
                                                <div class="col-md-5">
                                                    <div class="form-group has-success">
                                                        <input type="text" name="conRecoAlumno" id="conRecoAlumno" value="<?php echo $datosUsuario[0]['conRecoAlumno'] ?>" class="form-control" placeholder="">
                                                        <small class="form-control-feedback">¿Quién te ha recomendado? - Who recommended you?</small>
                                                    </div>
                                                </div>
                                            </div> <!-- FIN ROW -->
                                            <div id="conAgenAlumnoDiv" class="row mg-b-20 mg-10 d-flex justify-content-center d-none">
                                                <div class="col-md-5">
                                                    <div class="form-group has-success">
                                                        <input type="text" name="conAgenAlumno" id="conAgenAlumno" value="<?php echo $datosUsuario[0]['conAgenAlumno'] ?>" class="form-control" placeholder="">
                                                        <small class="form-control-feedback">¿A través de qué agencia nos conociste? - Through which agency did you get to know us?</small>
                                                    </div>
                                                </div>
                                            </div> <!-- FIN ROW -->

                                            <div class="row">
                                                <div class="col-md-12 mg-t-20">
                                                    <div class="form-group has-success">
                                                        <button type="submit" class="btn btn-success">Actualizar Datos</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>


                                      </div>
                                    </div>

                                  </div>
                                </div><!--end row-->

                              </div>
                              <!-- FIN OBJETIVOS  -->    

                              <!-- actividad  -->          
                              <div class="tab-pane fade" id="actividades" role="tabpanel">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="card">
                                      <div class="card-body p-4">
                                          <form id="insertar-actividades-form" class="form-horizontal  form-material">
                                              <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario[0]['idAlumno'] ?>" class="form-control">

                                              <div class="row">
                                                  <div class="col-12 col-md-12 mg-b-20">
                                                      <h3 class="control-label">ACTIVIDADES EXTRAACADÉMICAS SOCIAL PROGRAM</h3>
                                                  </div>
                                              </div>


                                              <div class="row">
                                                  <div class="col-12 col-md-12 mg-b-20">
                                                      <h5 class="control-label">
                                                          Cada semana diseñamos un programa de actividades socioculturales para que todos losestudiantes tengan la oportunidad de practicar su español también fuera de la escuela mientras sedivierten,
                                                          conocen a otros estudiantes y descubren aspectos de la vida cultural española y valenciana. <br><br> Each week we design a programme of socio-cultural
                                                          activities so that all students have theopportunity to practice their Spanish outside of school while having fun, meeting other students anddiscovering aspects of Spanish and Valencian cultural life.
                                                          What type of activities would you beinterested in participating in?</h5>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                  <div class="col-12 col-md-12 mg-b-20">
                                                      <h6 class="control-label">
                                                          ¿En qué tipo de actividades estarías interesado en participar? - What type of activities would you beinterested in participating in?</h6>
                                                  </div>
                                              </div>


                                              <div class="row  mg-b-20 mg-10">


                                                  <div class="col-12 col-md-6">
                                                      <div class="custom-control custom-checkbox mg-b-10">
                                                          <input type="checkbox" class="custom-control-input" id="actSocialesAlumno" <?php if ($datosUsuario[0]['actSocialesAlumno'] == 1) echo "checked"; ?>>
                                                          <label class="custom-control-label" for="actSocialesAlumno">Actividades sociales (Social activities)</label><br>
                                                          <small class="form-control-feedback">Noche de salsa, salidas nocturnas, cervezas y billar, paseos, etc.</small>
                                                      </div>

                                                      <div class="custom-control custom-checkbox mg-b-10">
                                                          <input type="checkbox" class="custom-control-input" id="actGastroAlumno" <?php if ($datosUsuario[0]['actGastroAlumno'] == 1) echo "checked"; ?>>
                                                          <label class="custom-control-label" for="actGastroAlumno">Actividades gastronómicas (Gastronomic activities)</label><br>
                                                          <small class="form-control-feedback">Degustación de paella, cata de vinos, cenas de tapas, típicas bebidas, etc.</small>
                                                      </div>
                                                  </div>


                                                  <div class="col-12 col-md-6">
                                                      <div class="custom-control custom-checkbox mg-b-10">
                                                          <input type="checkbox" class="custom-control-input" id="actCultAlumno" <?php if ($datosUsuario[0]['actCultAlumno'] == 1) echo "checked"; ?>>
                                                          <label class="custom-control-label" for="actCultAlumno">Actividades culturales (Cultural activities)</label><br>
                                                          <small class="form-control-feedback">Visitas guiadas, museos, rutas, cine, charlas, exposiciones, etc.</small>

                                                      </div>
                                                      <div class="custom-control custom-checkbox mg-b-10">
                                                          <input type="checkbox" class="custom-control-input" id="actDepoAlumno" <?php if ($datosUsuario[0]['actDepoAlumno'] == 1) echo "checked"; ?>>
                                                          <label class="custom-control-label" for="actDepoAlumno">Actividades deportivas (Sport activities)</label><br>
                                                          <small class="form-control-feedback">Voley playa, asistencia a partidos de fútbol en Mestalla, baloncesto, etc.</small>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                  <div class="col-12 col-md-12 mg-b-20">
                                                      <h5 class="control-label">
                                                          Tenemos un grupo de WhatsApp para informarte de todas las actividades semanales.
                                                          We have a WhatsApp group to inform you about all the activities of the week. Móvil (Mobile phone) 24h: <b><a href="tel:+34 664446944"> +34 664446944</a></b></h5>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                  <div class="col-12 col-md-12 mg-b-20">
                                                      <h5 class="control-label"> ¿Te gustaría participar? Would you like to be in? </h5>
                                                  </div>



                                              </div>
                                              <div class="row mg-10">


                                                  <div class="col-md-4 bt-switch mg-b-20 mg-mb-l-50 ">

                                                      <input type="checkbox" id="partActAlumno" value="<?php echo $datosUsuario[0]['partActAlumno'] ?>" data-on-text="No" data-off-text="Yes" checked data-on-color="danger" data-off-color="success"><br>
                                                      <small class="form-control-feedback">Presiona para cambiar la opción</small>
                                                  </div>

                                                  <div id="numActAlumnoDiv" class="form-group has-success col-md-4 d-none">
                                                      <input type="text" name="numActAlumno" id="numActAlumno" value="<?php echo $datosUsuario[0]['numActAlumno'] ?>" class="form-control" placeholder="">
                                                      <small class="form-control-feedback">Tu número (Your WhatsApp number)</small>
                                                  </div>

                                              </div>

                                              <div class="row">
                                                  <div class="col-md-12 mg-t-20">
                                                      <div class="form-group has-success">
                                                          <button type="submit" class="btn btn-success">Actualizar Datos</button>
                                                      </div>
                                                  </div>
                                              </div>



                                          </form>


                                      </div>
                                    </div>

                                  </div>
                                </div><!--end row-->

                              </div>
                              <!-- FIN actividad  -->    

                              
                              <!-- ADATPACIONES  -->          
                              <div class="tab-pane fade" id="adaptaciones" role="tabpanel">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="card">
                                      <div class="card-body p-4">
                                            <form id="insertar-adaptaciones-form" class="form-horizontal  form-material">
                                                <input type="hidden" name="idUsuario" value="<?php echo $datosUsuario[0]['idAlumno'] ?>" class="form-control">

                                                <div class="row  mg-b-20 mg-10">


                                                    <div class="col-12 col-md-6">
                                                        <div class="custom-control custom-checkbox mg-b-10">
                                                            <input type="checkbox" class="custom-control-input" id="agoraAlumno" <?php if ($datosUsuario[0]['agoraAlumno'] == 1) echo "checked"; ?>>
                                                            <label class="custom-control-label" for="agoraAlumno">Agorafobia (Agoraphobia)</label><br>
                                                            <small class="form-control-feedback">Tendremos en cuenta asignarte a un aula adaptada a tu condición. ( We will consider assigning you to a classroom adapted to your condition. )</small>
                                                        </div>

                                                        <div class="custom-control custom-checkbox mg-b-10">
                                                            <input type="checkbox" class="custom-control-input" id="minusvaliaAlumno" <?php if ($datosUsuario[0]['minusvaliaAlumno'] == 1) echo "checked"; ?>>
                                                            <label class="custom-control-label" for="minusvaliaAlumno">Aula accesible para personas con discapacidad (Accessible classroom)</label><br>
                                                            <small class="form-control-feedback">Tendremos en cuenta asignarte a un aula adaptada a tu condición. ♿ ( We will consider assigning you to a classroom adapted to your condition. )</small>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group has-success">
                                                            <label class="control-label">Otros (Other)</label>
                                                            <textarea name="obsMinusvaliaAlumno" id="obsMinusvaliaAlumno" maxlength="180" row="4" class="form-control" placeholder="Escribe aquí..."><?php echo $datosUsuario[0]['obsMinusvaliaAlumno']; ?></textarea>
                                                            <small class="form-control-feedback">Infórmanos sobre cualquier aspecto relevante para su enseñanza, como condiciones de salud. ( Please inform us of any relevant aspects for their education, such as health conditions. ) </small>
                                                        </div>
                                                    </div>
                                                
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mg-t-20">
                                                        <div class="form-group has-success">
                                                        <button type="button" class="btn btn-success" id="guardarAdaptaciones">Actualizar Datos</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>


                                      </div>
                                    </div>

                                  </div>
                                </div><!--end row-->

                              </div>
                              <!-- FIN adaptaciohnes  -->    
                      </div>

                  </div>


                </div>

              </div>
            </div><!--end row-->

          </div>
          <!-- FIN CONOCIMIENTOS APARTAdo estudiante  -->          


          <!-- DOCENCIA APARTAdo estudiante  -->          
          <div class="tab-pane fade" id="educacion" role="tabpanel">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body p-4">

                 <!-- UL DE EDUCACION -->
              <ul class="nav nav-tabs nav-danger" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#misCursos" role="tabpanel" aria-selected="true">
                    <div class="d-flex align-items-center">
                      <div class="tab-icon">
                        <i class='bi bi-home font-18 me-1'></i>
                      </div>
                      <div class="tab-title"
                          <?php if (empty($_SESSION['llegada_idLlegada'])): ?>
                            style="color: gray; font-style: italic;"
                          <?php endif; ?>>
                        MIS CURSOS
                      </div>
                    </div>
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#matriculaciones" role="tabpanel" aria-selected="false">
                    <div class="d-flex align-items-center">
                      <div class="tab-icon">
                      </div>
                      <div class="tab-title">MATRICULACIONES</div>
                    </div>
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#actividadesEd" role="tabpanel" aria-selected="false">
                    <div class="d-flex align-items-center">
                      <div class="tab-icon">
                      </div>
                      <div class="tab-title">ACTIVIDADES</div>
                    </div>
                  </a>
                </li>
                
                <!-- Nueva pestaña Alojamientos -->
                <li class="nav-item" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#alojamientos" role="tabpanel" aria-selected="false">
                    <div class="d-flex align-items-center">
                      <div class="tab-icon">
                      </div>
                      <div class="tab-title">ALOJAMIENTOS</div>
                    </div>
                  </a>
                </li>

                <li class="nav-item" role="presentation">
                  <a class="nav-link" data-bs-toggle="tab" href="#certificados" role="tabpanel" aria-selected="false">
                    <div class="d-flex align-items-center">
                      <div class="tab-icon">
                      </div>
                      <div class="tab-title">CERTIFICADOS</div>
                    </div>
                  </a>
                </li>
              </ul>
              <!-- FIN UL EDUCACION -->

                      <div class="tab-content py-3">
                    <!-- MIS CURSOS -->           
                    <div class="tab-pane fade show active" id="misCursos" role="tabpanel">
                      <input type="hidden" id="idLlegada" value="<?php echo $_SESSION['llegada_idLlegada']?>">
                      <?php if (empty($_SESSION['llegada_idLlegada'])): ?>
                        <div style="background-color: #fdf6f0; border: 2px dashed #d4a373; padding: 20px; border-radius: 12px; font-family: Georgia, serif; color: #5a3e36; max-width: 600px; margin: 30px auto; text-align: center;">
                          <h2 style="color: #b08968;">¡Ups!</h2>
                          <p>Debes seleccionar un departamento para poder ver los cursos.</p>
                          <p>You must select a department to view the courses.</p>
                        </div>
                      <?php else: ?>
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="card">
                              <div class="card-body p-4">
                                <div class="row g-3">
                                  <div class="col-12">
                                    <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>
                                    <div class="row">
                                      <div class="table-responsive order-mobile-first">
                                        <?php
                                          $nombreTabla = "cursos_table";
                                          $nombreCampos = ["Ruta", "Fecha Inicio", "Fecha Fin", "Acción"];
                                          $cantidadGrupos = 1;
                                          $columGrupos = [];
                                          $agrupacionesPersonalizadas = 0;
                                          $colorHEX = "#3AB54A";
                                          $desplegado = 0;
                                          $colorPicker = 0;

                                          $tablaHTML = generarTabla(
                                            $nombreTabla,
                                            $nombreCampos,
                                            $nombreCampos,
                                            $cantidadGrupos,
                                            $columGrupos,
                                            $agrupacionesPersonalizadas,
                                            $colorHEX,
                                            $desplegado,
                                            $colorPicker
                                          );
                                          echo $tablaHTML;
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div><!--end row-->
                      <?php endif; ?>
                    </div>
                    <!-- FIN MIS CURSOS -->

                    <!-- MATRICULACIONES -->
                    <div class="tab-pane fade" id="matriculaciones" role="tabpanel">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="card">
                            <div class="card-body p-4">
                                                        <div class="form-group ">
                                                            <div class="col-sm-12">
                                                                <a href="./facturaAlum.php?tokenUsu=<?php echo $_GET['tokenUsuario']?>" target="_blank" class="btn btn-success">Ver Facturas</a>
                                                            </div>
                                                        </div>
                              <!-- Filtro o ayuda si aplica -->
                              <?php include_once '../../config/modalAyudas/filtroActivo.php'; ?>

                              <!-- Contenedor de DataTable -->
                              <div class="row">
                                <div class="col-12">
                                  <div class="table-responsive order-mobile-first">
                                    <?php
                                      $nombreTabla = "llegadas_table";

                                      $nombreCampos = [
                                        "Inscripción",
                                        "Dia Inscripción",
                                        "Fecha Llegada",
                                        "Departamento",
                                        "Matriculas - Alojamiento",
                                        "Estado"
                                      ];

                                      $cantidadGrupos = 1; // Cambiar a 0 si no quieres agrupaciones
                                      $columGrupos = []; // Por ejemplo [3] para agrupar por departamento
                                      $agrupacionesPersonalizadas = 0;
                                      $colorHEX = "#3AB54A"; // Verde
                                      $desplegado = 0;
                                      $colorPicker = 0;

                                      $tablaHTML = generarTabla(
                                        $nombreTabla,
                                        $nombreCampos,
                                        $nombreCampos,
                                        $cantidadGrupos,
                                        $columGrupos,
                                        $agrupacionesPersonalizadas,
                                        $colorHEX,
                                        $desplegado,
                                        $colorPicker
                                      );

                                      echo $tablaHTML;
                                    ?>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div><!--end row-->
                    </div>
                    <!-- FIN MATRICULACIONES -->
                     
                   <!-- ACTIVIDADES -->
                  <div class="tab-pane fade" id="actividadesEd" role="tabpanel">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="card-body p-4">

                            <!-- Mostrar título -->
                            <p><strong>Actividades ya realizadas</strong></p>

                            <!-- Input hidden con ID usuario -->
                            <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo htmlspecialchars($_SESSION['usu_id']); ?>">

                            <div class="row">
                              <div class="col-12">
                                <?php include_once '../../config/modalAyudas/filtroActivo.php'; ?>

                                <div class="row">
                                  <!-- ################################# -->
                                  <!-- ########## USUARIO NORMAL ####### -->
                                  <!-- ################################# -->
                                  <div id="tablaUsuario" class="table-responsive order-mobile-first">
                                    <?php
                                    $nombreTabla = "act_usuario_table";
                                    $nombreCampos = [
                                      "Actividad",
                                      "Fecha Actividad",
                                      "Horas Lectivas",
                                      "Punto de Encuentro",
                                      "Cartel"
                                    ];
                                    $nombreCamposFooter = $nombreCampos;

                                    $cantidadGrupos = 1;
                                    $columGrupos = [];
                                    $agrupacionesPersonalizadas = 0;
                                    $colorHEX = "#3AB54A";
                                    $desplegado = 0;
                                    $colorPicker = 0;

                                    $tablaHTML = generarTabla(
                                      $nombreTabla,
                                      $nombreCampos,
                                      $nombreCamposFooter,
                                      $cantidadGrupos,
                                      $columGrupos,
                                      $agrupacionesPersonalizadas,
                                      $colorHEX,
                                      $desplegado,
                                      $colorPicker
                                    );
                                    echo $tablaHTML;
                                    ?>
                                  </div>
                                </div>

                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div><!--end row-->
                  </div>
                  <!-- FIN ACTIVIDADES -->

                <!-- ALOJAMIENTOS -->
                <div class="tab-pane fade" id="alojamientos" role="tabpanel">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-body p-4">

                          <!-- Mostrar título -->
                          <p><strong>Alojamientos finalizados</strong></p>

                          <!-- Input hidden con ID alumno -->
                          <input type="hidden" id="idAlumn" name="idAlumn" value="<?php echo htmlspecialchars($_SESSION["usuPre_idInscripcion"]); ?>">

                          <div class="row">
                            <div class="col-12">
                              <?php include_once '../../config/modalAyudas/filtroActivo.php'; ?>

                              <div class="row">
                                <!-- Tabla de alojamientos -->
                                <div class="table-responsive order-mobile-first"> 
                                  <?php
                                  $nombreTabla = "alojamientos_table";
                                  $nombreCampos = ["ID", "Tipo Alojamiento", "Nombre", "Fecha Entrada", "Fecha Salida", "Dirección", "Ver"];
                                  $nombreCamposFooter = $nombreCampos;
                                  $cantidadGrupos = 1;
                                  $columGrupos = [];
                                  $agrupacionesPersonalizadas = 0;
                                  $colorHEX = "#3AB54A";
                                  $desplegado = 0;
                                  $colorPicker = 0;

                                  $tablaHTML = generarTabla(
                                    $nombreTabla,
                                    $nombreCampos,
                                    $nombreCamposFooter,
                                    $cantidadGrupos,
                                    $columGrupos,
                                    $agrupacionesPersonalizadas,
                                    $colorHEX,
                                    $desplegado,
                                    $colorPicker
                                  );
                                  echo $tablaHTML;
                                  ?>
                                </div>
                              </div>

                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div><!--end row-->
                </div>
                <!-- FIN ALOJAMIENTOS -->

           <!-- CERTIFICADOS -->
              <div class="tab-pane fade" id="certificados" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body p-4">

                        <!-- Filtro activo (si aplica) -->
                        <?php include_once '../../config/modalAyudas/filtroActivo.php'; ?>

                        <!-- Contenedor de la tabla -->
                        <div class="row">
                          <div class="col-12">
                            <div class="table-responsive order-mobile-first">
                              <?php
                                $nombreTabla = "certificados_table";

                                $nombreCampos = [
                                  "Inscripción",
                                  "Día Inscripción",
                                  "Departamento",
                                  "Estado",
                                  "Descargar"
                                ];

                                $cantidadGrupos = 0; // Cambia a 1 si deseas agrupar por Departamento, por ejemplo
                                $columGrupos = [];   // Ej: [3] para agrupar por Departamento
                                $agrupacionesPersonalizadas = 0;
                                $colorHEX = "#17A2B8"; // Azul (certificados)
                                $desplegado = 0;
                                $colorPicker = 0;

                                $tablaHTML = generarTabla(
                                  $nombreTabla,
                                  $nombreCampos,
                                  $nombreCampos,
                                  $cantidadGrupos,
                                  $columGrupos,
                                  $agrupacionesPersonalizadas,
                                  $colorHEX,
                                  $desplegado,
                                  $colorPicker
                                );

                                echo $tablaHTML;
                              ?>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div><!--end row-->
              </div>
              <!-- FIN CERTIFICADOS -->


                      </div>

                  </div>


                </div>

              </div>
            </div><!--end row-->

          </div>
          <!-- FIN DOCENCIA APARTAdo estudiante  -->          
          <!-- ADMINISTRACION  -->   
          <?php 
            session_start(); 

            // Verifica que el usuario haya iniciado sesión y tenga el rol adecuado
            if (isset($_SESSION['usu_rol']) && $_SESSION['usu_rol'] == 1) { 
            ?>
            <div class="tab-pane fade" id="administración" role="tabpanel">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body p-4">

                        <div class="" id="pills-tabContent"> <!--CONTENT 2 -->
                            Bloquear que el usuario pueda editar su perfil: <input type="checkbox" name="bloquearEditar" id="bloquearEditar">

                        </div><!-- //CONTENT 2 -->
            
                        <div class="" id="pills-tabContent"> <!--CONTENT 2 -->
                          Deshabilitar usuario: <input type="checkbox" name="" id="">

                        </div><!-- //CONTENT 2 -->


                    </div>
                  </div>

                </div>
              </div><!--end row-->

          </div>
          <?php }?>  
         
          <!-- FIN ADMNISTRACION  -->          


        </div>
      </div>
    </div>



  <?php include_once 'modalCursos.php' ?>




  </main>
  <!--end main content-->


  <!--start overlay-->
  <div class="overlay btn-toggle-menu"></div>
  <!--end overlay-->

  <!-- Search Modal -->
  <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>


  <!--start theme customization-->
  <?php include("../../config/templates/mainThemeCustomization.php"); ?>
  <!--end theme customization-->

  <!--BS Scripts-->
  <?php include("../../config/templates/mainJs.php"); ?>

  
  <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>



  <script>
        $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
        var radioswitch = function() {
            var bt = function() {
                $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioState")
                }), $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
                }), $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
                })
            };
            return {
                init: function() {
                    bt()
                }
            }
        }();
        $(document).ready(function() {
            radioswitch.init()
        });
    </script>
    
  <script src="index.js"></script>
  <script src="perfil.js"></script>
  <script src="educacion.js"></script>

  <!-- end BS Scripts-->


  <!--start plugins extra-->
  <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <!--end plugins extra-->



</body>

</html>