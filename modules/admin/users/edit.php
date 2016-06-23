<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Объявляем титл с помощью переменной 
$title = 'Админ-панель | Пользователи | Редактирование пользователя';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
// Делаем страницу доступной только для авторизованных пользователей
mode('user');
// Делаем страницу доступной только для администрации, начиная с 1 уровня
level(1);
// Фильтруем переданный ид
$_GET['id'] = abs(intval($_GET['id']));
// Создаём массив редактируемого юзера
$us = $db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'")->fetch_assoc();
// Если ранг поьзователя меньше чем ранг редактируемого пользователя
if($user['admin']<$us['admin']){
	// Выводим ошибку
	error('У Вас нет прав для прсомотра данной страницы.');
}
?>
<div class="title">
	<a href="/admin">Админ-панель</a>
	|
	<a href="/admin/users/">Пользователи</a>
	|
	Редактирование пользователя <?=user($_GET['id'])?>
</div>
<?
// Если была нажата кнопка "Изменить"
if(isset($_POST['ok'])){
	// Фильтруем переменные
	$_POST['name'] = input($_POST['name']);
	$_POST['sex'] = abs(intval($_POST['sex']));
	$_POST['birthday'] = input($_POST['birthday']);
	$_POST['country'] = input($_POST['country']);
	$_POST['city'] = input($_POST['city']);
	if(mb_strlen($_POST['name'])>100){ // Если кол-во символов в имени больше 100
		// Выводим ошибку
		ErrorNoExit('Длинна имени не должна превышать 100 символов.');
	}elseif(mb_strlen($_POST['birthday'])>10){ // Если кол-во символов в дате рождения больше 10
		// Выводим ошибку
		ErrorNoExit('Длинна даты рождения не может превышать 10 символов.');
	}elseif(mb_strlen($_POST['country'])>30){ // Если кол-во символов в стране больше 30
		// Выводим ошибку
		ErrorNoExit('Длинна названия страны должна не привышать 30 символов.');
	}elseif(mb_strlen($_POST['city'])>50){ // Если кол-во символов в названии города больше 50
		// Выводим ошибку
		ErrorNoExit('Длинна названия города должна не привышать 50 символов.');
	}elseif(!preg_match("/[^A-zА-я]/", $_POST['birthday'])){ // Если в поле даты рождения используются буквы
		// Выводим ошибку
		ErrorNoExit('Введите дату рождения корректно.');
	}else{
		// Если всё нормально
		// Апдейтим таблицу пользователей
		$db->query("UPDATE `users` SET `name`='".$_POST['name']."', `sex`='".$_POST['sex']."', `birthday`='".$_POST['birthday']."', `country`='".$_POST['country']."', `city`='".$_POST['city']."' WHERE `id`='".$us['id']."'");
		// Заного создаём массив пользователя (чтобы изменённые данные сразу отразились без обновления страницы)
		$us = $db->query("SELECT * FROM `users` WHERE `id`='".$us['id']."'")->fetch_assoc();
		// Вводим оповещение об удачном редактировании
		SuccessNoExit('Данные сохранены.');
	}
}
?>
<div class="main">
	<form action="" method="POST">
		Имя:<br>
		<input type="text" name="name" value="<?=output($us['name'])?>"><br/>
		Пол:<br>
		<select name="sex">
			<option value="1" <?if($us['sex']==1){?>selected<?}?>>Мужской</option>
			<option value="2" <?if($us['sex']==2){?>selected<?}?>>Женский</option>
		</select><br>
		Дата рождения(например - 31.08.2000):<br/>
		<input type="text" name="birthday" value="<?=$us['birthday']?>"><br>
		Страна:<br>
		<input type="text" name="country" value="<?=$us['country']?>"><br>
		Город:<br>
		<input type="text" name="city" value="<?=$us['city']?>"><br>
		<input type="submit" name="ok" value="Изменить">
	</form>
</div>
<?
// Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>