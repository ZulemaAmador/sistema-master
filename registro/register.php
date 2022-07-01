<?php

require "../conexion.php";
session_start();


$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+6 month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

$sql = "SELECT cod_especialidad,nombre_especialidad FROM tbl_especialidades";
//echo $sql;
$resultado = $mysqli->query($sql);
$sql3 = "SELECT cod_puesto,nombre_puesto FROM tbl_puesto_empleados";
//echo $sql;
$resultado3 = $mysqli->query($sql3);

if(isset($_POST['continuar_registro'])){
    $clave1 = $_POST['clave_empleado1'];
    $clave2 = $_POST['clave_empleado2'];
    $pnombre=$_POST['ingresoprimernombre'];
    $snombre=$_POST['ingresosegundonombre'];
    $papellido=$_POST['ingresoprimerapellido'];
    $sapellido=$_POST['ingresosegundoapellido'];
    $correop=$_POST['ingresocorreopersonal'];
    $correoe=$_POST['ingresocorreoempresa'];
    $telefono=$_POST['ingresotelefono'];
    $direccion=$_POST['ingresodireccion'];
    $identidad=$_POST['ingresoidentidad'];
    $contratacion=$_POST['ingresocontratacion'];
    $nacomiento=$_POST['ingresonacimiento'];
    $horario=$_POST['ingresohorario'];
        $sql4 = "SELECT cod_empleado from tbl_empleados
        WHERE correo_personal='$correop'";
        $resultado4 = $mysqli->query($sql4);
        $num4 = $resultado4->num_rows;
                if($num4>0){
                    function_alert("Este empleado ya esta registrado");

                }else {
                    header("Location: registroseguridad.php");
                    $especialidad=$_POST['select_especialidades'];
                    $puesto=$_POST['select_puestos'];
                    $sql2="INSERT INTO `tbl_empleados` (`primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `correo_personal`, `correo_empresa`, `telefono`, `direccion`, `identidad`, `fecha_contratacion`, `fecha_nacimiento`, `tipo_contrato_empleado`, `horario_trabajo_empleado`, `fecha_baja_empleado`, `razon_baja_empleado`, `numero_permisos_empleado`, `cod_de_especialidad_empleado`, `cod_puesto_empleado`) 
                    VALUES ('$pnombre', '$snombre', '$papellido','$sapellido', '$correop', '$correoe', '$telefono', '$direccion', '$identidad', '$contratacion', '$nacomiento', 'Permanente', '$horario', NULL, NULL, 0, 1, 1)";
                    $resultado2 = $mysqli->query($sql2);

                }    
                $_SESSION['pasar_correo_personal']=$correop;
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registro de informarción personal</h3></div>
                                    <div class="card-body">
                                        
                                        <form class="" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <div class="form-row " style="margin:20px 20px 10px 20px">
                                                     <div class="col-md-6">
                                                        <div class="form-group"><label class="small mb-1" for="inputprimernombre"><b>Ingrese su primer nombre</b> </label><input class="form-control py-4" id="Ingresoprimernombre" type="text" name="ingresoprimernombre" placeholder="Su nombre" maxlength="15" autofocus  required /></div>
                                                     </div>
                                                     <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputsegundonombre"><b>Ingrese su segundo nombre</b> </label><input class="form-control py-4" id="Ingresosegundonombre" type="text" name="ingresosegundonombre" placeholder="Su segundo nombre"maxlength="15" required /></div>
                                                        </div>  
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputprimerapellido"><b>Ingrese su primer apellido</b> </label><input class="form-control py-4" id="Ingresoprimerapellido" type="text" name="ingresoprimerapellido" placeholder="Su primer apellido"maxlength="15" required   /></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputsegundoapellido"><b>Ingrese su segundo apellido</b> </label><input class="form-control py-4" id="Ingresosegundoapellido" type="text" name="ingresosegundoapellido" placeholder="Su segundo apellido"maxlength="15" required   /></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputcorreopersonal"><b>Correo personal</b>*Este será su usuario</label><input class="form-control py-4" id="Ingresocorreopersonal" type="email" name="ingresocorreopersonal" placeholder="ejemplocorreo@gmail.com"  required /></div>
                                                        </div>   
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputcorreoempresa"><b>Correo electronico de empresa</b> </label><input class="form-control py-4" id="Ingresocorreoempresa" type="email" name="ingresocorreoempresa" placeholder="ejemplocorreo@gmail.org" required  /></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputnumerodetelefono"><b>Numero de telefono</b> *Solo numeros</label><input class="form-control py-4" id="Ingresotelefono" type="number" name="ingresotelefono" placeholder="Su numero de Telefono" maxlength="12" min="0" required  /></div>
                                                        </div>                                   
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputfechanacimiento"><b>Fecha de nacimiento</b> </label><input class="form-control py-4" id="Fechadenacimiento" type="Date" name="ingresonacimiento" placeholder="su fecha de nacimiento" required   /></div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group"><label class="small mb-1" for="inputidentidad"><b>Numero de Identidad</b>*Solo números y sin guiones</label><input class="form-control py-4" id="Ingresesunumerodeidentidad" type="number" name="ingresoidentidad" placeholder="Su Identidad" maxlength="15" min="0" required /></div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group"><label class="small mb-1" for="inputfechacontratacion"><b>Fecha de contratacion</b> </label><input class="form-control py-4" id="Ingresofechadecontratacion" type="Date" name="ingresocontratacion" placeholder="Su fecha contratacion" required  /></div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="form-group"><label class="small mb-1" for="inputdireccion"><b>Direccion completa(barrio, colonia, #casa etc)</b> </label><input class="form-control py-4" id="Ingresodireccion" type="text" name="ingresodireccion" placeholder="Su Direccion" maxlength="200" required  /></div> 
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group"><label class="small mb-1" for="inputhorariotrabajo"><b>Horario de trabajo</b> </label><input class="form-control py-4" id="horariodetrabajo" type="text" name="ingresohorario" placeholder="Su horario laboral"maxlength="100" required  /></div>
                                                        </div>   
                                                        <div class="col-md-6">
                                                        <label class="small mb-1"><b>Seleccione su especialidad</b> </label>
                                                            <select name="select_especialidades" id="select_especialidades" required>
                                                            <option name="option_especialidades" value="0" ></option>
                                                            <?php while($row = $resultado->fetch_assoc()){ ?>
                                                            <option value="<?php echo $row['cod_especialidad'];?>"><?php echo $row['nombre_especialidad']; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div> 
                                                        <div class="col-md-6">
                                                        <label class="small mb-1"><b>Seleccione su puesto asignado</b> </label>
                                                            <select name="select_puestos" id="select_puestos" required>
                                                            <option name="option_puestos" value="0" ></option>
                                                            <?php while($row2 = $resultado3->fetch_assoc()){ ?>
                                                            <option value="<?php echo $row2['cod_puesto'];?>"><?php echo $row2['nombre_puesto']; ?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div> 

                                                  </div>
                                                        <div class="col-md-7">
                                                        <div style="margin:30px 20px 10px 20px" class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><button class="btn btn-primary" type="submit" name="continuar_registro">continuar..</button></div>
                                                        </div>
                                                        <div class="col-md-5" >
                                                        <div style="margin:50px 20px 10px 20px" class="small" ><a href="../index.php">Ya tienes cuenta en NPH?</a></div>
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

