<?php

global $servername, $username, $password, $dbname;

$dev_env = 'remote';

switch ($dev_env) {
    case 'local':
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "lunibo";
        break;
    case 'raspberry':
        $servername = "192.168.0.220";
        $username = "pi";
        $password = "raspberry";
        $dbname = "lunibo";
        break;
    case 'remote':
        $servername = "e116549-phpmyadmin.services.easyname.eu";
        $username = "u180980db3";
        $password = "8j6n9dsm55f";
        $dbname = "u180980db3";
        break;
}

?>