<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

//Get all Customers
$app->get('/api/customers', function(Request $request, Response $response){
	$sql = "SELECT * from customers";

	try{
		//Get Db OBject
		$db = new db();
		//Connect
		$db = $db->connect();
		$stmt = $db->query($sql);
		$customers = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($customers);

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Get Single Customer
$app->get('/api/customer/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$sql = "SELECT * from customers WHERE id = $id";

	try{
		//Get Db OBject
		$db = new db();
		//Connect
		$db = $db->connect();
		$stmt = $db->query($sql);
		$customer = $stmt->fetch(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($customer);

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Add Customer
$app->post('/api/customer/add', function(Request $request, Response $response){
	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$state = $request->getParam('state');
	$customer_password = $request->getParam('customer_password');


	$sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state,customer_password) VALUES (:first_name,:last_name,:phone,:email,:address,:city,:state,:customer_password)";

	try{
		//Get Db OBject
		$db = new db();
		//Connect
		$db = $db->connect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name',  $last_name);
		$stmt->bindParam(':phone',      $phone);
		$stmt->bindParam(':email',      $email);
		$stmt->bindParam(':address',    $address);
		$stmt->bindParam(':city',       $city);
		$stmt->bindParam(':state',      $state);
		$stmt->bindParam(':customer_password',   $customer_password);


		$stmt->execute();
		echo '{"notice": {"text": "Customer Added"}';

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Update Customer
$app->put('/api/customer/update/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$first_name = $request->getParam('first_name');
	$last_name = $request->getParam('last_name');
	$phone = $request->getParam('phone');
	$email = $request->getParam('email');
	$address = $request->getParam('address');
	$city = $request->getParam('city');
	$state = $request->getParam('state');
	$customer_password = $request->getParam('customer_password');

	$sql = "UPDATE customers  SET 
				first_name = :first_name,
				last_name  = :last_name,
				phone      = :phone,
				email      = :email,
				address    = :address,
				city       = :city,
				state = :state,
				customer_password = :customer_password
			WHERE id = $id";

	try{
		//Get Db OBject
		$db = new db();
		//Connect
		$db = $db->connect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':first_name', $first_name);
		$stmt->bindParam(':last_name',  $last_name);
		$stmt->bindParam(':phone',      $phone);
		$stmt->bindParam(':email',      $email);
		$stmt->bindParam(':address',    $address);
		$stmt->bindParam(':city',       $city);
		$stmt->bindParam(':state',      $state);
		$stmt->bindParam(':customer_password',   $customer_password);

		$stmt->execute();
		echo '{"notice": {"text": "Customer Updated"}';

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Delete Single Customer
$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	$sql = "DELETE from customers WHERE id = $id";

	try{
		//Get Db OBject
		$db = new db();
		//Connect
		$db = $db->connect();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;

		echo '{"notice": {"text": "Customer Deleted"}';

	}catch(PDOException $e){
		echo '{"error": {"text": '.$e->getMessage().'}';
	}

});

//Login
// $app->get('/api/customer/login',function() use($app) {
//     $req = $app->request();
//     $requiredfields = array(
//         'email',
//         'customer_password'
//     );
//     // validate required fields
//     if(!RequiredFields($req->get(), $requiredfields)){
//         return false;
//     }
//     $email = $req->get("email");
//     $customer_password = $req->get("customer_password");
//     global $conn;
//     $sql='SELECT * from users where EmailAddress="'.$email.'" and customer_password="'.$customer_password.'"';
//     $rs=$conn->query($sql);
//     $arr = $rs->fetch_array(MYSQLI_ASSOC);
//     if($arr == null){
//         echo json_encode(array(
//             "error" => 1,
//             "message" => "Email-id or customer_password doesn't exist",
//         ));
//         return;
//     }
//     echo json_encode(array(
//         "error" => 0,
//         "message" => "User logged in successfully",
//         "users" => $arr
//     ));
// });


