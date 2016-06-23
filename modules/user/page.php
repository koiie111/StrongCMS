<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Анкета пользователя';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
$_GET['id'] = abs(intval($_GET['id']));
$query = $db->query("SELECT * FROM `users` WHERE `id`='".$_GET['id']."'");
if($query->num_rows==0){
	error('Пользователя не существует.');
}
$us = $query->fetch_assoc();
?>
<div class="title">
	Анкета пользователя <?=user($us['id'])?>
</div>
<div class="section">
	<b>Зарегистрирован:</b> <?=times($us['time_reg'])?><br>
	<b>Последний раз был в сети:</b> <?=times($us['time_online'])?>
</div>
<div class="section">
	<?if(empty($us['avatar'])){?>
		<img src="/style/themes/default/images/no_ava.png">
	<?}else{?>
		<img src="/files/user/avatars/<?=$us['avatar']?>" style="max-width: 250px; max-height: 250px;">
	<?}?>
</div>
<div class="section">
	<b>Пол:</b> 
	<?
	if($us['sex']==1){
		?>
		Мужской<br>
		<?
	}else{
		?>
		Женский<br>
		<?
	}
	if(!empty($us['name'])){
		?>
		<b>Имя:</b> <?=$us['name']?><br>
		<?
	}
	if(!empty($us['birthday'])){
		?>
		<b>Дата рождения:</b> <?=$us['birthday']?><br>
		<?
	}
	if(!empty($us['country'])){
		?>
		<b>Страна:</b> <?=$us['country']?><br>
		<?
	}
	if(!empty($us['city'])){
		?>
		<b>Город:</b> <?=$us['city']?>
		<?
	}
	?>
</div>
<div class="section">
	<?if($user['admin']>=1 AND $user['admin']>=$us['admin']){
		?>
		<a href="/admin/users/edit/<?=$us['id']?>">Редактировать пользователя</a>
		<?
	}
	?>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>