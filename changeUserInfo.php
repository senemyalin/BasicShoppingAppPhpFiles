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
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$fullname = $_POST['full_name'];

$query = $db->prepare("SELECT * from users WHERE id = :user_id");
$query->execute(array(":user_id"=>$user_id));
$results = $query->fetchAll();

$data['message'] = [];

if($email != $results[0]['email']){
    $query = $db->prepare("UPDATE users SET email = :email WHERE id = :user_id");
    $query->execute(array(":email"=>$email, ":user_id"=>$user_id));
    array_push($data['message'],"Your email is changed.");
}
if($phone_number != $results[0]['phonenumber']){
    $query = $db->prepare("UPDATE users SET phonenumber = :phonenumber WHERE id = :user_id");
    $query->execute(array(":phonenumber"=>$phone_number, ":user_id"=>$user_id));
    array_push($data['message'],"Your phone number is changed.");
}
if($fullname != $results[0]['fullname']){
    $query = $db->prepare("UPDATE users SET fullname = :fullname WHERE id = :user_id");
    $query->execute(array(":fullname"=>$fullname, ":user_id"=>$user_id));
    array_push($data['message'],"Your full name is changed.");
}

echo json_encode($data);

?>
