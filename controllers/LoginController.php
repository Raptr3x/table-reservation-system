<?php

if (isset($_POST["email"]) && isset($_POST["password"])) {
    if ($user->login($_POST["email"], $_POST["password"])) {
        header("/admin");
        exit();
    } else {
        $_POST = array();
        echo $twig->render('admin/auth/login.html.twig', ['page' => $request_uri, 'error_text' => 'Email or password is incorrect.']);
    }
}

echo $twig->render('admin/auth/login.html.twig', ['page' => $request_uri]);

?>