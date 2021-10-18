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

$query = $db->prepare("SELECT product_id from favourite_product where user_id = :user_id");
$query->execute(array(':user_id' => $user_id));
$product_id = $query->fetchAll();

$data['product'] = [];
$data['message'] = [];
if(count($product_id) > 0) {

    $i = 0;

    while($i != count($product_id)) {


        $query = $db->prepare("SELECT * from product where id = :product_id");
        $query->execute(array(':product_id'=> $product_id[$i]['product_id']));
        $favourite_product = $query->fetch(PDO::FETCH_ASSOC);

        array_push($data['product'], ($favourite_product));

        $i++;
    }
    array_push($data['message'],true);
}
else
    array_push($data['message'],false);

echo json_encode($data);
?>
