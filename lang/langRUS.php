<?php

 require_once 'lang.php';

class OBLang extends BaseLang
{
    var $main = "Главная";
    var $Nr   = "Нр";
    var $Nimetus  = "Название";
    var $Kaubad = "Товары";
    var $Vaata = "Показать";
    var $Tyhjenda = "Опустошить";
    var $Kustuta = "Удалить";
    var $Kopeeri = "Копировать";
    var $vaata = "показать";
    var $tyhjenda = "опустошить";
    var $kustuta = "удалить";
    var $kopeeri = "копировать";
    var $Lisa = "Добавить";
    var $Kood = "Код";
    var $Ribakood = "Штрихкод";
    var $Hind = "Цена";
    var $Kogus = "Кол-во";
    var $Grupp = "Группа";
    var $SubGrupp = "Подгруппа";
    var $Ladu = "Склад";
    var $Buffer = "Буффер";
    var $Ost = "Закупка";
    var $Laoseis = "Остаток";
    var $Paigutus = "Место";
     var $KM = "Налог";


    var $ConfDel = "Желаете удалить";
    var $ConfEmp = "Желаете опустошить";
    var $ConfCopy = "Желаете копировать";
    var $buffrit = "буффер";
    var $buffrist = "из буффера";
    var $buffrisse = "в буффер";
    var $FillAll = "Заполни все поля!" ;
    var $save="Сохранить";
    var $clone="Клонировать";
    var $uus = "Новый";
    var $vali="Выбрать";

     var $loetelu = "Список";
     var $saada = "Отправить";
     var $first = "Первый";
     var $prev = "Предыдущий";
     var $next = "Следующий";
     var $last = "Последний";

    var $TeeRetsept = "Создать рецепт";

      var $UusKaup = "Новый товар";
      var $Kaup = "Товар";



    var $Jah = "Да";
    var $Ei = "Нет";

    var $conffi = "Закончить инвентуру?";
    var $tundmatu = "Неизвестный товар";
    var $tundmatuF = "Неизвестная фирма";

    var $komponents = "Компоненты";

      var $docnr = "Док.нр.";
      var $tyyp = "Тип";
      var $date = "Дата";
      var $docdate = "Дата док.";
      var $supplier = "Поставщик";
      var $client  = "Клиент";
      var $FromLadu = "Со склада";
      var $ToLadu = "На склад";
      var $Ostutellimus = "Заказ";
      var $Myygitellimus  = "Предложение";
      var $sum  = "Сумма";
      var $Tooteid ="Товары";
      var $Kokku = "Итого";

      var $RegNr = "Рег. нр.";
      var $SearchKey = "Псевдоним";
      var $card = "Карта";
      var $Nahtav = "Активен";
      var $Adres = "Адрес";
      var $Eesn = "Имя";
      var $Pere = "Фамилия";
      var $epost = "Э-почта";
      var $Tel = "Тел.";
      var $Note = "Дополнительно";

      var $addinv = "Добавить в инвентуру";
      var $voi = "или";
      var $addbuf = "Добавить в буффер";

      var $invteg = "Остаток в наличие";
      var $invbuf = "Импорт из буффера";
      var $Tegel =  "Наличие";  //"Посчитанное";
      var $Jaak =  "Остаток";
      var $Vahe = "Разница";
      var $Finish = "Закончить";
      var $ready  = "готов";

      var $Qsendemail = "Отправить документ?";
      var $pdfgen = "Приготовление PDF файла";
      var $pdfrdy = "Создан файл";
      var $sendto = "PDF отправлен на Э-почту";


      var $novat = "Без налога";
      var $invat = "Налог включён";
      var $addvat = "Налог добавляется";

      var $prbuy  = "Закупочная";
      var $prsale  = "Продажи";

      var $Otsi   = "Поиск";

      var $sernum = "Серийный нр.";


      var $payt = "Срок оплаты";
      var $markused = "Пометки";

      var $import = "Импорт";

      var $Stockcard = "Журнал склада";
      var $Liik = "Вид";
      var $sisse  = "Приход";
      var $valja = "Расход";

      var $peida ="Скрыть правки";
      var $katte ="наценка";

      var $Login = "Пользователь";
      var $Pass = "Пароль";

      var $docs = "Документы";
      var $buysum  = "Закупка";

      var $showall  = "Показать все";
      var $algus = "Начало";
      var $l6pp  = "Конец";

      var $prices  = "Цены";

      var $saveok  = "Сохранено";
       var $viga  = "Ошибка";

       var $pricelist  = "Прайслист";

       var $purch = "Покупатель";


       var $indoc  = "Приход";
       var $outdoc = "Расход";
       var $interdoc = "Внутренний";

       var $open="Открытый";
       var $close="Закрытый";
	     var $sent="Отправлен";
	     var $confirmed="Подтверждён";
	     var $canceled="Отменён";
	     var $finished="Закончен";
       var $St = "Статус";
       var $Tahtaeg = "Дата выполнения";

       var $K6ik = "Все";
       var $MinQty = "Критич.";
       var $MaxQty = "Запас";
       var $NeedToOrder = "Заказать";
       var $PrintLabels = "Этикетки";

       var $fromdoc   = "документа";
       var $added   = "добавлен";
       var $Bron   = "Бронь";
       var $Pilt = "Картинка";

       var $rohkem = "Больше";
       var $prcodes = "Прочее";

       var $prcodelist  = "Доп. коды";

       var $inventory =  "Инвентаризация";
       var $notfin  = "не закончена";
       var $iready  = "готова";

       var $supcode = "Код поставщика";

       var $kassa = "Касса";
       var $closecash = "Смена";
       var $pwstart = "Начало работы";
       var $pwstop = "Конец работы";
       var $aeg = "Время";
       var $ccstart = "Начало смены";
       var $ccstop = "Конец смены";
       var $myyk = "продажа";

       var $saaja = "Получатель";
       var $addnew = "Добавить";
       var $partynum ="Нр. партии";

       var $kiirvali = "В каталоге кассы";
       var $order = "Очерёдность";
       var $attributes = "Свойства";
       var $kasum = "Прибыль";

       var $indocs="Закупка";
       var $outdocs="Продажи";

       var $maksmine = "Оплата";

       var $Paid = "Оплачено";

       var $Postal = "Индекс";
       var $City = "Город";
       var $Region = "Регион";
       var $Country = "Страна";

       var $Yhik = "Ед. изм.";
       var $Suhe = "Отношение";
       var $muudetud = "Изменён";
       var $agent = "Агент";

     }

?>
