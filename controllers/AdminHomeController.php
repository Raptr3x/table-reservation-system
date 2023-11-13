<?php

$all_reservations = $reservation_worker->getAllReservations();

echo $twig->render('admin/panel/home.html.twig', ['page' => $request_uri, 'all_reservations' => $all_reservations]);


?>