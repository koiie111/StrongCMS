<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Устанавливаем титл с помощью переменной
$title = 'Выход';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
// Делаем страницу доступной только для авторизованных пользователей
mode('user');
?>
<div class="title">
	Выход
</div>
<?
// Если была нажата кнопка Да
if(isset($_POST['yes'])){
	// Удаляем токен из куков
	setcookie("tocken", "", time()-86000*31*12);
	// Удаляем токен из БД
	$db->query("UPDATE `users` SET `tocken`='' WHERE `id`='".$user['id']."'");
	// Перенаправлем на главную
	header('location:/');
}elseif (isset($_POST['no'])) { // Если была нажата кнопка Нет
	// Перенаправляем на главную
	header('location:/');
}
?>
<div class="main">
	<form action="" method="POST">
		Вы действительно хотите выйти с аккаунта?<br>
		<input type="submit" name="yes" value="Да">
		<input type="submit" name="no" value="Нет">
	</form>
</div>
<?
// Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>