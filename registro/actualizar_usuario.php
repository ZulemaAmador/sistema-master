<?php
require "../conexion.php";
session_start();

function function_alert($message) {
echo "<script>alert('$message');</script>";
}
$correopersonal=$_SESSION['pasar_correo_personal'];
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

$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+6 month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );


if(isset($_POST['terminar_registro']) ){

    $clave1 = $_POST['clave_empleado1'];
    $clave2 = $_POST['clave_empleado2'];

        if($clave1!=$clave2){
            function_alert("Las contraseñas ingresadas no coiciden");
            
        }else{
            if (validar_clave($clave1, $error_encontrado)){

                $sql = "SELECT *FROM tbl_usuarios_login
                WHERE nombre_usuario_correo='$correopersonal'";
                //echo $sql;
                $resultado = $mysqli->query($sql);
                $num = $resultado->num_rows;

                    if($num>0){
                        header("Location: ../index.php");
                        function_alert("Este usuario ya está registrado");
                    } else {
                        $sql1 = "SELECT cod_empleado from tbl_empleados
                        WHERE correo_personal='$correopersonal'";
                        //echo $sql;
                        $resultado1 = $mysqli->query($sql1);
                        $num1 = $resultado1->num_rows;
                        if($num1>0){
                            $row1 = $resultado1->fetch_assoc();
                            $idempleado=$row1['cod_empleado'];

                                $sql = "INSERT INTO tbl_usuarios_login (id_rol_usuario, estado_usuario, nombre_usuario_correo, clave_usuario, cod_empleado, fecha_ultima_conexion,num_preguntas_contestadas,numero_ingresos, fecha_caducidad,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                VALUES(1, 'activo',UPPER('$correopersonal'), SHA1('$clave1'),'$idempleado', NOW(),0,0,'$nuevafecha', 1,now(),1,now())";
                                $resultado = $mysqli->query($sql);

                                $sql2 = "SELECT cod_usuario from tbl_usuarios_login
                                WHERE nombre_usuario_correo='$correopersonal'";
                                //echo $sql;
                                $resultado2 = $mysqli->query($sql2);
                                $num2 = $resultado2->num_rows;
                                if($num2>0){
                                    $row2 = $resultado2->fetch_assoc();
                                    $idusuario=$row2['cod_usuario'];

                                $sql3 = "INSERT INTO tbl_historial_contraseñas (id_usuario, contraseña,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                VALUES('$idusuario', SHA1('$clave1'), '$idusuario',now(),'$idusuario',now())";
                                $resultado3 = $mysqli->query($sql3);
                                header("Location: ../index.php");
                                }else{
                                    function_alert("La contraseña no se pudo ingresar al historial");  
                                }
                                
                        }else{
                            function_alert("El empleado no existe");  
                        }
                    }
                }else{
                    echo "Su contraseña no es valida: " . $error_encontrado;
            }
        }

}
 ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registrarse-NPH</title>
        <link href="css/styles.css" rel="stylesheet" />
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Actualización de usuarios</h3></div>
                                    <div class="card-body">
                                        
                                        <form class="" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                                <div class="form-row " style="margin:20px 20px 10px 20px">
                                                <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputPassword"><b>Rol de usuario</b> </label><input class="form-control py-4" id="modificarrolusuario" type="number" name="modificarrolusuario" autofocus maxlength="3" min="1" placeholder="Rol" required/></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputConfirmPassword"><b>Uusario o correo</b></label><input class="form-control py-4" id="modificarcorreousuario" type="email" name="modificarcorreousuario" maxlength="25" placeholder="Nuevo usuario" required/></div>
                                                        </div>
                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputPassword"><b>Ingrese una contraseña</b> </label><input class="form-control py-4" id="registroclave1" type="text" name="clave_empleado1"  maxlength="16" placeholder="Ingrese su contraseña" required/></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputConfirmPassword"><b>Confirme su contraseña</b></label><input class="form-control py-4" id="registroclave2" type="text" name="clave_empleado2" maxlength="16" placeholder="Confirme su contraseña" required/></div>
                                                        </div>

                                                  </div>
                                                  <p><b>Su contraseña debe contener:</b>  <br><small>
                                                            °Al menos 6 caracteres y como máximo 16 caracteres. <br>
                                                            °Al menos una letra mayúscula y una letra mayúscula.. <br>
                                                            °Al menos una número. <br>
                                                            °No se permiten espacios.</p></small>
                                              <div class="form-row " style="margin:20px 20px 10px 20px">
                                                  <div class="col-md-6">
                                                      <div ><button  class= "btn btn-primary" type="submit" name="actualizar_usuario" >Actualizar</button></div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <div ><button  class= "btn btn-primary" type="submit" name="cancelar_actualizar" >Cancelar</button></div>
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
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Vilches 2022</div>
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
    </body>
</html>
