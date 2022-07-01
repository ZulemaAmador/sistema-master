<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Gestion de usuarios</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#fecha_creacion').val("");
            $('#fecha_vencimiento').val("");
        })

        function limpiar() {
            $('#usuario').val("");
            $('#rol').val("");
            $('#correo_electronico').val("");
            $('#contraseña').val("");
            $('#fecha_creacion').val("");
            $('#fecha_vencimiento').val("");
            $('#estado').val("");            
        }
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Gestion de usuarios</h3>
                                </div>
                                <div class="card-body">
                                    <form name="formulario" method="post">
                                        <?php
                                        require "conexion.php";

                                        $conexion = $mysqli;

                                        if (isset($_POST['usuario'])) {
                                            $usuario = $_POST['usuario'];
                                            $nombre = $_POST['nombre'];
                                            $rol = $_POST['rol'];
                                            $correo_electronico = $_POST['correo_electronico'];
                                            $contraseña = $_POST['contraseña'];
                                            $fecha_creacion = $_POST['fecha_creacion'];
                                            $fecha_vencimiento = $_POST['fecha_vencimiento'];
                                            $estado = $_POST['estado'];

                                            $campos = array();

                                            if ($nombre == "") {
                                                array_push($campos, "El campo no puede estar vacio");
                                            }

                                            $sql = "INSERT into tbl_ms_usuarios (usuario, nombre_usuario, estado_usuario, contraseña, id_rol, correo_electronico, fecha_creacion, fecha_vencimiento) 
                                                values ('$usuario','$nombre','$estado','$contraseña',$rol,'$correo_electronico', NOW(), NOW() );";
                                            //echo $sql;
                                            if ($conexion->query($sql)) {
                                                echo "<script>alert('Usuario insertado con exito')</script>";
                                            } else {
                                                echo "<script>alert('Error')</script>";
                                            }
                                            /* insert into tbl_ms_usuarios (usuario, nombre_usuario, estado_usuario, contraseña, id_rol, correo_electronico, fecha_creacion, fecha_vencimiento) 

						values ('mauricio','mauricio','activo','12345678',1,'mauriciocarcamo66@gmail.com', NOW(), now() );		   */
                                        }
                                        ?>

                                        <div class="form-group">
                                            <label class="small mb-1" for="usuario">Usuario</label>
                                            <input class="form-control py-4" id="usuario" type="text" name="usuario" placeholder="Ingrese usuario" required />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="nombre">Nombre</label>
                                            <input class="form-control py-4" id="nombre" type="text" name="nombre" placeholder="Ingrese nombre" required />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="rol">Rol</label>
                                            <input class="form-control py-4" id="rol" type="number" name="rol" placeholder="Seleccione rol" required />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="correo_electronico">Correo Electronico</label>
                                            <input class="form-control py-4" id="correo_electronico" type="email" name="correo_electronico" placeholder="Ingrese su correo electronico" required />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="contraseña">Contraseña</label>
                                            <input class="form-control py-4" id="contraseña" type="text" name="contraseña" placeholder="Ingrese contraseña" required />
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="fecha_creacion">Fecha creacion</label>
                                            <input class="form-control py-4" id="fecha_creacion" type="text" name="fecha_creacion" placeholder="Ingrese fecha creacion"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="fecha_vencimiento">Fecha de vencimiento</label>
                                            <input class="form-control py-4" id="fecha_vencimiento" type="text" name="fecha_vencimiento" placeholder="Ingrese fecha de vencimiento"/>
                                        </div>

                                        <div class="form-group">
                                            <label class="small mb-1" for="estado">Estado</label>
                                            <input class="form-control py-4" id="estado" type="text" name="estado" placeholder="Seleccione estado" required />
                                        </div>

                                        <div class="form-group d-flex align-items-center justify-content-center my-3">
                                            <button type="submit" class="btn btn-primary form-control">Guardar</button>
                                        </div>

                                        <div class="form-group d-flex align-items-center justify-content-center my-2 ">
                                            <button type="" class="btn btn-primary form-control" onclick="limpiar()">Limpiar</button>
                                        </div>

                                        <div class="text-center">
                                            <div class="small"><a href="index.php">Regresar a inicio de sesion</a></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="register.html">Necesitas cuenta en NPH?</a></div>
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
                        <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a> &middot;
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