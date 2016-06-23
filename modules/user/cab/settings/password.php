<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Кабинет | Настройки | Смена пароля';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
mode('user');
?>
<div class="title">
	<a href="/cab">Кабинет</a>
	|
	<a href="/cab/settings">Настройки</a>
	|
	Смена пароля
</div>
<?
if(isset($_POST['ok'])){
	$_POST['OldPassword'] = input($_POST['OldPassword']);
	if($user['password']!=crypt($_POST['OldPassword'], '$1$rasmusle$')){
		ErrorNoExit('Старый пароль введён не верно.');
	}elseif($_POST['NewPassword']!=$_POST['ConfirmPassword']){
		ErrorNoExit('Новый пароль и подтверждение не совпадают.');
	}elseif($_POST['OldPassword']==$_POST['NewPassword']){
		ErrorNoExit('Новый пароль используется Вами в данный момент, придумайте другой пароль.');
	}else{
		$db->query("UPDATE `users` SET `password`='".crypt($_POST['NewPassword'], '$1$rasmusle$')."' WHERE `id`='".$user['id']."'");
		success('Пароль успешно сменён.');
	}
}
?>
<div class="main">
	<form action="" method="POST">
		Введите старый пароль:<br>
		<input type="password" name="OldPassword"><br>
		Введите новый пароль:<br>
		<input type="password" name="NewPassword"><br>
		Подтверите новый пароль:<br>
		<input type="password" name="ConfirmPassword"><br>
		<input type="submit" name="ok" value="Сменить пароль">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>