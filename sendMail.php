<?php
/**
 * Created by PhpStorm.
 * User: walay
 * Date: 27.08.2018
 * Time: 22:36
 */

function sendMail($email, $id_order, $address, $count) {
    $subject = 'заказ №'.$id_order;
    if ($count == 1) {
        $message_count = 'Спасибо - это ваш первый заказ';
    } else {
        $message_count = 'Спасибо! Это уже '.$count.' заказ';
    }
    $message = "Ваш заказ будет доставлен по адресу: ".$address."\n
Содержимое заказа: DarkBeefBurger за 500 рублей, 1 шт\n
".$message_count;
    mail($email, $subject, $message);
}
