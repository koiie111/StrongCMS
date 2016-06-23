<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/

/*
* Файл хранит в себе функции используемые в движке.
* Список функций:
* input() - Фильтрация входных данный
* output() - фильтрация входных данных
* mode() - определение прав пользователей
* ErrorNoExit() - вывод ошибки без прекращения выполнения скрипта
* error() - вывод ошибки с прекращением выполнения скрипта
* SuccessNoExit() - вывод оповещания без прекращения выполнения скрипта
* success() - вывод уведомления об успешном действии
* user() - вывод пользователя
*/

// Подключаем файл коннекта с БД
include_once($_SERVER["DOCUMENT_ROOT"].'/system/db.php');
//Подключаем дополнения
include_once($_SERVER["DOCUMENT_ROOT"].'/system/extensions.php');

function input($string) {
	// Объявление переменной db, являющейся экземпляром класса mysqli глобалной
	global $db;
	// Экранирование специальных символов
	$string = $db->real_escape_string($string);
	// Вырезка битовой команды реверса строки
	$string = preg_replace('"‮"', " ", $string);
	// Удаляем пробелы
	$string = trim($string);
	// Возвращаем строку
	return $string;
}

function output($string) {
	// Преобразуем html символы в html сущности
	$string = htmlspecialchars($string);
	// Вставляем html код разрыва строки перед каждым переводом строки
	$string = nl2br($string);
	// Возвращаем строку
	return $string;
}

function mode($mode) {
	// Объявляем массив пользователя глобальным
	global $user;
	// Если в аргументе указан guest (т.е. доступно только для гостей)
	if($mode=='guest'){
		// Если сущетсвует массив юзера (т.е. пользователь авторизован)
		if(isset($user['id'])){
			// Выводим ошибку
			error('Данная страница доступна для просмотра только гостям.');
		}
	}elseif($mode=='user'){ // Или если в аргументе указан user (т.к. доступно только для авторизованных пользователей)
		if(!isset($user['id'])){ // Если не существует массива юзера (т.е. пользователь не авторизован)
			// Выводим ошибку
			error('Данная страница доступна для просмотра только авторизованным пользователям.');
		}
	}
}

function ErrorNoExit($text) {
	echo '<div class="error">'.$text.'</div>';
}

function error($text) {
	echo '<div class="error">'.$text.'</div>';
	// Выводим ошибку, подключаем ноги и прекращаем выполнение скрипта
	include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
	exit();
}

function SuccessNoExit($text) {
	echo "<div class='success'>$text</div>";
}

function success($text) {
	echo "<div class='success'>$text</div>";
	include_once($_SERVER["DOCUMENT_ROOT"].'/style/foot.php');
	exit();
}

function user($id) {
	// Объявление переменной db, являющейся экземпляром класса mysqli глобалной
	global $db;
	// Делаем запрос с переданным ид
	$query = $db->query("SELECT * FROM `users` WHERE `id`='".$id."'");
	if ($query->num_rows==0) { // Если пользователь не найден
		// В переменную вывода ника пишем Удалён
		$nick = 'Удалён';
		$icon = 'm_off';
	}else{
		// Создаём массив юзера
		$us = $query->fetch_assoc();
		// В переменню вывода ника пишем ссылку на страницу пользователя
		$nick = '<a href="/user/'.$id.'">'.output($us['nick']).'</a>';
		$MaxOnline = 5;
		$online = 5*60;
		if($us['time_online']>time()-$online){
			if($us['sex']==1){
				$icon = 'm_on';
			}else{
				$icon = 'w_on';
			}
		}else{
			if($us['sex']==1){
				$icon = 'm_off';
			}else{
				$icon = 'w_off';
			}
		}
	}
	$icon = "<img src='/style/themes/default/images/icons/online/$icon.png'>";
	$nick = $icon." ".$nick;
	// Возвращаем ник
	return $nick;
}

define('TIME', time());
function times($time = NULL)
{
    if (!$time)
        $time = TIME;

    $data = date('j.n.y', $time);
    if ($data == date('j.n.y'))
        $res = 'Сегодня в '.date('G:i', $time);
    elseif ($data == date('j.n.y', TIME - 86400))
        $res = 'Вчера в '.date('G:i', $time);
    elseif ($data == date('j.n.y', TIME - 172800))
        $res = 'Позавчера в '.date('G:i', $time);
    else
    {
        $m = array(
            '0',
            'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Октября',
            'Ноября',
            'Декабря');

        $res = date('j '.$m[date('n', $time)].' Y в G:i', $time);
        $res = str_replace(date('Y'), '', $res);
    }
    return $res;
}

function level($level) {
	global $user;
	if($user['admin']<$level){
		error('У Вас нет прав для просмотра данной страницы.');
	}
}
?>