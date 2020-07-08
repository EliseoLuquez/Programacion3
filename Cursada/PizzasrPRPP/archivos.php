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


    function Img($path, $destino)
    {
                // Cargar la estampa y la foto para aplicarle la marca de agua
        $im = imagecreatefromjpeg('imagenes/'.$path);

        // Primero crearemos nuestra imagen de la estampa manualmente desde GD
        $estampa = imagecreatetruecolor(100, 70);
        imagefilledrectangle($estampa, 0, 0, 99, 69, 0x0000FF);
        imagefilledrectangle($estampa, 9, 9, 90, 60, 0xFFFFFF);
        $im = imagecreatefromjpeg($path);
        imagestring($estampa, 5, 20, 20, 'Eliseo L', 0x0000FF);
        imagestring($estampa, 3, 20, 40, '(c) 2020', 0x0000FF);

        // Establecer los márgenes para la estampa y obtener el alto/ancho de la imagen de la estampa
        $margen_dcho = 10;
        $margen_inf = 10;
        $sx = imagesx($estampa);
        $sy = imagesy($estampa);

        // Fusionar la estampa con nuestra foto con una opacidad del 50%
        imagecopymerge($im, $estampa, imagesx($im) - $sx - $margen_dcho, imagesy($im) - $sy - $margen_inf, 0, 0, imagesx($estampa), imagesy($estampa), 50);

        // Guardar la imagen en un archivo y liberar memoria
        imagepng($im, $destino);
        imagedestroy($im);
    }


    function Imagen1(&$foto1, $pathimagen, $id)
    {
        $extencionTmp = explode("/", $_FILES["foto1"]["type"]);
        if ($extencionTmp[0] != "image") {
            $pathimagen = '';
            return false;
        }
        $archivoTmp = $_FILES["foto1"]["tmp_name"];
        $foto1 = $pathimagen. $id . "foto1." . $extencionTmp[1];
        return move_uploaded_file($archivoTmp, $foto1);
    }

    function Imagen2(&$foto2, $pathimagen, $id)
    {
        $extencionTmp = explode("/", $_FILES["foto2"]["type"]);
        if ($extencionTmp[0] != "image") {
            $pathimagen = '';
            return false;
        }
        $archivoTmp = $_FILES["foto2"]["tmp_name"];
        $foto2 = $pathimagen. $id . "foto2." . $extencionTmp[1];
        return move_uploaded_file($archivoTmp, $foto2);
    }


    function BackupImg1(&$foto1,$pathimagen,$pathBackup)
    {
        $retorno = false;

        $extencionTmp = explode("/", $_FILES["foto2"]["type"]);
        
        if ($extencionTmp[0] != "image") {
            $pathimagen = '';
            return $retorno;
        }
        else
        {
            $archivoTmp = $_FILES["foto1"]["tmp_name"];
            $foto1 = $pathimagen. $_POST["id"] . "foto1." . $extencionTmp[1];
            $backupName = $pathBackup.$_POST["id"] . "foto1." . $extencionTmp[1];
            rename($foto1,$backupName);
            $retorno = move_uploaded_file($archivoTmp, $foto1);
        }
        return $retorno;
    }



    function BackupImg2(&$foto2,$pathimagen,$pathBackup)
    {
        $retorno = false;

        $extencionTmp = explode("/", $_FILES["foto2"]["type"]);
        
        if ($extencionTmp[0] != "image") {
            $pathimagen = '';
            return $retorno;
        }
        else
        {
            $archivoTmp = $_FILES["foto2"]["tmp_name"];
            $foto2 = $pathimagen. $_POST["id"] . "foto2." . $extencionTmp[1];
            $backupName = $pathBackup.$_POST["id"] . "foto2." . $extencionTmp[1];
            rename($foto2,$backupName);
            $retorno = move_uploaded_file($archivoTmp, $foto2);
        }
        return $retorno;
    }

    