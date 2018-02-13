<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Gell All customers
$app->get('/api/customers', function(Request $req, Response $res){
    $sql = "SELECT * FROM customers";

    try {
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);

    } catch (PDOException $e) {
        echo '{"error": {"message":'.$e->getMessage().'}';
    }
});

// Gell single customers
$app->get('/api/customers/{id}', function(Request $req, Response $res){
    $id = $req->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id = $id";

    try {
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);

    } catch (PDOException $e) {
        echo '{"error": {"message":'.$e->getMessage().'}';
    }
});

// Add customers
$app->post('/api/customers', function(Request $req, Response $res){
    $first_name = $req->getParam('first_name');
    $last_name = $req->getParam('last_name');
    $city = $req->getParam('city');
    $phone = $req->getParam('phone');
    $occupation = $req->getParam('occupation');

    $sql = "INSERT INTO customers
                (first_name,last_name,city,phone,occupation) 
                VALUES 
                (:first_name,:last_name,:city,:phone,:occupation)";

    try {
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':occupation', $occupation);

        $stmt->execute();

        echo '{"notice": {"message": "Customer Added"}';

    } catch (PDOException $e) {
        echo '{"error": {"message":'.$e->getMessage().'}';
    }
});

// Add customers
$app->put('/api/customers/{id}', function(Request $req, Response $res){
    $id = $req->getAttribute('id');    
    $first_name = $req->getParam('first_name');
    $last_name = $req->getParam('last_name');
    $city = $req->getParam('city');
    $phone = $req->getParam('phone');
    $occupation = $req->getParam('occupation');

    $sql = "UPDATE  customers SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        city = :city,
                        phone = :phone,
                        occupation = :occupation 
                        WHERE id = $id";

    try {
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':occupation', $occupation);

        $stmt->execute();
        $db = null;

        echo '{"notice": {"message": "Customer Upated"}';

    } catch (PDOException $e) {
        echo '{"error": {"message":'.$e->getMessage().'}';
    }
});

// Delete single customers
$app->delete('/api/customers/{id}', function(Request $req, Response $res){
    $id = $req->getAttribute('id');
    $sql = "DELETE FROM customers WHERE id = $id";

    try {
        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        
        echo '{"notice": {"message": "Customer Deleted"}';

    } catch (PDOException $e) {
        echo '{"error": {"message":'.$e->getMessage().'}';
    }
});