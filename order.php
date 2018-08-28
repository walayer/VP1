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
        $current_email = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $current_email->execute(array('email' => $post['email']));

        $result = $current_email->fetchAll(PDO::FETCH_OBJ);
        foreach($result as $user) {
            $current_user = $user->id;
        }

        if ($post['payment'] == 'on') {
            $payment = 1;
        } else {
            $payment = 0;
        }
        if ($post['payment'] == 'on') {
            $callback = 1;
        } else {
            $callback = 0;
        }


        if (count($result) == 0) {

            $data = $pdo->prepare('INSERT INTO users(name, phone, email) VALUES(:name, :phone, :email)');
            $data->bindParam(':name', $post['name']);
            $data->bindParam(':phone', $post['phone']);
            $data->bindParam(':email', $post['email']);
            $data->execute();

            $current_email = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $current_email->execute(array('email' => $post['email']));
            $result = $current_email->fetchAll(PDO::FETCH_OBJ);
            foreach($result as $user) {
                $current_user = $user->id;
            }

            $data = $pdo->prepare('INSERT INTO orders(user_id, short_change, payment_by_card, call_back, comment) VALUES(:user_id, :short_change, :payment_by_card, :call_back, :comment)');
            $data->bindParam(':user_id', $current_user);
            $data->bindParam(':short_change', $payment);
            $data->bindParam(':payment_by_card', $payment);
            $data->bindParam(':call_back', $callback);
            $data->bindParam(':comment', $post['comment']);
            $data->execute();

            $current_order = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
            $current_order->execute(array('user_id' => $current_user));
            $result = $current_order->fetchAll(PDO::FETCH_OBJ);
            foreach($result as $order) {
                $current_ord = $order->id;
            }
            $address = 'Улица: '.$post['street'].', Дом: '.$post['home'].', Корпус: '.$post['part'].', Квартира: '.$post['appt'].', Этаж: '.$post['floor'];
            sendMail($post['email'], $current_ord, $address, 1);
            return print 'Registration';

        } else {

            $data = $pdo->prepare('INSERT INTO orders(user_id, short_change, payment_by_card, call_back, comment) VALUES(:user_id, :short_change, :payment_by_card, :call_back, :comment)');
            $data->bindParam(':user_id', $current_user);
            $data->bindParam(':short_change', $payment);
            $data->bindParam(':payment_by_card', $payment);
            $data->bindParam(':call_back', $callback);
            $data->bindParam(':comment', $post['comment']);
            $data->execute();

            $current_order1 = $pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1');
            $current_order1->execute(array('user_id' => $current_user));
            $result1 = $current_order1->fetchAll(PDO::FETCH_OBJ);
            foreach($result1 as $order) {
                $current_ord1 = $order->id;
            }
            $current_order2 = $pdo->prepare('SELECT COUNT(id) as cid FROM orders WHERE user_id = :user_id');
            $current_order2->execute(array('user_id' => $current_user));
            $result2 = $current_order2->fetchAll(PDO::FETCH_OBJ);
            foreach($result2 as $order) {
                $current_ord2 = $order->cid;
            }
            $address = 'Улица: '.$post['street'].', Дом: '.$post['home'].', Корпус: '.$post['part'].', Квартира: '.$post['appt'].', Этаж: '.$post['floor'];
            sendMail($post['email'], $current_ord1, $address, $current_ord2);

            return print 'Authorization';
        }


    } catch (PDOException $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
} else {
        return print 'NO email';
}

?>