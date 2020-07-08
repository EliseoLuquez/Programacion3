<?php
/*
METODOS HTTP:(Para comunicarse con cualquier API)
*GET: Obtiene recursos, datos.
*POST: Crea recursos.
*PUT: Modificar recursos.
*DELETE: Borrar recursos.

*GET: entidad->trae todo
*GET: entidad?id= 1 ->trae datos del elemento id
*POST: entidad->Guardo datos que vienen por post
        Toma los datos ingresados en el Postman o la pag
*/

//echo "Clase02";

//Variable Super Global empieza con $_
//Muestra el valor del GET 
//var_dump($_GET); 

//echo $_GET['nombre'];

//Devolucion en json
//echo json_encode($_GET);
//echo json_encode($_POST);

//$respuesta = new stdClass;
/*
$respuesta->respuesta = true;
$respuesta->date = "Fallo";
*/
//echo json_encode($respuesta);
//echo json_encode($_REQUEST);


//echo json_decode ();

//$id = $_GET['id']??0;
/*
echo "Metodo GET " . $_GET['id'];
if(isset($_GET['id']))
{
    echo "Metodo GET " . $_GET['id'];
}
else
{
    echo'POST';
}*/

//echo $id;


//SERVER

//echo json_encode($_SERVER);

//SABER QUE METODO ENTRO A LA API CON REQUEST_METHOD

$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'];
$datos;

switch ($path_info) {
    case '/mascotas':
        if ($request_method == 'POST') {
            //guardo datos
            $archivo = fopen('mascotas.txt', 'a+');
            //VERIFICAR QUE EXISTE
            $linea = $_POST['name'] . ',' . $_POST['apellido'] . PHP_EOL;
            $bytes = fwrite($archivo, $linea);
            $datos = $bytes;
            $cerrar = fclose($archivo);
        } else if ($request_method == 'GET') {
            //devulevo datos
            //$datos = array('Gatos','Perros');
            $archivo = fopen('mascotas.txt', 'a+');
            $datos = fread($archivo, filesize('mascotas.txt'));
            $cerrar = fclose($archivo);
        } else {
            echo "405 method not allowed";
        }
        break;
    case '/personas':
        if ($request_method == 'POST') {
            //guardo datos
        } else if ($request_method == 'GET') {
            //devulevo datos
            $datos = array('Juan', 'Maria', 'Pedro');
        } else {
            echo "405 method not allowed";
        }
        break;
    case '/autos':
        if ($request_method == 'POST') {
            //guardo datos
        } else if ($request_method == 'GET') {
            //devulevo datos
            $datos = array('BMW', 'VWG', 'FORD');
        } else {
            echo "405 method not allowed";
        }
        break;
    default:
        break;
}


$respuesta = new stdClass;
$respuesta->success = true;
$respuesta->data = $datos;

echo json_encode($respuesta);


//** ARCHIVOS */
//ABRIR ARCHIVO
//$archivo= fopen('archivo.txt', 'a+');

//LECTURA
//Lee archivo completo
//echo fread($archivo, filesize('archivo.txt'));

//Lee de a 1 linea
/*while (!feof($archivo))
{
    echo fgets($archivo); 
}
*/
//ESCRITURA
/*
$bytes = fwrite($archivo, "Nueva Linea 1");
$bytes = fputs($archivo, "Nueva Linea 2");

//COPIAR ARCHIVO
copy('archivo.txt', 'archivo2.txt');

//BORRAR ARCHIVO
unlink('archivo2.txt');

//CERRAR ARCHIVO
$cerrar = fclose($archivo);
*/
