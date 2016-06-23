<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/

// Объявляем титл страницы через переменную
$title = 'Регистрация';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
// Делаем страничку доступной только для гостей
mode('guest');
?>
<div class="title">
	Регистрация
</div>
<?
// Обработчик формы
if(isset($_POST['reg'])){
	// Фильтруем переменные
	$_POST['nick'] = input($_POST['nick']);
	$_POST['password'] = input($_POST['password']);
	$_POST['ConfirmPassword'] = input($_POST['ConfirmPassword']);
	$_POST['sex'] = abs(intval($_POST['sex']));
	$_POST['email'] = input($_POST['email']);
	// Далее проверки и вывод ошибки
	if (mb_strlen($_POST['nick'])<2 or mb_strlen($_POST['nick'])>30) { // Если длина ника меньше 2 или больше 30 символов
		ErrorNoExit('Длинна ника должна быть не менее 2-ух и не более 30 символов.');
	}elseif (mb_strlen($_POST['password'])<5) { // Если длина пароля меньше 5 символов
		ErrorNoExit('Длинна пароля должна быть не менее 5-ти символов.');
	}elseif ($_POST['password']!=$_POST['ConfirmPassword']) { // Если пароли не совпадают
		ErrorNoExit('Пароли не совпадают.');
	}elseif (!preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $_POST['email'])) { // Проверка корректности введёного пароля с помощью выражения
		ErrorNoExit('Неверно введён E-Mail.');
	}elseif ($db->query("SELECT `id` FROM `users` WHERE `nick`='".$_POST['nick']."'")->num_rows!=0) { // Запрос в БД, который возвращает кол-во пользователей с переданным ником. Если пользователей больше 0, то ошибка
		ErrorNoExit('Пользователь с таким ником уже существует.');
	}elseif ($db->query("SELECT `id` FROM `users` WHERE `email`='".$_POST['email']."'")->num_rows!=0) { // запрос в БД, который возвращает кол-во пользователей с переданным E-Mail. Если пользователей больше 0, то ошибка
		ErrorNoExit('Пользователь с таким E-Mail уже существует.');
	}else { // Если все проверки пройдены
		// Создаём хэш пароля
		$hash = crypt($_POST['password'], '$1$rasmusle$');
		// Создаём токен для авторизации на сайте
		$tocken = md5(time()."strong".rand(1, 9));
		// Добавляем все принятые данные в таблицу users
		$db->query("INSERT INTO `users` SET `nick`='".$_POST['nick']."', `password`='".$hash."', `email`='".$_POST['email']."', `sex`='".$_POST['sex']."', `time_reg`='".time()."', `tocken`='".$tocken."'");
		// Добавляем токен в куки
		setcookie("tocken", $tocken, time()+86000*31*12);
		// Перенаправляем пользователя на главную страницу
		header('location:/');
	}
}
?>
<div class="main">
	<form action="" method="POST">
		Придумайте ник:<br>
		<input type="text" name="nick"><br>
		Придумайте пароль:<br>
		<input type="password" name="password"><br>
		Повторите пароль:<br>
		<input type="password" name="ConfirmPassword"><br>
		Введите E-Mail:<br>
		<input type="email" name="email"><br>
		Выберите пол:<br>
		<select name="sex">
			<option value="1">Мужской</option>
			<option value="2">Женский</option>
		</select>
		<br>
		<input type="submit" name="reg" value="Зарегистрироваться">
	</form>
</div>
<?
// Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>