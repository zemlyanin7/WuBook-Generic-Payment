<?php

//Вводим данные для оплаты
$userName = "user-api";
$password = "password";

$PROMOuserName = "user-api";
$PROMOpassword = "password";
//$pay_url = "https://securepayments.sberbank.ru/";  //Боевой адрес
$pay_url = "https://3dsec.sberbank.ru/"; //Тестовый адрес


// Тут нужно сделать список ID тарифов которым должен отправлятся оплата через Promo шлюз (1234, 123455) 
$PromoList = array();

// Дальше ничего не менять
$deposit = '';
$rcode   = '';
$ok_url  = '';
$ko_url  = '';
$email   = '';
$async_ok_url   = '';

$params = array();

$postData = file_get_contents('php://input');

$data = urldecode($postData);

parse_str($data, $params);

$deposit = $params['deposit'] * 100;
$rcode   = $params['rcode'];
$ok_url  = $params['ok_url'];
$ko_url  = $params['ko_url'];
$email   = $params['email'];
$async_ok_url = $params['async_ok_url'];
$items = json_decode($params['async_ok_url']);


foreach ($PromoList as $value) {
    if ($value == $items->{'special_offer_id'}) {
        $userName = $PROMOuserName;
        $password = $PROMOpassword;
    };
};

$ch = curl_init($pay_url . "payment/rest/register.do?amount=" . intval($deposit) . "&currency=643&language=ru&orderNumber='" . $rcode . "'&password=" . urlencode($password) . "&userName=" . urlencode($userName) . "&returnUrl=" . $ok_url . "&failUrl=" . $ko_url . "&email=" . $email . "&dynamicCallbackUrl=" . $async_ok_url . "&description=" . $description);

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

};

?>