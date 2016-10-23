<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/movie', 'getMovies');
$app->post('/movie', 'addMovie');
$app->put('/movie/:id', 'updateMovie');
$app->delete('/movie/:id', 'deleteMovie');
$app->run();

//Mostrar todos
function getMovies() {
    try {
        $db = getConnection();
        $stmt = $db->query('select * from movies');
        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Guardar nueva pelicula
function addMovie() {
    global $app;
    $data = json_decode($app->request()->getBody());
    $sql = "insert into movies values(?,?,?,?)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
       $stmt->bindParam(1, $data->id);
        $stmt->bindParam(2, $data->nombre);
        $stmt->bindParam(3, $data->genero);
        $stmt->bindParam(4, $data->ano);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Editar una pelicula
function updateMovie($id) {
    global $app;
    $data = json_decode($app->request()->getBody());
    $sql = "update movies set nombre=?,genero=?,ano=? where id = ?";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $data->nombre);
        $stmt->bindParam(2, $data->genero);
        $stmt->bindParam(3, $data->ano);
        $stmt->bindParam(4, $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Eliminando una pelicula
function deleteMovie($id) {
    $sql = "delete from movies where id = :id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('id', $id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e.getMessage();
    }
}

//Conectando a la Base de datos
function getConnection() {
    $dbhost = "localhost";
    $dbuser = "feratran_movie";
    $dbpass = "movie.0106";
    $dbname = "feratran_movies";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
