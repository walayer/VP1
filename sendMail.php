<?php
/**
 * Created by PhpStorm.
 * User: walay
 * Date: 27.08.2018
 * Time: 22:36
 */

function sendMail($email, $idOrder, $address, $count) {
    $subject = 'заказ №'.$idOrder;
    if ($count == 1) {
        $messageCount = 'Спасибо - это ваш первый заказ';
    } else {
        $messageCount = 'Спасибо! Это уже '.$count.' заказ';
    }
    $message = "Ваш заказ будет доставлен по адресу: ".$address."\n
Содержимое заказа: DarkBeefBurger за 500 рублей, 1 шт\n
".$messageCount;
    mail($email, $subject, $message);
}

?>