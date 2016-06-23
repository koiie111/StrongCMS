<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Настройки';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
mode('user');
?>
<div class="title">
	<a href="/cab">Кабинет</a>
	|
	Настройки
</div>

<div class="section"><a href="/cab/settings/avatar">Аватар</a></div>
<div class="section"><a href="/cab/settings/password">Смена пароля</a></div>
<div class="section"><a href="/cab/settings/form">Анкета</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>