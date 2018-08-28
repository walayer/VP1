<pre>
<?php
/**
 * Created by PhpStorm.
 * User: walay
 * Date: 27.08.2018
 * Time: 22:31
 */

$dsn = "mysql:host=localhost;dbname=burger;charset=utf8";
$pdo = new PDO($dsn, 'root');
$prepare = $pdo->prepare('SELECT * FROM users where id > :uslovie1');

$id = 0;
$prepare->execute(['uslovie1' => $id]);
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

foreach($data as $users) {

    echo '<tr align="left">';
        echo '<td>';
            echo $number;
        echo '</td>';
        echo '<td>';
            echo $users->id;
        echo '</td>';
        echo '<td>';
            echo $users->email;
        echo '</td>';
        echo '<td>';
            echo $users->name;
        echo '</td>';
        echo '<td>';
            echo $users->phone;
        echo '</td>';
    echo '</tr>';
    $number++;

}

echo '</table>';

echo PHP_EOL;
echo 'Список всех заказов:'.PHP_EOL;
echo PHP_EOL;

$prepare = $pdo->prepare('SELECT * FROM orders where id > :uslovie1');

$id = 0;
$prepare->execute(['uslovie1' => $id]);
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
        echo 'Перезвонить';
    echo '</td>';
    echo '<td>';
        echo 'Комментарий';
    echo '</td>';
echo '</tr>';

foreach($data as $orders) {
    echo '<tr align="left">';
        echo '<td>';
            echo $number;
        echo '</td>';
        echo '<td>';
            echo $orders->id;
        echo '</td>';
        echo '<td>';
            echo $orders->user_id;
        echo '</td>';
        echo '<td>';
            if($orders->short_change == 1) {
                echo 'Да';
            } else {
                echo 'Нет';
            }
        echo '</td>';
        echo '<td>';
            if($orders->payment_by_card == 1) {
                echo 'Да';
            } else {
                echo 'Нет';
            }
        echo '</td>';
        echo '<td>';
            if($orders->call_back == 1) {
                echo 'Да';
            } else {
                echo 'Нет';
            }
        echo '</td>';
        echo '<td>';
            echo $orders->comment;
        echo '</td>';
        echo '</tr>';
    $number++;

}

echo '</table>';

?>
</pre>
