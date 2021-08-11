<?php
include_once('config.php');
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

function getFeedback($id){
	$db = new PDO('sqlite:test.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks WHERE id = :id')){
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$db = null;
	}
	else{
		echo "Error";
	}
}

function getAllFeedbacks($page){
	$page = 2;
	$db = new PDO('sqlite:test.db');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks ORDER BY id LIMIT 20 OFFSET 20*:page')){
		$stmt->bindParam(':page', $page);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$db = null;
	}
}

$app = AppFactory::create();
$app->get('/feedback:id', getFeedback($id));
$app->get('/', getAllFeedbacks($page));
$app->run();



