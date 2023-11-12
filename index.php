<?php
session_start();
session_regenerate_id();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/models/Database.php';
require __DIR__ . '/models/User.php';
require __DIR__ . '/models/Reservation.php';
require __DIR__ . '/models/Menu.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$database = new Database;
$user = new User($database);
$reservation_worker = new Reservation($database);

$controllers_dir = "controllers/";

$routes = [
    // Landing page (public)
    '/' => 'HomeController',
    '/edit-reservation' => 'EditReservationController',

    // Admin panel (private)
    '/admin' => 'AdminHomeController',
    '/admin/menu-edit' => 'MenuController',
    '/admin/new-account' => 'NewAccountController',
    '/admin/login' => 'LoginController',
    '/admin/logout' => 'LoginController',
    '/admin/forgot-password' => 'LoginController',
];

$request_uri = rtrim($_SERVER['REQUEST_URI'], '/');

// check if the route exists
if (array_key_exists($request_uri, $routes)) {
    // include the corresponding controller
    include($controllers_dir . $routes[$request_uri] . '.php');
} else {
    http_response_code(404);
    echo $twig->render(
        'error_404.html.twig',
        ['error_text' => 'Page not found']
    );
}


