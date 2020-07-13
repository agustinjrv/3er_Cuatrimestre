<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "../vendor/autoload.php";
require "./fabrica.php";
require_once './AccesoDatos.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->group('/Fabrica', function () {   

    $this->get('/', \Fabrica::class . ':TraerTodos');
    $this->get('/{dni}', \Fabrica::class . ':TraerUno');
    $this->post('/', \Fabrica::class . ':AgregarUno');
    $this->put('/', \Fabrica::class . ':ModificarUno');
    $this->delete('/{legajo}', \Fabrica::class . ':BorrarUno');

});


$app->run();




?>