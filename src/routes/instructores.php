<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/instructores', function(Request $request, Response $response){
  //echo "Instructores";
  $sql = "select * from instructor";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $instructor = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($instructor);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
