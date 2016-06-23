<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Кабинет';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
mode('user');
?>
<div class="title">
	Кабинет
</div>
<div class="section"><a href="/user/<?=$user['id']?>">Моя страница</a></div>
<div class="section"><a href="/cab/settings">Настройки</a></div>
<?
if($user['admin']>=1){
	?>
	<div class="section"><a href="/admin">Админ-панель</a></div>
	<?
}
?>
<div class="section"><a href="/exit">Выход</a></div>
<?
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>