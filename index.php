<?php
session_start();
session_regenerate_id();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/models/Database.php';
require __DIR__ . '/models/User.php';
require __DIR__ . '/models/Reservation.php';
require __DIR__ . '/models/Menu.php';
require __DIR__ . '/models/Table.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$database_worker = new Database;
$user_worker = new User($database_worker);
$reservation_worker = new Reservation($database_worker);
$table_worker = new Table($database_worker);

$controllers_dir = "controllers/";

$public_routes = [
    // Landing page (public)
    '/' => 'HomeController',
    '/edit-reservation' => 'UserEditReservationController',
];

$admin_routes = [
    // Admin panel (private)
    '/admin' => 'AdminHomeController',
    '/admin/reservation-edit' => 'EditReservationController',
    '/admin/menu-edit' => 'MenuController',
    '/admin/new-account' => 'NewAccountController',
    '/admin/login' => 'LoginController',
    '/admin/logout' => 'LoginController',
    '/admin/forgot-password' => 'LoginController',
];

$request_uri = preg_replace('/[[:digit:]]/','', $_SERVER['REQUEST_URI']);
$request_uri = rtrim($request_uri, '/');

// check if the route exists
if (array_key_exists($request_uri, $public_routes)) {
    // include the corresponding controller
    include($controllers_dir . $public_routes[$request_uri] . '.php');
} else if(array_key_exists($request_uri, $admin_routes) && $user_worker->isUserLoggedIn()) {
    include($controllers_dir . $admin_routes[$request_uri] . '.php');
} else {
    http_response_code(404);
    echo $twig->render(
        'error_404.html.twig',
        ['error_text' => 'Page not found']
    );
}


