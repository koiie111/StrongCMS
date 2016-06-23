<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
$title = 'Кабинет | Настройки | Аватар | Удаление аватара';
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
mode('user');
unlink($_SERVER["DOCUMENT_ROOT"].'/files/user/avatars/'.$user['avatar']);
$db->query("UPDATE `users` SET `avatar`='' WHERE `id`='".$user['id']."'");
header('location:/cab/settings/avatar');
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>