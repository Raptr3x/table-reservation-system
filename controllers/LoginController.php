<?php


if (isset($_POST['logout']) && $_POST['logout']) {
    session_destroy();
    header('Location: /admin/login');
    exit();
} else if (isset($_POST["email"]) && isset($_POST["password"])) {
    if ($user->login($_POST["email"], $_POST["password"])) {
        header("Location: /admin");
        exit();
    } else {
        $_POST = array();
        echo $twig->render('admin/auth/login.html.twig', ['page' => $request_uri, 'error_text' => 'Email or password is incorrect.']);
    }
}

echo $twig->render('admin/auth/login.html.twig', ['page' => $request_uri]);

?>