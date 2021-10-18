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
$address_id = $_POST['address_id'];

$query = $db->prepare("SELECT * from address where user_id = :user_id");
$query->execute(array(':user_id' => $user_id));
$address = $query->fetchAll();

$data['message'] = [];
$data['address'] = [];

$i = 0;

while($i != count($address)) {

    if ($address[$i]['chosen'] == "True") {
        $query = $db->prepare("UPDATE address SET chosen = :chosen WHERE user_id = :user_id AND id = :address_id");
        $query->execute(array(":chosen" => "False", ":user_id" => $user_id, ":address_id" => $address[$i]["id"]));
        break;
    }
    $i++;
}

$query = $db->prepare("UPDATE address SET chosen = :chosen WHERE user_id = :user_id AND id = :address_id");
$query->execute(array(":chosen" => "True", ":user_id" => $user_id, ":address_id" => $address_id));


$query = $db->prepare("SELECT * from address where user_id = :user_id AND id = :address_id");
$query->execute(array(":user_id" => $user_id, ":address_id" => $address_id));
$chosen_address = $query->fetch(PDO::FETCH_ASSOC);

array_push($data['address'], $chosen_address);
array_push($data['message'],"true");




echo json_encode($data);

?>