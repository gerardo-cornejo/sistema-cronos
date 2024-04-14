<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'UsuarioController::login');
$routes->get('/salir', 'UsuarioController::logout', ["filter" => "session_filter"]);
$routes->get('/equipos', 'PanelController::equipos', ["filter" => "session_filter"]);
$routes->get('/usuarios', 'PanelController::usuarios', ["filter" => "session_filter"]);
$routes->get('/equipos/buscar', 'PanelController::buscar_equipo', ["filter" => "session_filter"]);
$routes->get('/equipos/buscar/(:any)', 'EquipoController::buscado/$1', ["filter" => "session_filter"]);
$routes->get('/clientes', 'PanelController::clientes', ["filter" => "session_filter"]);
$routes->get('/panel', 'PanelController::panel', ["filter" => "session_filter"]);
$routes->get('/', 'PanelController::panel', ["filter" => "session_filter"]);
$routes->get('/diagnostico/(:any)', 'PanelController::diagnostico/$1', ["filter" => "session_filter"]);

$routes->group("api", function (RouteCollection $routes) {
    $routes->post("cliente/eliminar", "ClienteController::eliminar", ["filter" => "api_session_filter"]);
    $routes->post("cliente/nuevo", "ClienteController::nuevo", ["filter" => "api_session_filter"]);
    $routes->post("cliente/editar", "ClienteController::editar", ["filter" => "api_session_filter"]);
    $routes->get("cliente/listar", "ClienteController::listar", ["filter" => "api_session_filter"]);

    $routes->post("equipo/eliminar", "EquipoController::eliminar", ["filter" => "api_session_filter"]);
    $routes->post("equipo/nuevo", "EquipoController::nuevo", ["filter" => "api_session_filter"]);
    $routes->post("equipo/editar", "EquipoController::editar", ["filter" => "api_session_filter"]);
    $routes->get("equipo/listar", "EquipoController::listar", ["filter" => "api_session_filter"]);

    $routes->post('usuario/login', 'UsuarioController::login');
    $routes->get("usuario/listar", "UsuarioController::listar", ["filter" => "api_session_filter"]);
    $routes->post("usuario/nuevo", "UsuarioController::nuevo", ["filter" => "api_session_filter"]);
    $routes->post("usuario/editar", "UsuarioController::editar", ["filter" => "api_session_filter"]);
    $routes->post("usuario/eliminar", "UsuarioController::eliminar", ["filter" => "api_session_filter"]);

    $routes->get("diagnostico/listar/(:any)", "DiagnosticoController::listar/$1", ["filter" => "api_session_filter"]);
    $routes->post("diagnostico/eliminar", "DiagnosticoController::eliminar", ["filter" => "api_session_filter"]);
    $routes->post("diagnostico/guardar", "DiagnosticoController::guardar", ["filter" => "api_session_filter"]);
    $routes->post("diagnostico/editar", "DiagnosticoController::editar", ["filter" => "api_session_filter"]);
});
