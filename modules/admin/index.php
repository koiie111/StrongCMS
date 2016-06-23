<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Объявляем титл с помощью переменной
$title = 'Админ-панель';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
// Разрешаем доступ к странице только авторизованным пользователям
mode('user');
// Устанавливаем права доступа
level(1);
?>
<div class="title">Админ-панель</div>

<?
// Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>