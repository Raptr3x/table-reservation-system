<?php

if (isset($_POST['logout']) && $_POST['logout']) {
    // ajax call to logout
    session_destroy();
    echo json_encode(true);

} else if (isset($_SESSION['user_data'])) {
    // already logged in
    header('Location: /admin');
    exit();
} else if (isset($_POST["email"]) && isset($_POST["password"])) {
    // ajax login request
    if ($user_worker->login($_POST["email"], $_POST["password"])) {
        // successful login
        echo json_encode(true);
        exit();
    } else {
        // failed login
        http_response_code(401);
        echo json_encode("Email or password is incorrect.");
        exit();
    }
} else {
    echo $twig->render('admin/auth/login.html.twig', ['page' => $request_uri]);
}
?>