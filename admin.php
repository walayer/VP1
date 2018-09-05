<?php
/**
 * Created by PhpStorm.
 * User: walay
 * Date: 27.08.2018
 * Time: 22:31
 */

echo '<pre>';

$dsn = "mysql:host=localhost;dbname=burger;charset=utf8";
$pdo = new PDO($dsn, 'root');
$prepare = $pdo->prepare('SELECT * FROM users where id > :user_id');

$id = 0;
$prepare->execute(['user_id' => $id]);
$data = $prepare ->fetchAll(PDO::FETCH_OBJ);
echo 'Список всех пользователей:'.PHP_EOL;
echo PHP_EOL;
$number = 1;

echo '<table border="1">';

echo '<tr align="center">';
    echo '<td>';
        echo '№';
    echo '</td>';
    echo '<td>';
        echo 'ID';
    echo '</td>';
    echo '<td>';
        echo 'Email';
    echo '</td>';
    echo '<td>';
        echo 'Имя';
    echo '</td>';
    echo '<td>';
        echo 'Телефон';
    echo '</td>';
echo '</tr>';

foreach($data as $user) {

    echo '<tr align="left">';
        echo '<td>';
            echo $number;
        echo '</td>';
        echo '<td>';
            echo $user->id;
        echo '</td>';
        echo '<td>';
            echo $user->email;
        echo '</td>';
        echo '<td>';
            echo $user->name;
        echo '</td>';
        echo '<td>';
            echo $user->phone;
        echo '</td>';
    echo '</tr>';
    $number++;

}

echo '</table>';

echo PHP_EOL;
echo 'Список всех заказов:'.PHP_EOL;
echo PHP_EOL;

$prepare = $pdo->prepare('SELECT * FROM orders where id > :order_id');

$id = 0;
$prepare->execute(['order_id' => $id]);
$data = $prepare ->fetchAll(PDO::FETCH_OBJ);
$number = 1;

echo '<table border="1">';

echo '<tr align="center">';
    echo '<td>';
        echo '№';
    echo '</td>';
    echo '<td>';
        echo 'ID';
    echo '</td>';
    echo '<td>';
        echo 'User ID';
    echo '</td>';
    echo '<td>';
        echo 'Нужна ли сдача';
    echo '</td>';
    echo '<td>';
        echo 'Оплата картой';
    echo '</td>';
    echo '<td>';
        echo 'Не перезванивать';
    echo '</td>';
    echo '<td>';
        echo 'Адрес';
    echo '</td>';
    echo '<td>';
        echo 'Комментарий';
    echo '</td>';
echo '</tr>';

foreach($data as $order) {
    echo '<tr align="left">';
        echo '<td>';
            echo $number;
        echo '</td>';
        echo '<td>';
            echo $order->id;
        echo '</td>';
        echo '<td>';
            echo $order->user_id;
        echo '</td>';
        echo '<td>';
            if($order->short_change == 1) {
                echo 'Да';
            } else {
                echo 'Нет';
            }
        echo '</td>';
        echo '<td>';
            if($order->payment_by_card == 1) {
                echo 'Да';
            } else {
                echo 'Нет';
            }
        echo '</td>';
        echo '<td>';
            if($order->call_back == 1) {
                echo 'Да';
            } else {
                echo 'Нет';
            }
        echo '</td>';
        echo '<td>';
            echo $order->address;
        echo '</td>';
        echo '<td>';
            echo $order->comment;
        echo '</td>';
        echo '</tr>';
    $number++;

}

echo '</table>';

echo '</pre>';
