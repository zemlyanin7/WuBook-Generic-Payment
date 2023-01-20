<?php

//Вводим данные для оплаты

define('USERNAME', 'hotel-api');
define('PASSWORD', 'passhotel!');
define('GATEWAY_URL', 'https://pay.alfabank.ru/payment/rest/');
//define('GATEWAY_URL', 'https://payment.alfabank.ru/payment/rest/');  // для всех логинов с префиксом r- используется шлюз payment.alfabank.ru

$deposit = '';
$rcode   = '';
$ok_url  = '';
$ko_url  = '';
$email   = '';

$params = array();

function gateway($method, $data) {
    $curl = curl_init(); // Инициализируем запрос
    curl_setopt_array($curl, array(
        CURLOPT_URL => GATEWAY_URL.$method, // Полный адрес метода
        CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
        CURLOPT_POST => true, // Метод POST
        CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
    ));
    $response = curl_exec($curl); // Выполняем запрос
  
    
    $response = json_decode($response, true); // Декодируем из JSON в массив
    curl_close($curl); // Закрываем соединение
    return $response;  // Возвращаем ответ
}
    $postData = file_get_contents('php://input');

    $data = urldecode($postData);

    parse_str($data, $params);

    $deposit = $params['deposit'] * 100;
    $rcode   = $params['rcode'];
    $ok_url  = $params['ok_url'];
    $ko_url  = $params['ko_url'];
    $email   = $params['email'];
    
 $data = array(
        'userName' => USERNAME,  
        'password' => PASSWORD ,
        'orderNumber' => urlencode($rcode), 
        'amount' => urlencode($deposit),  
        'failUrl' => urlencode($ko_url), 
        'returnUrl' => $ok_url   // RETURN_URL
    );
    
  $response = gateway('register.do', $data);  
  
  
  if (empty($response['orderId'])) {
    /* Возникла ошибка: */
    echo $response['errorMessage'];
} else {
    /* Успех: */
    /* Перенаправление клиента на страницу оплаты */
    echo $response['formUrl'];

}


?>
