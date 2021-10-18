<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=basicshoppingapp", "test", "test");
} catch (PDOException $e) {
    print $e->getMessage();
}

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<?php

$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$ctt = $_POST['count'];


$query = $db->prepare("SELECT * from shopping_cart where user_id = :user_id AND product_id = :product_id");
$query->execute(array(':user_id' => $user_id, ':product_id' => $product_id));
$result = $query->fetchAll();

if (count($result) > 0) {

    $new_count = $result[0]['count'] + $ctt;

    //add to shopping cart
    if ($new_count <= 0) {
        $query = $db->prepare("DELETE from shopping_cart WHERE user_id = :user_id AND product_id = :product_id");
        $query->execute(array(':user_id' => $user_id, ':product_id' => $product_id));

        $data = ['message' => 'Product is deleted from SC.'];
        echo json_encode($data);
    } else {
        $query = $db->prepare("UPDATE shopping_cart SET count = :count WHERE user_id = :user_id AND product_id = :product_id");
        $query->execute(array(':count' => $new_count, ':user_id' => $user_id, ':product_id' => $product_id));

        $data = ['message' => 'There is the product in SC.', 'product_id' => $result[0]['product_id'], 'count' => $new_count];
        echo json_encode($data);
    }

} else {
    $query = $db->prepare("INSERT INTO shopping_cart(user_id,product_id,count) VALUES (:user_id,:product_id,:count)")->execute(array(':count' => $ctt, ':user_id' => $user_id, ':product_id' => $product_id));

    $data = ['message' => 'There is no this product in SC.', 'product_id' => $product_id, 'count' => $ctt];

    echo json_encode($data);
}

?>
