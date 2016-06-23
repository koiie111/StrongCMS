<?
ob_start();
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/
?>

<html>

<?
//Инклюдим системные файлы
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/functions.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/system/class/nav.php');
?>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=$title?></title>
		<link rel="stylesheet" href="/style/themes/default/css/style.css">
	</head>

	<body>
		<div class="head">
			<a href="/">
				<img src="/style/themes/default/images/logo.png">
			</a>
		</div>
		<div class="nvgup">
			<?if(isset($user['id'])){
				?>
				<a href="/cab">Кабинет</a>
				<a href="/exit">Выход</a>
				<?
			}else{
				?>
				<a href="/auth">Вход</a>
				<a href="/reg">Регистрация</a>
				<?
			}
			?>
		</div>