<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
// Устанавливаем титл страницы через переменную
$title = 'Поиск пользователей';
// Подключаем шапку
include_once($_SERVER["DOCUMENT_ROOT"].'/style/head.php');
?>
<div class="title">
	Поиск пользователей
</div>
<?
// Ксли были переданы данные (нажата кнопка Искать)
if(isset($_POST['ok'])){
	?>
	<div class="main">
		Результаты поиска:
	</div>
	<?
	// Фильтруем полученные данные
	$_POST['searh'] = input($_POST['searh']);
	if (empty($_POST['searh'])) {// Если поле поиска осталось пустым, то выводим ошибку
		ErrorNoExit('Введите ник для поиска');
	}elseif ($db->query("SELECT `id` FROM `users` WHERE `nick` LIKE '%".$_POST['search']."%'")->num_rows==0) { // Если в БД не было найдено пользователей с переданным ником, то выводим ошибку
		ErrorNoExit('Пользователей с таким ником не найдено.');
	}else{ // Если ошибок нет
		// Создаём экземпляр класса navig (навигация)
		$nav=new navig("SELECT * FROM `users` WHERE `nick` LIKE '%".$_POST['search']."%'");
		// Делаем запрос с параметрами
		$query = $db->query("SELECT * FROM `users` WHERE `nick` LIKE '%".$_POST['search']."%' ORDER BY `id` DESC LIMIT ".$nav->start.", ".$nav->nstr);
		while($us = $query->fetch_assoc()){ // Выводим найденных пользователей
			?>
			<div class="section">
				<?=user($us['id'])?>
			</div>
			<?
		}
	?>
	<? // Если пользователей больше 10, то выводи пагинацию
	if($query->num_rows>10){
		?>
		<div class="nvgstr">
			<?=$nav->panel();?>
		</div>
		<?
	}
	?>
	<?
	}
}
?>
<div class="main">
	<form action="" method="POST">
		Поиск пользователя:<br>
		<input type="searh" name="searh"><br>
		<input type="submit" name="ok" value="Искать">
	</form>
</div>
<?
// Подключаем ноги
include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
?>