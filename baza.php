<?php

$host='localhost';
$user='root';
$password='';
$database='projektna';

$link = mysqli_connect($host, $user, $password, $database)or die("baza ni dostopna");
	mysqli_set_charset($link, "utf8");