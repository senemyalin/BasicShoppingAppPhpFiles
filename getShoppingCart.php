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

$address_id = $_POST['address_id'];
$user_id = $_POST['user_id'];



$query = $db->prepare("select * from address where id = :address_id");
$query->execute(array(":address_id"=>$address_id));
$chosen_address = $query->fetch(PDO::FETCH_ASSOC);


$query = $db->prepare("select * from market");
$query->execute();
$all_market = $query->fetchAll();

$old_data['chosen_market_id'] = [];

$i = 0;
while ($i != count($all_market)){
    if($all_market[$i]['country'] == $chosen_address['country'] AND
        $all_market[$i]['city'] == $chosen_address['city'] AND
        $all_market[$i]['district'] == $chosen_address['district']){
        array_push($old_data['chosen_market_id'], $all_market[$i]['id']);
    }
    $i++;
}

$query = $db->prepare("SELECT * from shopping_cart where user_id = :user_id");
$query->execute(array(':user_id'=> $user_id));
$result = $query->fetchAll();

$data['product'] = [];
$data['count'] = [];
$data['message'] = [];

if(count($result) > 0) {
    $i = 0;

    while($i != count($result)){

        $product_id = $result[$i]['product_id'];
        $product_count = $result[$i]['count'];

        $query = $db->prepare("SELECT * from product where id = :product_id");
        $query->execute(array(':product_id' => $product_id));
        $last_result = $query->fetch(PDO::FETCH_ASSOC);


        $y = 0;
        while (count($old_data['chosen_market_id']) != $y ){
            if($old_data['chosen_market_id'][$y] == $last_result['market_id']) {
                array_push($data['product'], ($last_result));
                array_push($data['count'], ($product_count));
            }
            $y++;
        }
        $i++;
    }
    array_push($data['message'],true);
}


else
    array_push($data['message'], false);

echo json_encode($data);

?>