<?php
include './src/config.php';
include './src/functions.php';
include './src/class.burger.php';
include './src/class.db.php';
/**
 * Внизу вы найдете форму заказа, напишите скрипт, обрабатывающий эту форму. Скрипт должен:

Проверить, существует ли уже пользователь с таким email, если нет - создать его, если да - увеличить число заказов по этому email. Двух пользователей с одинаковым email быть не может.

Сохранить данные заказа - id пользователя, сделавшего заказ, дату заказа, полный адрес клиента.

Скрипт должен вывести пользователю:

Спасибо, ваш заказ будет доставлен по адресу: “тут адрес клиента”
Номер вашего заказа: #ID
Это ваш n-й заказ!
Где ID - уникальный идентификатор только что созданного заказа n - общий кол-во заказов, который сделал пользователь с этим email включая текущий
 */

$burger = new Burger();

$email = $_POST['email'];
$name = $_POST['name'];

$addressFields = ['phone', 'street', 'home', 'part', 'appt', 'floor'];
$address = '';
foreach ($_POST as $field => $value)
    if ($value && in_array($field, $addressFields)) {
        $address .= $value . ',';
    }
$data = ['address' => $address];

$user = $burger->getUserByEmail($email);

if ($user) {
    $userId = $user['id'];
    $burger->incOrders($user['id']);
    $orderNumber = $user['orders'];
} else {
    $userId = $burger->createUser($email, $name);
}

$orderID = $burger->addOrder($userId, $data);

echo "Спасибо, ваш заказ будет доставлен по адресу: $address<br>
Номер вашего заказа: #$orderID <br>
Это ваш $orderNumber-й заказ!";


