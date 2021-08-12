<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

function getFeedback($id){
	include_once('config.php');
	$db = new PDO('sqlite:'.$bd_way);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks WHERE id = :id')){
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$db = null;
		return $rows;
	}
}

function getAllFeedbacks($page){
	include_once('config.php');
	$db = new PDO('sqlite:'.$bd_way);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks ORDER BY id LIMIT 20 OFFSET 20*:page')){
		$stmt->bindParam(':page', $page);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$db = null;
		return $rows;
	}
}

$app = AppFactory::create();
$app->get('/feedback{id}', function(Request $request, Response $response, array $args){
	$id = $args['id'];
	getFeedback($id);
	return $response;
});
$app->get('/{page}', function(Request $request, Response $response, array $args){
	$page = $args['page'];
	getAllFeedbacks($page);
	return $response;
});
$app->run();



