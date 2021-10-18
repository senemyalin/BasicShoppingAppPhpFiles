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
$product_id = $_POST['product_id'];

$query = $db->prepare("SELECT * from favourite_product where user_id = :user_id AND product_id = :product_id");
$query->execute(array(':user_id'=> $user_id,':product_id'=>$product_id));
$result = $query->fetchAll();

if(count($result) > 0) {
    $query = $db->prepare("DELETE from favourite_product WHERE user_id = :user_id AND product_id = :product_id");
    $query->execute(array(':user_id'=> $user_id,':product_id'=>$product_id));

    $data = ['message' => 'Product is deleted from FP.'];
}
else{
    $query = $db->prepare("INSERT INTO favourite_product(user_id,product_id) VALUES (:user_id,:product_id)");
    $query->execute(array(':user_id' => $user_id, ':product_id' => $product_id));

    $data = ['message' => 'Product is added to FP.'];
}

echo json_encode($data)
?>
