<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Кабинет | Настройки | Аватар';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
mode('user');
?>
<div class="title">
	<a href="/cab">Кабинет</a>
	|
	<a href="/cab/settings/">Настройки</a>
	|
	Аватар
</div>
<?
if(isset($_POST['ok'])){
	$size = $_FILES['file']['size'];
	$max = 5;
	$filetype = array(
		'jpg',
	    'gif',
	    'png',
	    'jpeg');
	$upfiletype = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], ".") + 1);
	if(!@file_exists($_FILES['file']['tmp_name']) AND $_POST['imp']!=imp){
		ErrorNoExit('Выберите файл!');
	}elseif($size > (1048576 * $max)){
		ErrorNoExit('Вес файла должен быть не более '.$max.' мб.');
	}elseif(!in_array($upfiletype, $filetype)){
		ErrorNoExit('Файл данного формата загржать запрещено!');
	}else{
		if(!empty($user['avatar'])){
			unlink('../../../../files/user/avatars/'.$user['avatar']);
		}
		$file = $_SERVER["HTTP_HOST"].'_'.rand(0,999999).'_'.$_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'], "../../../../files/user/avatars/".$file."");
		$db->query("UPDATE `users` SET `avatar`='".$file."' WHERE `id`='".$user['id']."'");
		header('location:/cab/settings/avatar');
	}
}
?>
<div class="section">
	Текущий аватар:<br>
	<?
	if(empty($user['avatar'])){
		?>
		<img src="/style/themes/default/images/no_ava.png">
		<?
	}else{
		?>
		<img src="/files/user/avatars/<?=$user['avatar']?>" style="max-width: 250px; max-height: 250px;"><br>
		<a href="/cab/settings/avatar/del">Удалить текущий аватар</a>
		<?
	}
	?>
</div>
<div class="section">
	<form action="" method="POST" enctype="multipart/form-data">
		Выберите файл:<br>
		<input type="file" name="file"><br>
		<input type="submit" name="ok" value="Загрузить">
	</form>
</div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>