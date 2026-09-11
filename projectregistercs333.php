<?php

require "con.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error = [];

$name = "";
$email = "";

if(isset($_POST['send'])){

    $name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // FULL NAME
    if(empty($name)){
        $error[] = "PLEASE ENTER THE FULL NAME";
    }

    // EMAIL
    if(empty($email)){
        $error[] = "PLEASE ENTER AN EMAIL";
    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error[] = "PLEASE ENTER A VALID EMAIL";
    }

    // PASSWORD
    if(empty($password)){
        $error[] = "PLEASE ENTER A PASSWORD";
    }

    // CONFIRM PASSWORD
    if(empty($confirm)){
        $error[] = "PLEASE ENTER CONFIRM PASSWORD";
    }

    // PASSWORD MATCH
    if($password != $confirm){
        $error[] = "PASSWORD AND CONFIRM PASSWORD MUST MATCH";
    }

    // PASSWORD STRENGTH

    if(strlen($password) < 8){
        $error[] = "PASSWORD MUST BE AT LEAST 8 CHARACTERS";
    }

    if(!preg_match("/[A-Z]/",$password)){
        $error[] = "PASSWORD MUST CONTAIN ONE CAPITAL LETTER";
    }

    if(!preg_match("/[a-z]/",$password)){
        $error[] = "PASSWORD MUST CONTAIN ONE SMALL LETTER";
    }

    if(!preg_match("/[0-9]/",$password)){
        $error[] = "PASSWORD MUST CONTAIN ONE NUMBER";
    }

    if(!preg_match("/[\W]/",$password)){
        $error[] = "PASSWORD MUST CONTAIN ONE SPECIAL CHARACTER";
    }

    // CHECK UNIQUE EMAIL

    if(empty($error)){

        $sql = "SELECT * FROM users WHERE email=:email";

        $statement = $conn->prepare($sql);

        $statement->execute([
            ":email"=>$email
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user){
            $error[] = "EMAIL ALREADY EXISTS";
        }

    }

    // INSERT USER

    if(empty($error)){

        $password_hash = password_hash($password,PASSWORD_DEFAULT);

        $sql = "
        INSERT INTO users(email,password_hash,full_name)
        VALUES(:email,:password_hash,:full_name)
        ";

        $statement = $conn->prepare($sql);

        $statement->execute([

            ":email"=>$email,

            ":password_hash"=>$password_hash,

            ":full_name"=>$name

        ]);

        header("Location: projectlogin333.php");
        exit();

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">

<title>REGISTRATION</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

</head>

<body>

<h2>REGISTER</h2>

<?php

if(!empty($error)){

    echo "<ol>";

    foreach($error as $e){

        echo "<li>".htmlspecialchars($e)."</li>";

    }

    echo "</ol>";

}

?>

<form action="" method="post">

<label for="fullname">

FULL NAME

</label>

<br>

<input
type="text"
name="fullname"
id="fullname"
placeholder="ENTER YOUR FULL NAME"
required
value="<?php echo htmlspecialchars($name); ?>">

<hr>

<label for="email">

EMAIL

</label>

<br>

<input
type="email"
name="email"
id="email"
placeholder="ENTER YOUR EMAIL"
required
value="<?php echo htmlspecialchars($email); ?>">

<hr>

<label for="password">

PASSWORD

</label>

<br>

<input
type="password"
name="password"
id="password"
placeholder="ENTER YOUR PASSWORD"
required
minlength="8">

<hr>

<label for="confirm_password">

CONFIRM PASSWORD

</label>

<br>

<input
type="password"
name="confirm_password"
id="confirm_password"
placeholder="CONFIRM YOUR PASSWORD"
required
minlength="8">

<hr>

<button type="submit" name="send">

REGISTER

</button>

<br><br>

<a href="projectlogin333.php">
I ALREADY HAVE AN ACCOUNT
</a>
</form>
</body>
</html>
