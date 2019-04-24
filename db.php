<?php 

try {
	$pdo = new PDO("mysql:host=localhost;dbname=AjaxCrudOperation", "root","");

} catch (PDOException $e) {
	die("error ");
	$pdo = null;
	
}


 