<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

function getFeedback(int $id): ?array{
	include_once('config.php');
	$db = new PDO('sqlite:'.$bd_way);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($stmt = $db->prepare('SELECT * FROM feedbacks WHERE id = :id')){
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$db = null;
		return $rows;
	}
	else{
		return NULL;
	}
}

function getAllFeedbacks(int $page): array{
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
	else{
		return array();
	}
}

$app = AppFactory::create();
$app->get('/api/feedbacks/{id}', function(Request $request, Response $response, array $args){
	$id = $args['id'];
	$arr = getFeedback((int)$id);
	$response->getBody()->write(implode(',', $arr));
	return $response;
});
$app->get('/api/feedbacksA/', function(Request $request, Response $response, array $args){
	$page = $_GET['page'];
	$a =getAllFeedbacks((int)$page);
	$json = json_encode(getAllFeedbacks((int)$page));
	$response->getBody()->write($json);
	return $response;
});
$app->run();



