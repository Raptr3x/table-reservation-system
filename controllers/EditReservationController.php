<?php


$reservation = $reservation_worker->getReservation(str_replace('/admin/reservation-edit/', '', $_SERVER['REQUEST_URI']));

echo $twig->render('admin/panel/edit_reservation.html.twig', ['page' => $request_uri, 'reservation'=>$reservation]);

?>