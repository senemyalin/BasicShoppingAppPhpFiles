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

$userEmail = $_POST['email'];
$userPassword = $_POST['password'];

if($userEmail == '' || $userPassword == '' ){
     $data = ['message' => 'Full name, Email, Password or Phone number can not be empty'];
    echo json_encode($data);
}else{
    $query = $db->query("select password from users where email = '$userEmail'", PDO::FETCH_ASSOC);
    $recordExists = $query->fetch(PDO::FETCH_ASSOC);

    if(md5($userPassword,false) == $recordExists["password"]){
        //echo(json_encode(md5($userPassword,false)));
        //echo json_encode($recordExists["password"]);

        $query1 = $db->query("select id from users where email = '$userEmail'", PDO::FETCH_ASSOC);
        $userid = $query1->fetch(PDO::FETCH_ASSOC);

        $data = ['message' => 'Logged in Successfully', 'userid' => $userid["id"] ];
        echo json_encode( $data );

    }else{
        $data = ['message' => 'Email or Password is wrong. Try again.'];

        echo json_encode( $data );
    }
}

$db = null;
?>
