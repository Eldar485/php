<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

function getFeedback(){
	$id = 1;
	$db = new PDO('sqlite:test.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks WHERE id = :id')){
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		var_dump($rows);
		$db->close();
	}
	else{
		echo "Error";
	}
}

function getAllFeedbacks(){
	$page = 1;
	$db = new PDO('sqlite:test.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks LIMIT 2*:page')){
		$stmt->bindParam(':page', $page);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		var_dump($rows);
		$db->close();
	}
	else{
		echo "Error";
	}
}

$app = AppFactory::create();

$app->get('/', getAllFeedbacks());

$app->run();


	
	//$rows = $results->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($rows);
	//$db->close();
	



