<?php

require "../conexion.php";
session_start();

$param = "SELECT valor FROM tbl_parametros where parametro = 'ADMIN_PREGUNTAS'";
$p = $mysqli->query($param);
$num4 = $p->num_rows;
$row4 = $p->fetch_assoc();

$pregu = $row4['valor'];

$sql2 = "SELECT * FROM tbl_preguntas_usuarios limit $pregu";
$resultado2 = $mysqli->query($sql2);

if (isset($_POST['guardar'])) {
    $id = $_SESSION['pasar_numero_usuario'];
    $pregunta = $_POST['pregunta'];
    $resp = $_POST['respuesta'];



    $numres = "SELECT * FROM tbl_preguntas_respuestas_usuarios where id_usuario = '$id'";
    $numrespp = $mysqli->query($numres);
    $num4 = $numrespp->num_rows;

    if ($pregu == $num4) {
        $sql1 = mysqli_query($conn, "UPDATE tbl_usuarios_login SET numero_ingresos=numero_ingresos+1,num_preguntas_contestadas='$pregu',modificado_por='$id',fecha_modificacion=now() WHERE cod_usuario='$id'");
        $resultado1 = $mysqli->query($sql1);
        header('Location: ../index.php');
    } else {
        


        
        $pregu = "SELECT * from tbl_preguntas_respuestas_usuarios where id_pregunta = '$pregunta' and id_usuario='$id'";
        $numrespp = $mysqli->query($prgu);
        $num4 = $numrespp->num_rows;
        if ($num4 > 0) {
            echo "<script> alert ('Esta pregunta ya fue registrada,favor seleccion otra');
        location.href ='./config_preguntas_seguridad.php';
        </script>";
        } else {
            $numres = "INSERT INTO tbl_preguntas_respuestas_usuarios values('$pregunta','$id','$resp','$id',now(),'$id',now())";
            $numrespp = $mysqli->query($numres);
            echo "<script> alert ('Registrado correctamente');
        location.href ='./config_preguntas_seguridad.php';
        </script>";
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
    <title>preguntas de seguridad-NPH</title>
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
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registre sus preguntas de seguridad</h3>
                                </div>
                                <div class="card-body">

                                    <form class="" method="POST" action="">

                                        <div class="form-row " style="margin:20px 20px 10px 20px">
                                            <div class="col-md-10">
                                                <label class="small mb-1" for="inputConfirmPassword">Pregunta 1:Seleccione una pregunta</label>
                                                <select name="pregunta" id="combo_preguntasid1" required class="form-control">
                                                    <option value="0">selecciona una pregunta</option>
                                                    <?php while ($row2 = $resultado2->fetch_assoc()) { ?>
                                                        <option required value="<?php echo $row2['id_pregunta']; ?>"><?php echo $row2['pregunta']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Ingrese una respuesta</label>
                                                    <input autocomplete= "False" class="form-control py-4" type="text" name="respuesta" maxlength="100" placeholder="Escriba su respuesta" required />
                                                </div>
                                            </div>


                                            <div class="form-row " style="margin:20px 20px 10px 20px">
                                                <div class="col-md-7">
                                                    <div><button class="btn btn-primary" type="submit" name="guardar">Guardar</button></div>
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