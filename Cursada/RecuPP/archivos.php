<?php   


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



    function Imagen1(&$foto1, $pathimagen, $id)
    {
        $extencionTmp = explode("/", $_FILES["foto"]["type"][0]);
        if ($extencionTmp[0] != "image") {
            $pathimagen = '';
            return false;
        }
        $archivoTmp = $_FILES["foto"]["tmp_name"][0];
        $foto1 = $pathimagen. $id . "foto1." . $extencionTmp[1];
        return move_uploaded_file($archivoTmp, $foto1);
    }

    function Imagen2(&$foto2, $pathimagen, $id)
    {
        $extencionTmp = explode("/", $_FILES["foto"]["type"][1]);
        if ($extencionTmp[0] != "image") {
            $pathimagen = '';
            return false;
        }
        $archivoTmp = $_FILES["foto"]["tmp_name"][1];
        $foto2 = $pathimagen. $id . "foto2." . $extencionTmp[1];
        return move_uploaded_file($archivoTmp, $foto2);
    }



    