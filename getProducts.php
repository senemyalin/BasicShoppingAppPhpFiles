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

$query = $db->prepare("select * from address where id = :address_id");
$query->execute(array(":address_id"=>$address_id));
$chosen_address = $query->fetch(PDO::FETCH_ASSOC);



$product = $db->query("select * from product", PDO::FETCH_ASSOC);
$category = $db->query("select * from category", PDO::FETCH_ASSOC);
$market = $db->query("select * from market", PDO::FETCH_ASSOC);


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

$data['product'] = [];
$data['category'] = [];
$data['market'] = [];

foreach($product as $row){
    $y = 0;
    while (count($old_data['chosen_market_id']) != $y ){
        if($old_data['chosen_market_id'][$y] == $row['market_id']){
            array_push($data['product'], ($row));
        }
        $y++;
    }

}

foreach($category as $row1){
    array_push($data['category'], ($row1));}

foreach($market as $row2 ){
    array_push($data['market'], ($row2));}

echo json_encode($data);

$db = null;

?>