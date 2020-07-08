<?php   



include_once 'Clases/usuario.php';

    function LeerTxt($path, &$array)
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

    function GuardarTxt($dato, $path)
    {
        $retorno = false;
        if(LeerTxt($path, $array))
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

    function LeerJson($path, &$array)
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

    function GuardarJson($dato, $path)
    {
        $retorno = false;
        if(LeerJson($path, $array))
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


    function ReescribirJson($dato, $path)
    {
        $retorno = false;
        $archivo = fopen($path, 'w');
        if(fwrite($archivo, json_encode($dato, true)))
        {
            $retorno = true;
        }
        $cerrar = fclose($archivo);
        return $retorno;
    }

    function GuardarSerializado($dato, $path)
    {
        $retorno = false;
        $array='';
        if(Leerserializado($path, $array))
        {
            array_push($array, $dato);
            $aux = serialize($array);
        }
        else
        {
            array_push($array, $dato);
            $aux = serialize($array);
        }
        $aux = serialize($dato). '/';
        $archivo = fopen($path, 'a+');
        if(fwrite($archivo, $aux))
        {
            $retorno = true;
        }
        $cerrar = fclose($archivo);

        return $retorno;
    }

    function Leerserializado($path, &$array)
    {
        $retorno = false;
        if(file_exists($path) && filesize($path) > 0)
        {
            $archivo = fopen($path, 'r');
            $array = fread($archivo, filesize($path));

            $aux = explode('/', $array);
            $array = array();
            foreach ($aux as $key)
            {
                $venta = unserialize($key);
                if($venta)
                {
                    array_push($array, $venta);
                }
            }
            $retorno = true; 
            $cerrar = fclose($archivo);;
        }
        else
        {
            $retorno = array();
        }
        
        return $retorno;

    }


