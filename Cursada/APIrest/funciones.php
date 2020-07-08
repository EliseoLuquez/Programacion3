<?php   

//include_once 'persona.php';


include_once 'usuario.php';

    function Leer($path, &$array)
    {
        $retorno = false;
        if(file_exists($path) && filesize($path) > 0)
        {
            $archivo = fopen($path, 'r');
            $array = fread($archivo, filesize($path));
            $cerrar = fclose($archivo);
            $array = json_decode($array, true);
            $retorno = true;
        }
        else
        {
            $array = array();
        }
        return $retorno;

    }

    function Guardar($dato, $path)
    {
        $retorno = false;
        if(Leer($path, $array))
        {
            array_push($array, $dato);
            $aux = json_encode($array, true);
        }
        else
        {
            array_push($array, $dato);
            $aux = json_encode($array, true);
        }
        $archivo = fopen($path, 'w');
        if(fwrite($archivo, $aux))
        {
            $retorno = true;
        }
        $cerrar = fclose($archivo);

        return $retorno;
    }

