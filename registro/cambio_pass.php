<?php
  include '../conexion.php';
  session_start();
  
  function validar_clave($clave,&$error_clave){
    if(strlen($clave) < 6){
       $error_clave = "La clave debe tener al menos 6 caracteres";
       return false;
    }
    if(strlen($clave) > 16){
       $error_clave = "La clave no puede tener más de 16 caracteres";
       return false;
    }
    if (!preg_match('`[a-z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra minúscula";
       return false;
    }
    if (!preg_match('`[A-Z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra mayúscula";
       return false;
    }
    if (!preg_match('`[0-9]`',$clave)){
       $error_clave = "La clave debe tener al menos un caracter numérico";
       return false;
    }
    if (preg_match('" "',$clave)){
        $error_clave = "No se permiten espacios";
        return false;
     }
    $error_clave = "";
    return true;
 }


 if (isset($_POST['guardar'])) {
    $contra1 = $_POST['contra'];
    $contra2 = $_POST['contra1'];
    if ($contra1 == $contra2) {
        $contra1 = sha1($contra1);
        $id = $_SESSION['user']['cod_usuario'];
        $sql = "SELECT * FROM tbl_historial_contraseña where id_usuario = '$id'";
        $resultado = $mysqli->query($sql);
        $num = $resultado->num_rows;

        if ($num > 0) {
            echo "<script> alert ('Ya existe una contraseña anterior, favor cambiarla');
            location.href ='./cambio_pass.php';
            </script>";
        } else {

            $sql = "INSERT INTO tbl_historial_contraseñas (id_usuario,contraseña,creado_por_fecha_creacion,modificado_por,fecha_modificacion) Values('$id','$contra1','$id',now(),'$id',now())";
            $mysqli->query($sql);
            $sql = "UPDATE tbl_usuarios_login set clave_usuario = '$contra1' where cod_usuario = '$id'";
            $mysqli->query($sql);
            echo "<script> alert ('Registrado Correctamente');
            location.href ='./config_preguntas_seguridad.php';
            </script>";
        }
    } else {
        echo "<script> alert ('las contraseñas no coinciden');
          
            </script>";
    }
}
?>

<!DOCTYPE html5>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registrarse-NPH</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-2 rounded-lg mt-5" style="margin:20px">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Cambio de contraseña</h3>
                                </div>
                                <div class="card-body">

                                    <form class="" method="POST" action="">
                                        <div class="form-row " style="margin:20px 20px 10px 20px">
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputprimernombre"><b>Contraseña</b> </label>
                                                    <input class="form-control py-4" id="Ingresoprimernombre" type="password" name="contra"  maxlength="15" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputsegundonombre"><b>Confirme contraseña</b> </label>
                                                    <input class="form-control py-4" id="contra1" type="password" name="contra1"  maxlength="15" required />
                                                </div>
                                            </div>


                                            <div class="col-md-12 text-center">
                                                <div style="margin:30px 20px 10px 20px" class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" type="submit" name="guardar">Continuar</button></div>
                                            </div>
                                           
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>