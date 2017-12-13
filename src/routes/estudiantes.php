<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los esudiantes

$app->get('/api/estudiantes', function(Request $request, Response $response){
  //echo "Estudiantes";
  $sql = "select * from estudiante";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($estudiantes);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');
    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
$app->get('/api/departamentos', function(Request $request, Response $response){
  //echo "Estudiantes";
  $sql = "select * from departamento";

  try{
    //Get DB Object
    $db = new db();
    //connect
    $db = $db->connect();

    $stmt = $db->query($sql);
    $depo = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($depo);
  } catch(PDOException $e){
    echo '{"error": {"text":'.$e->getMessage().'}';
  }
});
// Agregar un estudiante
$app->post('/api/departamentos/add', function(Request $request, Response $response){
    $clave_depa = $request->getParam('clave_depa');
    $nombre = $request->getParam('nombre_departamento');
    $rfc_trabajador = $request->getParam('trabajador_rfc');
    $sql = "INSERT INTO departamento (clave_depa, nombre_departamento, trabajador_rfc) VALUES (:clave_depa, :nombre_departamento, :trabajador_rfc)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_depa',      $clave_depa);
        $stmt->bindParam(':nombre_departamento',         $nombre);
        $stmt->bindParam(':trabajador_rfc',      $rfc_trabajador);
        $stmt->execute();
        echo '{"notice": {"text": "Departamento agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/departamentos/update/{clave_depa}', function(Request $request, Response $response){
    $clave_depa = $request->getParam('clave_depa');
    $nombre = $request->getParam('nombre_departamento');
    $rfc_trabajador = $request->getParam('trabajador_rfc');
    $sql = "UPDATE departamento SET
                clave_depa               = :clave_depa,
                nombre_departamento       = :nombre_departamento,
                trabajador_rfc   = :trabajador_rfc
            WHERE clave_depa = '$clave_depa'";
          //  echo $sql;
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_depa',      $clave_depa);
        $stmt->bindParam(':nombre_departamento',         $nombre);
        $stmt->bindParam(':trabajador_rfc',      $rfc_trabajador);
        $stmt->execute();
        echo '{"notice": {"text": "Departamento actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/departamentos/delete/{clave_depa}', function(Request $request, Response $response){
    $clave_depa = $request->getAttribute('clave_depa');
    $sql = "DELETE FROM departamento WHERE clave_depa = $clave_depa";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
