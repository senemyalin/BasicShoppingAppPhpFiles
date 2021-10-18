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

$query = $db->prepare("SELECT * from address where user_id = :user_id");
$query->execute(array(':user_id' => $user_id));
$address = $query->fetchAll();

$data ['address'] = [];
$data ['message'] = [];

if(count($address) > 0) {

    $i = 0;

    $query = $db->prepare("SELECT * from address where user_id = :user_id");
    $query->execute(array(':user_id' => $user_id));
    $new_address = $query->fetchAll();

    while($i != count($address)) {

        if($new_address[$i]['chosen'] == "True"){
            array_push($data['address'], $new_address[$i]);
            break;
        }
        $i++;
    }
    array_push($data['message'],true);
}
else
    array_push($data['message'],false);

echo json_encode($data);

?>