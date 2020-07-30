<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Firebase\JWT\JWT;

require "./vendor/autoload.php";
require "./Clases/Barbijo.php";
require "./Clases/Usuario.php";
require_once './Clases/AccesoDatos.php';
require './Clases/mw.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->post("/usuarios",\Usuario::class . "::AgregoUno")->add(
                        \MW::class . ":VerficarEnBDCorreoYClave")->add(
                        \MW::class . ":VerificarSeteoCorreoYClave")->add(
                        \MW::class . "::VerificarEnBdCorreo");

$app->get("[/]",\Usuario::class . "::TraerTodos");

$app->post("[/]",\Barbijo::class . "::AgregoUno");

$app->get("/barbijos",\Barbijo::class . "::TraerTodos");

$app->post("/login",\Usuario::class . "::Login")->add(
                    \MW::class . ":VerficarEnBDCorreoYClave")->add(
                    \MW::class . "::VerificarVaciosCorreoYClave")->add(
                    \MW::class . ":VerificarSeteoCorreoYClave");

$app->get("/login",\Usuario::class . "::VerificarToken");

$app->delete("[/]",\Barbijo::class . "::BorrarUno");

$app->put("[/]",\Barbijo::class . "::ModificarUno");     
                
$app->get("/pdf",\Usuario::class ."::GenerarPDF");



$app->run();












?>