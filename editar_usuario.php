<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cl&iacute;nica Cotecnova - Modificar usuario</title>
  <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
  <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/style2.css">
  <!-- =======================================================
    Theme Name: Medilab
    Theme URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  <!--banner-->
  <div id="container">
    <?php
    session_start();
    if(isset($_SESSION['tipousuario'])){
        if($_SESSION['tipousuario'] == 3 || $_SESSION['tipousuario'] == 2 ){ //Sesion como medico
            include("header_index.php");
    ?>
    <?php
    //Trae id del usuario
    $id = $_GET['id'];
    //llamado al archivo MySQL
    require_once 'Modelo/MySQL.php';
    //nueva "consulta"
    $mysql = new MySQL;
    //funcion conectar
    $mysql->conectar();
    //consulta de toda la informacion del paciente 
    $seleccionInformacion = $mysql->efectuarConsulta("SELECT 
	seguridad_inmotica.tipo_cedula.id_tipo_cedula,
        seguridad_inmotica.tipo_cedula.nombre as tipo_cedula, 
        seguridad_inmotica.usuario.numero_cedula, 
        seguridad_inmotica.usuario.id_usuario, 
        seguridad_inmotica.usuario.nombre_completo, 
        seguridad_inmotica.usuario.apellido, 
        seguridad_inmotica.usuario.telefono, 
        seguridad_inmotica.tipo_usuario.id_tipo_usuario,
        seguridad_inmotica.tipo_usuario.nombre as tipo_usuario
        FROM seguridad_inmotica.usuario
        INNER JOIN seguridad_inmotica.tipo_cedula on seguridad_inmotica.usuario.tipo_cedula_id = seguridad_inmotica.tipo_cedula.id_tipo_cedula
        INNER JOIN seguridad_inmotica.tipo_usuario on seguridad_inmotica.usuario.tipo_usuario_id = seguridad_inmotica.tipo_usuario.id_tipo_usuario
        WHERE seguridad_inmotica.usuario.id_usuario = ".$id."");     
    while ($resultado= mysqli_fetch_assoc($seleccionInformacion)){
        $id_usuario = $resultado['id_usuario'];
        $id_tipo_cedula = $resultado['id_tipo_cedula'];
        $tipo_cedula = $resultado['tipo_cedula'];
        $numeroDocumento = $resultado['numero_cedula'];
        $nombre_completo = $resultado['nombre_completo'];
        $apellidos = $resultado['apellido'];
        $telefono = $resultado['telefono'];
        $id_tipo_usuario = $resultado['id_tipo_usuario'];
        $tipo_usuario = $resultado['tipo_usuario'];
    } 
    //Consulto el id y nombre de los estados civiles
    $seleccionTipoDocumento = $mysql->efectuarConsulta("select * from tipo_cedula"); 
    //Consulto el id y nombre de los departamentos
    $seleccionTipoUsuario = $mysql->efectuarConsulta("select * from tipo_usuario"); 
    //funcion desconectar
    $mysql->desconectar();    
    ?>
  </div>  
  <!--service-->
  <section id="service" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4">
          <h2 class="ser-title">Bienvenido</h2>
          <hr class="botm-line">
          <p>Bienvenid@ al formulario de actualizar, por favor rellenar los siguientes campos con informaci&oacute;n valida y real.</p>
          <p>Todos los datos pedidos ser&aacute;n de uso aplicativo, se guardar&aacute; la privacidad del usuario.</p>
        </div>
        <div class="col-md-8 col-sm-8">
          <div class="card">
            <!-- Tab panes -->
            <div class="card-body">
                <form class="form-horizontal form-material" method="Post" action="Controlador/updateUsuario.php?id=<?php echo $id_usuario;?>">                
                <div class="form-group">
                    <label class="col-sm-12">Tipo de documento</label>
                    <div class="col-sm-12">
                        <select class="form-control form-control-line" name="tipoDocumento" required="">
                         <option value="<?php echo $id_tipo_cedula?>" selected="true"><?php echo $tipo_cedula?></option>
                         <option disabled>Seleccione un estado si va a editar</option>
                        <!-- Llamado al ciclo while donde vamos a recorrer un array asociativo con la consulta declarada anteriormente -->
                         <?php 
                         while ($resultado= mysqli_fetch_assoc($seleccionTipoDocumento)){   
                             ?> 
                        <!-- Se traen los datos y se imprimen en las opciones del select -->
                          <option value="<?php echo $resultado['id_tipo_cedula']?>"><?php echo $resultado['nombre']?></option>  
                          <?php }?>
                      </select>
                    </div>
                  </div>
                  <!-- Divisiones, etiquetas e inputs -->
                  <div class="form-group">
                    <label class="col-sm-12">Numero</label>            
                    <div class="col-md-12">
                        <input type="text" value="<?php echo $numeroDocumento?>" placeholder="Ingrese el numero del documento" name="numeroDocumento" class="form-control form-control-line" required="" onkeypress="return solonumeros(event)">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Nombre Completo</label>
                    <div class="col-md-12">
                        <input type="text" value="<?php echo $nombre_completo?>" placeholder="Ingrese sus nombres" name="nombreCompleto" class="form-control form-control-line" required="" onkeypress="return sololetras(event)">
                    </div>
                  </div>
                  <div class="form-group">                  
                    <label class="col-md-12">Apellidos</label>
                    <div class="col-md-12">
                        <input type="text"  value="<?php echo $apellidos?>" placeholder="Ingrese sus apellidos" name="apellidos" class="form-control form-control-line" required="" onkeypress="return sololetras(event)">
                    </div>
                  </div>
                  <div class="form-group">                  
                    <label class="col-md-12">Telefono</label>
                    <div class="col-md-12">
                        <input type="text"  value="<?php echo $telefono?>" placeholder="Ingrese su numero de telefono" name="telefono" class="form-control form-control-line" required="" onkeypress="return solonumeros(event)">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-12">Tipo usuario</label>
                    <div class="col-sm-12">
                        <select class="form-control form-control-line" name="tipoUsuario" required="">
                         <option value="<?php echo $id_tipo_usuario?>" selected="true"><?php echo $tipo_usuario?></option>
                         <option disabled>Seleccione un estado si va a editar</option>
                           <?php 
                           //se recorre el resultado de la consulta de estado civil
                         while ($resultado= mysqli_fetch_assoc($seleccionTipoUsuario)){
                             //se imprime los resultados
                             ?> 
                          <option value="<?php echo $resultado['id_tipo_usuario']?>"><?php echo $resultado['nombre']?></option>  
                          <?php }?>
                      </select>
                    </div>
                  </div>    
                  <div class="form-group">
                    <label class="col-md-12">Imagen</label>
                    <div class="col-md-12">
                        <input type="file" class="form-control form-control-line" name="imagen">     
                    </div>
                  </div>
                                
                <div class="form-group">
                  <div class="col-sm-3 col-md-2">
                      <button class="btn btn-success" name="enviar">Modificar</button>
                  </div>
                  <div class="col-sm-9 col-md-4">
                      <a href="ver_usuario.php" class="btn btn-danger">Cancelar</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ service-->
     <!--footer-->
  <div id="footer">
  <?php
  include("footer.php");
  ?>
  </div>
    <?php
        }else{
            header( "refresh:0;url=index.php" );  
        }
    }else{
        header( "refresh:0;url=login.php" );    
    }
    ?>
  <!--/ footer-->
  <script src="js/validacionCampos.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.easing.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="contactform/contactform.js"></script>
  <script src="js/listasDependientes.js"></script>
</body>
</html>
