<?php
require_once __DIR__ .'/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Config\DataBase;

$app = AppFactory::create();
$app->setBasePath('/Prog3/Clase_Illuminate/api/public');

//REGISTRAR RUTAS
(require_once __DIR__ .'/routes.php')($app);




return $app;


//---// 

// use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

// use Illuminate\Database\Capsule\Manager as Capsule;
// use Slim\Psr7\Response;
// use App\Models\Alumno;
// use App\Models\UTN\Inscripcion;



// //MIDDLEWARE
// $beforeMiddleware = function (Request $request, RequestHandler $handler) {
//     $response = $handler->handle($request);
//     $existingContent = (string) $response->getBody();

//     $response = new Response();
//     $response->getBody()->write('BEFORE' . $existingContent);

//     return $response;
// };

// // $afterMiddleware = function ($request, $handler) {
// //     $response = $handler->handle($request);
// //     $response->getBody()->write('AFTER');
// //     return $response;
// // };

// $app->add($beforeMiddleware);
// //$app->add($afterMiddleware);

// $app->post('/orm', function (Request $request, Response $response, $args) {

//     $alumno = new Alumno;
//     $alumno->alumno = "nuevo alumno ORM0";
//     $alumno->legajo = 3000;
//     $alumno->localidad = 2;
//     $alumno->cuatrimestre = 2;
    
//     $rta = array("rta"=>$alumno->save());
//     $rta = json_encode($rta);

//     $response->getBody()->write($rta);
//     return $response;
// });




// $app->get('/orm', function (Request $request, Response $response, $args) {
//     //BUSCA EL ID 2 Y LE CAMBIA EL NOMBRE
//     // $alumno = Alumno::find(2);
//     // $alumno->alumno = "ORM";

//     // $rta = $alumno->save();
//     // $rta = json_encode($alumno);

//     //TRAE TODOS LOS REGISTRO DE LA TABLA
//     $alumno = Alumno::all();
//     $rta = json_encode($alumno);

//     $response->getBody()->write($rta);
//     return $response;
// });



// $app->get('/', function (Request $request, Response $response, $args) {
//     $alumnos = Capsule::table('alumnos')
//      //Trae Solo alumno y legajo
//      //->select('alumno', 'legajo');

    
//     //Trae el primero en formato objeto
//     // ->where('id', '1')
//     // ->first();
    
//     //Consultas
//     // ->where('legajo', '<', '1000')
//     // ->where('localidad', '1')
//     // ->orWhere('localidad', '1')
    
//     // Escribir en consulta Sql
//     // ->whereRaw('');
    
//     ->get();
//     $rta = json_encode($alumnos);

//     $response->getBody()->write($rta);
//     return $response;
// });


// $app->get('/join', function (Request $request, Response $response, $args) {
//     $alumnos = Capsule::table('alumnos')
//     //Join une las tablas vinculadas (veo el dato en vez del id)
//     ->join("localidades", "localidades.id", "alumnos.localidad")
//     ->join("cuatrimestres", "cuatrimestres.id", "alumnos.cuatrimestre")
//     ->select("alumnos.id", "alumno", "legajo", "localidades.localidad", "cuatrimestres.nombre as cuatrimestre")
//     ->get();
//     $rta = json_encode($alumnos);

//     $response->getBody()->write($rta);
//     return $response;
// });

// $app->get('/agg', function (Request $request, Response $response, $args) {
//     $alumnos = Capsule::table('alumnos')
//     //Count cuenta los elementos de la tabla
//     //->count();
    
//     //avg Promedia
//     //->avg("legajo");

//     //max maximo
//     //->max("legajo");

//     //min minimo
//     //->min("legajo");

//     ->get();

//     $rta = json_encode($alumnos);

//     $response->getBody()->write($rta);
//     return $response;
// });

// $app->post('/', function (Request $request, Response $response, $args) {
//     $alumnos = Capsule::table('alumnos')
//     // ->insert([
//     //     "alumno"=>'eñoquent',
//     //     "legajo"=>'2000',
//     //     "localidad"=>1,
//     //     "cuatrimestre"=>3
//     // ]);

//     ->insertGetId([
//         "alumno"=>'eloquent2',
//         "legajo"=>'2100',
//         "localidad"=>2,
//         "cuatrimestre"=>2
//     ]);


//     $rta = json_encode($alumnos);

//     $response->getBody()->write($rta);
//     return $response;
// });

// $app->put('/', function (Request $request, Response $response, $args) {
//     $alumnos = Capsule::table('alumnos')
//     ->where('id', '4')
//     ->update([
//         "alumno"=>'eloquent',
//      ]);

//     //Igual al increment
//     //->decrement("id");
    
//     //AUMENTA a los legajos menores a 4 
//     //->where('legajo', '<', '4')
//     //aumenta en 1 si no le pongo nada sino lo que le digas ej:->increment("id", 2);
//     //->increment("id");

//     //ACTUALIZA EL NOMBRE DEL ID 4
//     // ->where('id', '4')
//     // ->update([
//     //     "alumno"=>'eloquent',
//     // ]);


//     $rta = json_encode($alumnos);

//     $response->getBody()->write($rta);
//     return $response;
// });


// $app->delete('/', function (Request $request, Response $response, $args) {
//     $alumnos = Capsule::table('alumnos')
//     ->where('id', '=', '4')
//     ->delete();

//     $rta = json_encode($alumnos);

//     $response->getBody()->write($rta);
//     return $response;
// });

