<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Устанавливаем титл страницы через переменную
$title = 'Пользователи';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
?>
<div class="title">
	Пользователи
</div>
<?
// Создаём экземпляр класса navig (навигация)
$nav=new navig("SELECT * FROM `users`");
// Делаем запрос с параметрами
$query = $db->query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT ".$nav->start.", ".$nav->nstr);
// Цикл вывода пользователей (10)
while($us = $query->fetch_assoc()){
	?>
	<div class="section">
		<?=user($us['id'])?>
	</div>
	<?
}
// Если пользователей в БД больше 10, то выводим пагинацию
if($query->num_rows>10){
	?>
	<div class="nvgstr">
		<?
		$nav->panel();
		?>
	</div>
	<?
}
	?>
	<?
	// Если пользователей в БД нету, то выводим сообщение
	if($db->query("SELECT * FROM `users`")->num_rows==0){
		?>
		<div class="main">Пользователей пока нет</div>
		<?
	}
	?>
	<div class="main">
		<form action="/searh" method="POST">
			Поиск пользователя:<br>
			<input type="searh" name="searh"><br>
			<input type="submit" name="ok" value="Искать">
		</form>
	</div>
	<?
	// Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>