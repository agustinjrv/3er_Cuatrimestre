<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Firebase\JWT\JWT;

require "./vendor/autoload.php";
require "./Clases/Media.php";
require "./Clases/Usuario.php";
require_once './Clases/AccesoDatos.php';
require './Clases/mw.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->post("[/]",\Media::class . "::AgregoUno");

$app->get("/medias",\Media::class . "::TraerTodos");

$app->post("/usuarios",\Usuario::class . "::AgregoUno");

$app->get("[/]",\Usuario::class . "::TraerTodos");

$app->post("/login",\Usuario::class . "::Login")->add(
                    \MW::class . ":VerficarEnBDCorreoYClave")->add(
                    \MW::class . "::VerificarVaciosCorreoYClave")->add(
                    \MW::class . ":VerificarSeteoCorreoYClave");

$app->get("/login",\Usuario::class . "::VerificarToken");

$app->delete("[/]",\Media::class . "::BorrarUno")->add(
                   \MW::class ."::EsPropietario")->add(
                   \MW::class ."::VerificarToken");

$app->put("[/]",\Media::class . "::ModificarUno")->add(
                \MW::class ."::EsPropietario")->add(
                \MW::class .":VerificarToken");       
                
                
$app->group("/listados",function(){

    $this->get("[/]",\Media::class . "::TraerTodos")->add(
                     \MW::class . ":FiltroEncargado"
    );

    $this->
    



});



$app->run();












?>