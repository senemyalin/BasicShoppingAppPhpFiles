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
$country = $_POST['country'];
$city = $_POST['city'];
$district = $_POST['district'];

$data['message'] = [];
$data['address'] = [];

if($address_name == '' || $country == '' || $city == '' || $district == ''){

    array_push($data['message'], 'Address name, Country, City or District can not be empty');

}else {

    $query = $db->prepare("SELECT * from address where user_id = :user_id AND address_name = :address_name");
    $query->execute(array(':user_id' => $user_id, ':address_name' => $address_name));
    $result = $query->fetchAll();

    if(count($result) > 0){
        array_push($data['message'], 'You already have this address name!');
    }
    else{
        $query = $db->prepare("INSERT INTO address(user_id,address_name,country,city,district) VALUES (:user_id,:address_name, :country, :city, :district)");
        $query->execute(array(':user_id'=>$user_id,':address_name'=>$address_name,':country'=>$country,':city'=>$city,':district'=>$district));

        $query = $db->prepare("SELECT * from address where user_id = :user_id AND address_name = :address_name");
        $query->execute(array(':user_id' => $user_id, ':address_name' => $address_name));
        $result = $query->fetchAll();

        array_push($data['message'], 'Success!');
        array_push($data['address'], $result[0]);
    }

}

echo json_encode($data);
?>
