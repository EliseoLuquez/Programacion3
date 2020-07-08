<?php
//VARIABLES DE SESION Y COOKIES
session_start();

include_once 'persona.php';

print_r($_SESSION);

if(isset($_SESSION['nombre']))
{
    echo "Hola " . $_SESSION['nombre'];
}
else
{
    $_SESSION['nombre'] = $_GET["nombre"] ?? 'NN';
}



/*
$persona = array();

$persona[0] = new Persona("Eliseo");
$persona[1] = new Persona("Romina");
$persona[2] = new Persona("Bernardo");
$persona[3] = new Persona("Sara");



$serializado = serialize($persona);

//$file = fopen('files/persona.txt', 'w');

//$rta = fwrite($file, $serializado);

//fclose($file);

//print_r("$rta");


$file = fopen('files/persona.txt', 'r');

//$rta = fgets($file, 194);
$rta = fread($file, filesize('files/personas.txt'));

fclose($file);

$listadoPersonas = unserialize($rta);

print_r("$rta");

foreach ($listadoPersonas as $persona) {
    # code...
    echo $persona->saludar() . "<br>";
}
*/



