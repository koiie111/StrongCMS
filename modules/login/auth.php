<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Объявляем титл с помощью переменной
$title = 'Авторизация';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
// Разрешаем просматривать эту страницу только не зарегистрированным пользователям
mode('guest');
?>
<div class="title">
	Авторизация
</div>
<?
// Если были переданы данные
if (isset($_POST['login'])) {
	// Фильтруем данные
	$_POST['nick'] = input($_POST['nick']);
	$_POST['password'] = input($_POST['password']);
	// Далее ошибки
	if (empty($_POST['nick'])) { // Если не был введён ник
		ErrorNoExit('Введите ник.');
	}elseif (empty($_POST['password'])) { // Если не был введён пароль
		ErrorNoExit('Введите пароль.');
	}elseif ($db->query("SELECT `id` FROM `users` WHERE `nick`='".$_POST['nick']."'")->num_rows==0) { // Запрос в БД который возвращает кол-вл пользователей с переданным ником, если пользователей нет, то ошибка
		ErrorNoExit('Пользователя не существует.');
	}elseif($db->query("SELECT `id` FROM `users` WHERE `password`='".crypt($_POST['password'], '$1$rasmusle$')."'")->num_rows==0) {
		ErrorNoExit('Пароль введён не верно.');
	}else{
			// Генерируем токен
			$tocken = md5(time()."strong".rand(1, 9)); 
			// Обновляем токен в БД
			$db->query("UPDATE `users` SET `tocken`='".$tocken."' WHERE `nick`='".$_POST['nick']."'");
			// Обновляем токен в куках 
			setcookie("tocken", $tocken, time()+86000*31*12);
			// Перенаправлем пользователя на главную страницу
			header('location:/');
		}
	}
?>
<div class="main">
	<form action="" method="POST">
		Ваш ник:<br>
		<input type="text" name="nick"><br>
		Ваш пароль:<br>
		<input type="password" name="password"><br>
		<input type="submit" name="login" value="Войти">
	</form>
</div>
<?
// Инклюдим ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>