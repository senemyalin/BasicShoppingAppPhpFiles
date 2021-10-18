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
$password = $_POST['password'];
$new_password = $_POST['new_password'];
$new_password2 = $_POST['new_password2'];

if($password == '' || $new_password == '' || $new_password2 == '') {
    $data = ['message' => 'Blanks must be filled!'];
}
else if($new_password == $new_password2){
    $query = $db->prepare("SELECT password from users WHERE id = :user_id" );
    $query->execute(array(":user_id"=>$user_id));
    $db_password = $query->fetchAll();

    if($password == $db_password[0]['password']){
        $query = $db->prepare("UPDATE users SET password = :password WHERE id= :user_id");
        $query->execute(array(":password"=>$new_password,   ":user_id"=>$user_id));

        $data = ['message' => 'Your password is changed!'];
    }
    else{
        $data = ['message' => 'Your password is wrong!'];
    }
}
else{
    $data = ['message' => 'Your new passwords did not match.'];
}

echo json_encode($data);

?>