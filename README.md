# WuBook-Generic-Payment
Тут собраны скрипты для самостоятельного использования WuBook Payment Gateway

## Сбербанк

По умолчанию используется ссылка для тестового окружения.

Закоментируйте $pay_url с тестовым адресом и раскоментируйте с боевым.

Укажите свой логин и пароль в переменных $userName и $password. Для доступа по АПИ к вашему логину должен быть добавлен суффикс -api.

![image](https://user-images.githubusercontent.com/47315993/113978159-45beca00-984c-11eb-932a-cb810688a0ca.png)

После чего разметите файл Sberbank.php на своем хостинге и в настройках Generic WuBook Payment gateway нужно разместить ссылку на на этот файл.

Например: http://адрессайта/sberbank.php


## CloudPayments
# Отредактировать скрипт следующим образом: 

В переменной $publicId указать Ваш ID котрый нужно взять из личного кабинета личного кабинета CloudPayments. Пример: $publicId = 'test_api_00000000000000000000001';

В переменной $hotelName указать название Вашего отеля. Пример: $hotelName = 'Название отеля';

В переменной $pay_url указать адрес, где будет лежать скрипт. Пример: $pay_url = "https://somesite/CloudPayments.php";

В переменной  $currency указать используемую валюту. Пример: $currency= "RUB";

После чего разметите файл CloudPayments.php на своем хостинге и в настройках Generic WuBook Payment gateway нужно разместить ссылку на на этот файл.

Например: http://адрессайта/CloudPayments.php


# Настройтe Wubook следующим образом (одинаково для Сбербанк и CloudPayments):

В личном кабинете подключите платежный шлюз: WuBook Payment Gateway:

![image](https://user-images.githubusercontent.com/47315993/113978386-8fa7b000-984c-11eb-9df2-3482edea2c2b.png)

В поле ACK Url вписать путь к файлу со скриптом на Вашем хостинге:

![image](https://user-images.githubusercontent.com/47315993/113978418-99311800-984c-11eb-9c79-6c6e7ecf3ab7.png)

Настройте оплату картой:

![image](https://user-images.githubusercontent.com/47315993/113978457-a4844380-984c-11eb-97de-555fb1ec68a6.png)

