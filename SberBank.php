<?php

//Вводим данные для оплаты
$userName = 'user-api';
$password = 'password';
//$pay_url = "https://securepayments.sberbank.ru/";  //Боевой адрес
$pay_url = "https://3dsec.sberbank.ru/"; //Тестовый адрес


// Дальше ничего не менять
$deposit = '';
$rcode   = '';
$ok_url  = '';
$ko_url  = '';
$email   = '';

$params = array();

$postData = file_get_contents('php://input');

$data = urldecode($postData);

parse_str($data, $params);

$deposit = $params['deposit'] * 100;
$rcode   = $params['rcode'];
$ok_url  = $params['ok_url'];
$ko_url  = $params['ko_url'];
$email   = $params['email'];


$ch = curl_init($pay_url . "payment/rest/register.do?amount=" . intval($deposit) . "&currency=643&language=ru&orderNumber='" . $rcode . "'&password=" . $password . "&userName=" . $userName . "&returnUrl=" . $ok_url . "&failUrl=" . $ko_url . "&email=" . $email);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);

$res = json_decode($res, JSON_OBJECT_AS_ARRAY);
if (empty($res['orderId'])) {
    /* Возникла ошибка: */
    echo $res['errorMessage'];
} else {
    /* Успех: */
    /* Перенаправление клиента на страницу оплаты */
    echo $res['formUrl'];

}

?>
