<?php
session_start();
include ('conexion.php');

if (isset($_POST['btnIngresar'])){

    $usuario_dni=$_POST['usuario_dni'];
    $usuario_clave=$_POST['usuario_clave'];

    if ($conexion=="si"){
        // consulta sql
        $query = "SELECT * FROM usuario WHERE usuario_dni='$usuario_dni' AND usuario_clave='$usuario_clave'";
        // ejecuta la consulta
        if ($resultado = mysqli_query($link,$query)){
            // cuenta número de registros devueltos
            $row_cont = mysqli_num_rows($resultado);
            
            // si el número de registros es mayor que 0....
            if ($row_cont > 0){
                $listaDatos = mysqli_fetch_array($resultado,MYSQLI_ASSOC);
                $usuario_cod = $listaDatos['usuario_cod'];
                $usuario_nom = $listaDatos['usuario_nom'];
                $usuario_dni = $listaDatos['usuario_dni'];
                $_SESSION['usuario_cod'] = $usuario_cod;
                $_SESSION['usuario_nom'] = $usuario_nom;
                $_SESSION['usuario_dni'] = $usuario_dni;
                mysqli_close($link);
                header ("location: ../modulos/home.php?u=$usuario_nom");
            }else{         
                $mensaje="DNI o Clave Incorrecta";
                echo '
                    <script>
                        alert("DNI o Clave Incorrecta");
                        window.location = "../modulos/login.php";
                    </script>
                ';
               
            }
        }else{
            echo "falló la consulta sql";
        }
    }else{
        echo "la Conexión ha fallado, inténtelo más tarde";
    }
}
?>