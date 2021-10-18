<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=basicshoppingapp", "test", "test");
} catch (PDOException $e) {
    print $e->getMessage();
}

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>

<?php

$user_id = $_POST['user_id'];
$address_name = $_POST['address_name'];




$query = $db->prepare("SELECT * from address where user_id = :user_id AND address_name = :address_name");
$query->execute(array(':user_id' => $user_id, ':address_name' => $address_name));
$result = $query->fetchAll();

if(count($result) > 0){
    $query = $db->prepare("DELETE from address WHERE user_id = :user_id AND address_name = :address_name");
    $query->execute(array(':user_id'=> $user_id,':address_name'=>$address_name));

    $data = ['message' => 'Success!'];
}
else{

    $data = ['message' => 'Failed!'];
}



echo json_encode($data);
?>