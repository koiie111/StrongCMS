<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Объявляем титл с помощью переменной
$title = 'StrongCMS beta ver 0.1.1';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
?>
<div class="error">
	Test error
</div>
<div class="success">
	Test success
</div>
<div class="section">
	<a href="/users">Пользователи (<?=$db->query("SELECT `id` FROM `users`")->num_rows?><?if($db->query("SELECT `id` FROM `users` WHERE `time_reg`>".time()."-86000")->num_rows!=0){?><font style="color: red;">+<?=$db->query("SELECT `id` FROM `users` WHERE `time_reg`>".time()."-86000")->num_rows?></font><?}?>)</a>
</div>
<?
//Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>