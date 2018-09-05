<?php
/**
 * Created by PhpStorm.
 * User: walay
 * Date: 28.08.2018
 * Time: 20:24
 */
require ('sendMail.php');

$post = $_POST;

$dsn = "mysql:host=localhost;dbname=burger;charset=utf8";
$pdo = new PDO($dsn, 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//return print_r($post);
//die();
if (!empty($post['email'])) {

    try {
        //получаем данные
        $query = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $query->execute(array('email' => $post['email']));

        $result = $query->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $user) {
            $current_user_id = $user->id;
        }

        if ($post['payment'] == 'card') {
            $payment_card = 1;
            $cashback = 0;
        } else if ($post['payment'] == 'cashback') {
            $payment_card = 0;
            $cashback = 1;
        } else {
            $payment_card = 0;
            $cashback = 0;
        }

        if ($post['callback'] == 'on') {
            $no_callback = 1;
        } else {
            $no_callback = 0;
        }


        if (count($result) == 0) {

            $data = $pdo->prepare('INSERT INTO users(name, phone, email) VALUES(:name, :phone, :email)');
            $data->bindParam(':name', $post['name']);
            $data->bindParam(':phone', $post['phone']);
            $data->bindParam(':email', $post['email']);
            $data->execute();

            $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $query->execute(array('email' => $post['email']));
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            foreach($result as $user) {
                $current_user_id = $user->id;
            }

            $data = $pdo->prepare('INSERT INTO orders(user_id, short_change, payment_by_card, call_back, address, comment) VALUES(:user_id, :cashback, :payment_card, :no_callback, :address, :comment)');
            $data->bindParam(':user_id', $current_user_id);
            $data->bindParam(':cashback', $cashback);
            $data->bindParam(':payment_card', $payment_card);
            $data->bindParam(':no_callback', $no_callback);
            $data->bindParam(':comment', $post['comment']);
            $address = 'Улица: '.$post['street'].', Дом: '.$post['home'].', Корпус: '.$post['part'].', Квартира: '.$post['appt'].', Этаж: '.$post['floor'];
            $data->bindParam(':address', $address);
            $data->execute();

            $current_order = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
            $current_order->execute(array('user_id' => $current_user_id));
            $result = $current_order->fetchAll(PDO::FETCH_OBJ);
            foreach($result as $order) {
                $current_ord = $order->id;
            }
            $address = 'Улица: '.$post['street'].', Дом: '.$post['home'].', Корпус: '.$post['part'].', Квартира: '.$post['appt'].', Этаж: '.$post['floor'];
            sendMail($post['email'], $current_ord, $address, 1);
            return print 'Registration';

        } else {

            $data = $pdo->prepare('INSERT INTO orders(user_id, short_change, payment_by_card, call_back, address, comment) VALUES(:user_id, :cashback, :payment_card, :no_callback, :address, :comment)');
            $data->bindParam(':user_id', $current_user_id);
            $data->bindParam(':cashback', $cashback);
            $data->bindParam(':payment_card', $payment_card);
            $data->bindParam(':no_callback', $no_callback);
            $data->bindParam(':comment', $post['comment']);
            $address = 'Улица: '.$post['street'].', Дом: '.$post['home'].', Корпус: '.$post['part'].', Квартира: '.$post['appt'].', Этаж: '.$post['floor'];
            $data->bindParam(':address', $address);
            $data->execute();

            $current_order = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1');
            $current_order->execute(array('user_id' => $current_user_id));
            $result = $current_order->fetchAll(PDO::FETCH_OBJ);
            foreach($result as $order) {
                $current_order_id = $order->id;
            }
            $number_user_orders = $pdo->prepare('SELECT COUNT(id) as cid FROM orders WHERE user_id = :user_id');
            $number_user_orders->execute(array('user_id' => $current_user_id));
            $result_number_user_orders = $number_user_orders->fetchAll(PDO::FETCH_OBJ);
            foreach($result_number_user_orders as $order) {
                $number_orders = $order->cid;
            }

            sendMail($post['email'], $current_order_id, $address, $number_orders);

            return print 'Authorization';
        }


    } catch (PDOException $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
} else {
        return print 'NO email';
}
