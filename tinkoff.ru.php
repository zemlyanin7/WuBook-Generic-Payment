<?php 
//Вводим данные для оплаты
define('TerminalKey', '1673601934681');  // terminal key выдает банк
define('PASSWORD', 'uc5773t11kn57hoj');  // secret key выдает банк
define('HotelName', 'Отель "ТЕСТ". Оплата за бронирование №'); // Назначение платежа (текстовка)

//define('GATEWAY_URL', 'https://securepay.tinkoff.ru/v2/Init');
define('GATEWAY_URL', 'https://securepay.tinkoff.ru/v2/');  // затем добавляется к строке метод
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
        CURLOPT_POSTFIELDS => $data, // Данные в запросе
        CURLOPT_HTTPHEADER => array('Content-Type: application/json' )
    ));
    $response = curl_exec($curl); // Выполняем запрос
    
    $response = json_decode($response, true); // Декодируем из JSON в массив
    curl_close($curl); // Закрываем соединение
    return $response;  // Возвращаем ответ
}


  $postData = file_get_contents('php://input');
  $data = urldecode($postData);
  parse_str($data, $params);

  $Amount      = $params['deposit'] * 100;
  $OrderId     = $params['rcode'];
  $ok_url      = $params['ok_url'];
  $ko_url      = $params['ko_url'];
  $Email       = $params['email'];
  $Description = HotelName . $OrderId;
  //Кодируем  строку для получения хэша
  $text=$Amount . $Description . $OrderId . PASSWORD . TerminalKey;
  $Token = hash('sha256', $text);
    
  $data = array(
    "Amount"      => $Amount,
    "Description" => $Description,
    "OrderId"     => $OrderId,
    "TerminalKey" => TerminalKey,
    "DATA"        => array ("Email" => $Email),
    "Token"       => $Token,
    "SuccessURL"  => $ok_url,
    "FailURL"     => $ko_url );
    
  $response = gateway('Init', json_encode($data, JSON_UNESCAPED_UNICODE ));  
 
  if (($response['ErrorCode']) <> 0 ) {
    /* Возникла ошибка: */
    echo $response['Details'];
} else {
    /* Успех: */
    /* Перенаправление клиента на страницу оплаты */
    echo $response['PaymentURL'];
}

?>