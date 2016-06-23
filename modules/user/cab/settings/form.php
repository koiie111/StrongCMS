<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Кабинет | Настройки | Анкета';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
mode('user');
?>
<div class="title">
	<a href="/cab">Кабинет</a>
	|
	<a href="/cab/settings/">Настройки</a>
	|
	Анкета
</div>
<?
if(isset($_POST['ok'])){
	$_POST['name'] = input($_POST['name']);
	$_POST['sex'] = abs(intval($_POST['sex']));
	$_POST['birthday'] = input($_POST['birthday']);
	$_POST['country'] = input($_POST['country']);
	$_POST['city'] = input($_POST['city']);
	if(mb_strlen($_POST['name'])>100){
		ErrorNoExit('Длинна имени не должна превышать 100 символов.');
	}elseif(mb_strlen($_POST['birthday'])>10){
		ErrorNoExit('Длинна даты рождения не может превышать 10 символов.');
	}elseif(mb_strlen($_POST['country'])>30){
		ErrorNoExit('Длинна названия страны должна не привышать 30 символов.');
	}elseif(mb_strlen($_POST['city'])>50){
		ErrorNoExit('Длинна названия города должна не привышать 50 символов.');
	}elseif(!preg_match("/[^A-zА-я]/", $_POST['birthday'])){
		ErrorNoExit('Введите дату рождения корректно.');
	}else{
		$db->query("UPDATE `users` SET `name`='".$_POST['name']."', `sex`='".$_POST['sex']."', `birthday`='".$_POST['birthday']."', `country`='".$_POST['country']."', `city`='".$_POST['city']."' WHERE `id`='".$user['id']."'");
		$user = $db->query("SELECT * FROM `users` WHERE `id`='".$user['id']."'")->fetch_assoc();
		SuccessNoExit('Данные сохранены.');
	}
}
?>
<div class="main">
	<form action="" method="POST">
		Имя:<br>
		<input type="text" name="name" value="<?=output($user['name'])?>"><br/>
		Пол:<br>
		<select name="sex">
			<option value="1" <?if($user['sex']==1){?>selected<?}?>>Мужской</option>
			<option value="2" <?if($user['sex']==2){?>selected<?}?>>Женский</option>
		</select><br>
		Дата рождения(например - 31.08.2000):<br/>
		<input type="text" name="birthday" value="<?=$user['birthday']?>"><br>
		Страна:<br>
		<input type="text" name="country" value="<?=$user['country']?>"><br>
		Город:<br>
		<input type="text" name="city" value="<?=$user['city']?>"><br>
		<input type="submit" name="ok" value="Изменить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>