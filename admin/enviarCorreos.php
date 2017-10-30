<?php
    ini_set('display_errors', 1);
    require("../PHPMailer/PHPMailerAutoload.php");
    require("lib/class/correo.class.php");
    require("lib/conecciones.php");

    $fcMail = new correo();
    $correos = $fcMail->getMasivos();

    foreach ($correos['datos'] as $correo) {
        $datos_enviar = array(
            'destino' => $correo['destino'],
            'Subject' =>  $correo['titulo'],
            'body' => $correo['cuerpo'],
            'de' => $correo['de'],
            'FromName' => $correo['nombre']
        );
        $enviado = $fcMail->enviar($datos_enviar);
        if ($enviado==1) {
            $fcMail->setEstadoMasivo(1,$correo['documento']);
        }

    }