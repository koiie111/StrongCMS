<?php
/*
* (c) StrongCMS
* Сайт - strongcms.ru
* Группа ВКонтакте - vk.com/strong_cms
* Автор - Александр Каплин
* Контакты - vk.com/koiie
*/


/*
Указание параметров подключения к БД в переменных:
$host - хост
$user - пользователь БД
$password - пароль БД
$database - база данных
*/
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'strongcms';
// Создание экземпляра класса mysqli 
$db = new mysqli($host, $user, $password, $database);
// Если есть ошибка при подключении к базе данных, то выводим ошибку через защитную конструкцию die
if($db->connect_errno){
	die('Ошибка подключения к базе данных: '.$db->connect_error);
}
?>