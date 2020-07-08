<?php

    require 'saludar.php'; 

    function saludarEspanol($nombrer = "NN")
    {
        $persona = new Persona("Eliseo");
        
        echo $persona->saludar();
    }


    
?>