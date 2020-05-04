<?php   



include_once 'clases/usuario.php';

    function LeerUsuario($path, &$array)
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

    function GuardarUsuario($dato, $path)
    {
        $retorno = false;
        if(LeerUsuario($path, $array))
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

    function LeerPizza($path, &$array)
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

    function GuardarPizza($dato, $path)
    {
        $retorno = false;
        if(LeerPizza($path, $array))
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


    function ReescribirPizza($dato, $path)
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

    function LeerVenta($path, &$array)
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

    
    function GuardarVenta($dato, $path)
    {
        $retorno = false;
        if(LeerVenta($path, $array))
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


