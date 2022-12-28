<?php

//Вводим данные для оплаты
$userName = "user-api";
$password = "password";
$pay_url = "https://securepayments.sberbank.ru/";  //Боевой адрес
//$pay_url = "https://3dsec.sberbank.ru/"; //Тестовый адрес


// Дальше ничего не менять
$deposit = '';
$rcode   = '';
$ok_url  = '';
$ko_url  = '';
$email   = '';
$async_ok_url   = '';
$description = '';


$params = array();

$amount =  round($_POST['amount'], 2)* 100;
$rcode   = $_POST['reservation_id'];
$ok_url  = $_POST['return_ok'];
$ko_url  = $_POST['return_ko'];
$reservation_info   = json_decode($_POST['reservation_info']);
$email = $reservation_info -> {'customer'} -> {'email'};
$description = 'Бронирование ' . $rcode;



$ch = curl_init($pay_url . "payment/rest/register.do?amount=" . intval($amount) . "&currency=643&language=ru&orderNumber='" . $rcode . "'&password=" . urlencode($password) . "&userName=" . urlencode($userName) . "&returnUrl=" . $ok_url . "&failUrl=" . $ko_url . "&email=" . $email . "&dynamicCallbackUrl=" . $ok_url . "&description=" . urlencode($description));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);

$res = json_decode($res, JSON_OBJECT_AS_ARRAY);
if (empty($res['orderId'])) {
    /* Возникла ошибка: */

    $echo_array = array ( 'status' => 'ko', 'reason' => $res['errorMessage'] );
    echo json_encode($echo_array);
} else {
    /* Успех: */
    /* Перенаправление клиента на страницу оплаты */

    $echo_array = array ( 'status' => 'ok', 'link' => $res['formUrl'] );
    echo json_encode($echo_array);

}

?>
