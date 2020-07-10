<?php session_start();

require 'config.php';
require '../functions.php';

comprobarSession();

$conexion = $conexion($bd_config);
if (!$conexion) {
    header('Location: ../error.php');
}

if ($_SERVER['REQUET_NETHOD']  == 'POST') {
    $titulo = limpiarDatos($_POST['titulo']);
    $extracto = limpiarDatos($_POST['extracto']);
    $texto = $_POST['texto'];
    $thum = $_FILES['thum']['tmp_name'];

    $archivos_subido = '../' . $blog_config['carpeta_imagenes'] . $_FILES['thumb']['name'];

    move_uploaded_file($thum, $archivos_subido);

    $statement = $conexion->prepare(
    'INSERT INTO articulos (id, titulo, extracto, texto, thumb) 
    VALUES (null, :titulo, :extracto, :texto, :thumb)'
    );

    $statement->execute(array(
        ':titulo' => $titulo,
        ':extracto' => $extracto,
        ':texto' => $texto,
        ':thumb' => $_FILES['thumb']['name']
    ));

    header('Location: '. RUTA . '/admin');
}

require '../views/nuevo.view.php';

?>