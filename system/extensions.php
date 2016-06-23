<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Если существуют куки с токеном
if(isset($_COOKIE['tocken'])){
	// Фильтруем куки
	$_COOKIE['tocken'] = $db->real_escape_string($_COOKIE['tocken']);
	// Делаем запрос в БД и получаем данные о пользователе с получанным токеном
	$query = $db->query("SELECT * FROM `users` WHERE `tocken`='".$_COOKIE['tocken']."'");
	if($query->num_rows!=0){ // Если БД вернула больше нуля строк
		// Создаём ассоциативный массив юзера
		$user = $query->fetch_assoc();
		$db->query("UPDATE `users` SET `time_online`=".time()." WHERE `id`='".$user['id']."'");
	}
}
?>