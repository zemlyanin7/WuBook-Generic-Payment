# WuBook-Generic-Payment
Тут собраны скрипты для самостоятельного использования WuBook Payment Gateway

## Альфабанк

Указать Ваш логин и пароль:
define('USERNAME', 'your_hotel-api');
define('PASSWORD', 'your_password');

## Сбербанк

По умолчанию используется ссылка для тестового окружения.

Закоментируйте $pay_url с тестовым адресом и раскоментируйте с боевым.

Укажите свой логин и пароль в переменных $userName и $password. Для доступа по АПИ к вашему логину должен быть добавлен суффикс -api.

![image](https://user-images.githubusercontent.com/47315993/113978159-45beca00-984c-11eb-932a-cb810688a0ca.png)

После чего разметите файл Sberbank.php на своем хостинге и в настройках Generic WuBook Payment gateway нужно разместить ссылку на на этот файл.

Например: http://адрессайта/sberbank.php


## CloudPayments
#### Отредактировать скрипт следующим образом: 

В переменной $publicId указать Ваш ID котрый нужно взять из личного кабинета личного кабинета CloudPayments. Пример: $publicId = 'test_api_00000000000000000000001';

В переменной $hotelName указать название Вашего отеля. Пример: $hotelName = 'Название отеля';

В переменной $pay_url указать адрес, где будет лежать скрипт. Пример: $pay_url = "https://somesite/CloudPayments.php";

В переменной  $currency указать используемую валюту. Пример: $currency= "RUB";

После чего разметите файл CloudPayments.php на своем хостинге и в настройках Generic WuBook Payment gateway нужно разместить ссылку на на этот файл.

Например: http://адрессайта/CloudPayments.php


### Настройтe Wubook следующим образом (одинаково для Сбербанк и CloudPayments):

В личном кабинете подключите платежный шлюз: WuBook Payment Gateway:

![image](https://user-images.githubusercontent.com/47315993/113978386-8fa7b000-984c-11eb-9df2-3482edea2c2b.png)

В поле ACK Url вписать путь к файлу со скриптом на Вашем хостинге:

![image](https://user-images.githubusercontent.com/47315993/113978418-99311800-984c-11eb-9c79-6c6e7ecf3ab7.png)

Загрузите изображение платежной системы 
![image](https://user-images.githubusercontent.com/51836809/123103654-e598f680-d43e-11eb-9071-2460f9284ad7.png)

Настройте оплату картой:

![image](https://user-images.githubusercontent.com/47315993/113978457-a4844380-984c-11eb-97de-555fb1ec68a6.png)


## Тинькофф
Ссылка на документацию https://www.tinkoff.ru/kassa/dev/payments/
HW007(https://innsync.ru/pay/HW007_2.php) а затем новая редакция для BM212(http://pay.innsync.by/BM212.php) там самая актуальная котороая учитывает и чеки и то что формирование токена учавствую все поля кроме Receipt и DATA.
Для настройки достаточно заполнить TerminalKey и PASSWORD, по желанию можно поменять назначение платежа и в HW007 убрал поле в чеке Ean13 (оно вроде как необязательное)

      Коллеги, согласно документации (https://www.tinkoff.ru/kassa/dev/payments/#section/Podpis-zaprosa) объекты Receipt и DATA не участвуют в формировании подписи запроса.
      Пожалуйста, исключите их из генерации токена.
      
      Проверка шифрования осуществляется следующим способом: если формируемый на вашей стороне токен совпадает с токеном, который вы получаете при передаче этих же параметров на странице https://tokentcs.web.app/, значит логика работы шифрования на вашей стороне реализована корректно.
      
      Прикладываю пример формирования запроса методом Init.
      Параметры вашего запроса, которые участвуют в генерации токена:
      "Amount": 1000,
      "Description": "Глэмпинг Vazuza Love. Оплата за бронирование \u21161708549700",
      "OrderId": "1708549700",
      "TerminalKey": "1680524992278",
      "SuccessURL": "https://wubook.net/wbkd/wbk/payed/jygc442v83wx1ewo5f3rzbf77hfzkc/?wbSessionId=d42bda5782185c359214a8517e8d8eb7",
      "FailURL": "https://wubook.net/wbkd/wbk/payed/cancel/jygc442v83wx1ewo5f3rzbf77hfzkc/?wbSessionId=d42bda5782185c359214a8517e8d8eb7"
      
      Подставляем пароль от терминала: *************
      Нажимаем Get Token Data - мы получим следующий Token (SHA):
      61f9a7fb5a1773ae2784b9339773643c48d6f9226ebbd61fa2fde2de9f90c9d7
      
      Тогда все тело запроса, которое мы будем передавать в запросе Init будет выглядеть так:
     --POST  https://securepay.tinkoff.ru/v2/Init/
     --Body^ 
      {
          "Amount": 1000,
          "Description": "Глэмпинг Vazuza Love. Оплата за бронирование №1708549700",
          "OrderId": "1708549700",
          "TerminalKey": "1680524992278",
          "SuccessURL": "https://wubook.net/wbkd/wbk/payed/jygc442v83wx1ewo5f3rzbf77hfzkc/?wbSessionId=d42bda5782185c359214a8517e8d8eb7",
          "FailURL": "https://wubook.net/wbkd/wbk/payed/cancel/jygc442v83wx1ewo5f3rzbf77hfzkc/?wbSessionId=d42bda5782185c359214a8517e8d8eb7",
          "Token": "61f9a7fb5a1773ae2784b9339773643c48d6f9226ebbd61fa2fde2de9f90c9d7",
          "DATA": {
              "Email": "purple@innsync.ru"
          },
          "Receipt": {
              "Email": "purple@innsync.ru",
              "Taxation": "usn_income",
              "Items": [
                  {
                      "Name": "Глэмпинг Vazuza Love. Оплата за бронирование \u21161708549700",
                      "Price": 1000,
                      "Quantity": 1,
                      "Amount": 1000,
                      "Tax": "none",
                      "Ean13": "303130323930303030630333435"
                  }
              ]
          }
      }

