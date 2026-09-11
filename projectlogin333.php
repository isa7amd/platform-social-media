<?php
require "con.php";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$error = [];
$email = "";
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if(empty($email)){
        $error[] = "PLEASE ENTER AN EMAIL";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error[] = "PLEASE ENTER A VALID EMAIL";
    }

    if(empty($password)){
        $error[] = "PLEASE ENTER A PASSWORD";
    }

    if(empty($error)){

        $sql = "
        SELECT *
        FROM users
        WHERE email = :email
        ";

        $statement = $conn->prepare($sql);

        $statement->execute([
            ":email" => $email
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user){

            if(password_verify($password, $user['password_hash'])){

                // Cookies (1 hour)
                setcookie(
                    "user_id",
                    $user['user_id'],
                    time()+3600,
                    "/"
                );

                setcookie(
                    "full_name",
                    $user['full_name'],
                    time()+3600,
                    "/"
                );

                header("Location: projecthome333.php");
                exit();

            }else{

                $error[] = "WRONG PASSWORD";

            }

        }else{

            $error[] = "EMAIL DOES NOT EXIST";

        }

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>LOGIN</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

</head>

<body>

<h2>LOGIN</h2>

<?php

if(!empty($error)){

    echo "<ol>";

    foreach($error as $e){

        echo "<li>".htmlspecialchars($e)."</li>";

    }

    echo "</ol>";

}
?>
<form method="post">
<label for="email">EMAIL</label>
<br>
<input type="email" name="email" id="email" required placeholder="ENTER YOUR EMAIL" value="<?php echo htmlspecialchars($email); ?>">
<hr>
<label for="password">PASSWORD</label>
<br>
<input type="password" name="password" id="password" required minlength="8" placeholder="ENTER YOUR PASSWORD">
<hr>
<button type="submit" name="login">LOGIN</button>
<br><br>
<a href="projectregistercs333.php">DON'T HAVE AN ACCOUNT? REGISTER</a>
</form>
</body>
</html>