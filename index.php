

<?php
require "conexion.php";
session_start();

function function_alert($message) {
    echo "<script>alert('$message');</script>";
}

$numusuario="";

if($_POST){

  $usuario = $_POST['usuario'];
  $password = $_POST['password'];

  $sql = "SELECT cod_usuario,nombre_usuario_correo, clave_usuario,estado_usuario, numero_ingresos
   FROM tbl_usuarios_login
  WHERE nombre_usuario_correo='$usuario'";
  //echo $sql;
  $resultado = $mysqli->query($sql);
  $num = $resultado->num_rows;

  if($num>0){
    $row = $resultado->fetch_assoc();
    $password_bd = $row['clave_usuario'];
    $numusuario=$row['cod_usuario'];
    $ingresos=$row['numero_ingresos'];
   
    $sql = "SELECT valor FROM tbl_parametros WHERE id_usuario=$numusuario and parametro='ADMIN_INTENTOS'";
 //echo $sql;
    $resultado4 = $mysqli->query($sql);
    $num4 = $resultado4->num_rows;
    $row4 = $resultado4->fetch_assoc();
    $intentos=$row4['valor'];

    $pass_c = sha1($password);
        if($row['estado_usuario']!="activo"){
            function_alert("Este usuario actualmente esta inactivo");
        }else{
            if($password_bd == $pass_c){
                $sql2="UPDATE tbl_parametros SET valor = '3' WHERE id_usuario= '$numusuario' and parametro='ADMIN_INTENTOS'";
                    $resultado2 = $mysqli->query($sql2);
                $_SESSION['nombre'] = $row['nombre_usuario_correo'];
                $_SESSION['id'] = $row['cod_usuario'];
                $_SESSION['nombre'] = $row['nombre_usuario_correo'];

                if($ingresos==0){
                    $_SESSION['user'] = $row;
                    header("Location: ./registro/config_preguntas_seguridad.php");
                }else{
                    header("Location: principal.php");
                    $sql2="UPDATE tbl_parametros SET valor = '3' WHERE id_usuario= '$numusuario' and parametro='ADMIN_INTENTOS'";
                    $resultado2 = $mysqli->query($sql2);
                    $sql2="UPDATE tbl_usuarios_login SET numero_ingresos = numero_ingresos + 1, fecha_ultima_conexion= NOW() WHERE cod_usuario= '$numusuario'";
                    $resultado2 = $mysqli->query($sql2);
                    $_SESSION['pasar_numero_usuario'] = $row['cod_usuario'];
                    $_SESSION['nombre'] = $row['nombre_usuario_correo'];
                    exit();
                }
                  
            } else {
                $sql2 = "SELECT valor FROM tbl_parametros WHERE id_usuario=$numusuario and parametro='ADMIN_INTENTOS'";
                    $resultado2 = $mysqli->query($sql2);
                    $num2 = $resultado2->num_rows;
                    $row2 = $resultado2->fetch_assoc();
                    $intentos=$row2['valor'];
                    if ($intentos>1){
                        function_alert("Error de autentificaci??n, usuario y/o clave inv??lidos");
                        $sql3="UPDATE tbl_parametros SET valor = valor-1 WHERE id_usuario= '$numusuario' and parametro='ADMIN_INTENTOS'";
                        $resultado3 = $mysqli->query($sql3);
                    }else{
                        function_alert("Su usuario ha sido bloqueado, ha realizado 3 intentos fallidos, hable con el administrador.");
                        $sql3="UPDATE tbl_usuarios_login SET estado_usuario = 'Bloqueado' WHERE cod_usuario= '$numusuario'";
                        $resultado3 = $mysqli->query($sql3);
                    }
            }
        }

    } else {
  function_alert("El usuario no existe, debe crear una cuenta");
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
        <meta name="author" content="Alex S??nches" />
        <title>Autentificaci??n NPH</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary" style="background-image:url('imagenes/nph1.png');background-attachment:fixed">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main >
                    <div class="container"  >
                        <div class="row justify-content-center "  >
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-15x margin: 10px rounded-lg mt-5" style="background:gray" >
                                    <div class="card-header" style="background:gray"><h3 class="text-center font-weight-light my-4"><b>Inicio de sesi??n NPH</b></h3></div>
                                    <div class="card-body" style="background:white; margin: 5px">
                                        <form class="" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"  >
                                            <div class="form-group"><p>*Su usuario es su <b>correo personal</b></p><label class="small mb-1" for="inputEmailAddress" >Ingrese su usuario o correo</label><input class="form-control py-4" id="usuario" type="email" name="usuario" autofocus placeholder="Su correo" required></div>
                                            <div class="form-group"><label class="small mb-1" for="inputPassword"  type="password">Ingrese su contrase??a(sin espacios)</label><input class="form-control py-4" id="password" type="password" name="password" placeholder="Su contrase??a" required></div>
                                            
                                            <div class="form-group">
                                            <div style="margin-top:2px;"><input style="margin-left:20px;" type="checkbox" id="mostrar_clave" onclick="myFuction()">&nbsp;&nbsp;Mostrar contrase??a</div>

                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><a class="small" style="background:white" href="password.html"><b>Olvid?? su contrase??a?</b></a>
                                              <button class="btn btn-primary" type="submit" name="ingresar">Ingresar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small" style="background:white"><a href="registro/register.php"><b>Necesita una cuentas? </b></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; alex vilches 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
        function myFuction() {
            var x=document.getElementById("password");
            if (x.type=="password") {
               x.type="text"; 
            }else{
                x.type="password"; 
            }
        }


        document.querySelector("#password").addEventListener("keyup", function(event){
        if (event.keyCode == 32){
        alert("Acabas de pulsar la barra espaciadora");
        }
        }, false);


    </script>
       

    </body>
</html>
