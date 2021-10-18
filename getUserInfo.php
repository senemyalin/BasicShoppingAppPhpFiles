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

$query = $db->prepare("SELECT * from users WHERE id= :user_id");
$query->execute(array(":user_id"=>$user_id));
$results = $query->fetch(PDO::FETCH_ASSOC);

$data['user'] = [];
$data['message'] = [];
if (count($results) >0){
    array_push($data['user'],$results);
    array_push($data['message'], true);
}
else
    array_push($data['message'], false);

echo json_encode($data);


?>