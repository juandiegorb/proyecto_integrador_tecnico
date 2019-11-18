<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cl&iacute;nica Cotecnova</title>
  <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
  <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
<!-- Llamado de css -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
    <div class="col-lg-offset-3 col-lg-6">
<?php
//condicion para comprobar si los campos están declarados anteriormente y si no estan vacíos
if(isset($_POST['enviar']) && !empty($_POST['tipoDocumento']) && !empty($_POST['numeroDocumento']) && 
        !empty($_POST['nombreCompleto']) &&!empty($_POST['apellidos']) && !empty($_POST['telefono']) && !empty($_POST['tipoUsuario']) 
        && !empty($_POST['contrasena'])){
    
    //lamado al archivo MySQL
    require_once '../Modelo/MySQL.php';
    //declaracion de variables con sus respectivas asignaciones
    
    $tipoDocumento= $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $nombreCompleto = $_POST['nombreCompleto'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $contrasena = md5($_POST['contrasena']);
    //nueva "archivo" MySQL
    $mysql = new MySQL;
    //llamado a funcion conectar
    $mysql->conectar();    
    //consulta donde se hace el llamado del numero de documento
    $repetido = $mysql->efectuarConsulta("select seguridad_inmotica.usuario.numero_cedula from seguridad_inmotica.usuario where seguridad_inmotica.usuario.numero_cedula = ".$numeroDocumento.""); 
    //condicion que comprueba si hay algun dato en la consulta
    if(mysqli_num_rows($repetido) > 0){
        //Desconecto la conexion de la bD
        $mysql->desconectar();
        //impresion de mensajes personalizados
        echo "<div class=\"alert alert-warning alert-dismissible\"><a href=\"../crear_usuario.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Alerta!</strong> Numero de documento ya existe.</div>";
        //redireccion
        header( "refresh:3;url=../crear_usuario.php" ); 
    }else{
        //variable que ejecutara la funcion consulta, pero en este caso, no usamos select sino insert para meter los datos a la respectiva table
        $insertarUsuarioi = $mysql->efectuarConsulta("insert into seguridad_inmotica.usuario(tipo_cedula_id, numero_cedula, nombre_completo, apellido, telefono, tipo_usuario_id, estado_id, contrasena) VALUES(".$tipoDocumento.",'".$numeroDocumento."','".$nombreCompleto."','".$apellidos."','".$telefono."',".$tipoUsuario.",1,'".$contrasena."')"); 
        //Desconecto la conexion de la bD
        $mysql->desconectar();
        //decision para comprobar si se ejecuto, se redirige al index principal
        if($insertarUsuarioi){
          //impresion de mensajes personalizados
           echo "<div class=\"alert alert-success alert-dismissible\"><a href=\"../ver_usuario.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Felicidades!</strong> El usuario ha sido registrado correctamente.</div>";
           //redireccion
           header( "refresh:3;url=../ver_usuario.php" );    
        } else {
            //mensaje de error personalizado
           echo "<div class=\"alert alert-warning alert-dismissible\"><a href=\"../crear_usuario.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Alerta!</strong> No se ha podido registrar al usuario.</div>";
           //redireccion
           header( "refresh:3;url=../crear_usuario.php" );          
        }
    }      
}else{
    //sino se cumple la primer condicion, se re envia nuevamente al formulario
  //mensaje personalizado
    echo "<div class=\"alert alert-warning alert-dismissible\"><a href=\"../crear_usuario.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Alerta!</strong> No se han enviado todos los datos necesarios.</div>";
    //redireccion
    header( "refresh:3;url=../crear_usuario.php" );          
}
?>
  </div>
  <!-- Llamado de los respectivos scripts -->
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>
