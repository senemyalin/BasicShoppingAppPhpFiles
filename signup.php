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
$userFullname = $_POST['fullname'];
$userPassword = $_POST['password'];
$userPhonenumber = $_POST['phonenumber'];

$data['message'] = [];

if($userEmail == '' || $userFullname == '' || $userPassword == '' || $userPhonenumber == ''){

    array_push($data['message'], 'Full name, Email, Password or Phone number can not be empty');

}else{
    $query = $db->query("select * from users where email = '{$userEmail}'", PDO::FETCH_ASSOC);
    $recordExists = $query->fetch(PDO::FETCH_ASSOC);

    if($recordExists){
        array_push($data['message'], 'User already exists');
    }else{
        $hash_userPassword = md5($userPassword,false);
        $query = $db->prepare("INSERT INTO users(fullname, email, password, phonenumber) VALUES (?,?,?,?)");
        $insert = $query->execute(array($userFullname, $userEmail, $hash_userPassword, $userPhonenumber));

        if($query){
            array_push($data['message'], 'User registered successfully');
        }else{
            array_push($data['message'], 'Oops! please try again!');
        }
    }
}
echo json_encode($data);
$db = null;
?>