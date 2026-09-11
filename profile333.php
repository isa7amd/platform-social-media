<?php

require "con.php";

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if(!isset($_COOKIE['user_id'])){

    header("Location: projectlogin333.php");

    exit();

}



$error = [];

$success = "";



// GET USER DATA

$sql = "
SELECT *
FROM users
WHERE user_id=:user_id
";


$statement = $conn->prepare($sql);


$statement->execute([

    ":user_id"=>$_COOKIE['user_id']

]);


$user = $statement->fetch(PDO::FETCH_ASSOC);



if(!$user){

    echo "USER DOES NOT EXIST";

    exit();

}





// UPDATE NAME

if(isset($_POST['update_name'])){


    $newName = trim($_POST['fullname']);



    if(empty($newName)){


        $error[]="PLEASE ENTER YOUR FULL NAME";


    }



    if(empty($error)){



        $sql="
        UPDATE users
        SET full_name=:full_name
        WHERE user_id=:user_id
        ";



        $statement=$conn->prepare($sql);



        $statement->execute([


            ":full_name"=>$newName,


            ":user_id"=>$_COOKIE['user_id']


        ]);



        // Update cookie instead of session

        setcookie(

            "full_name",

            $newName,

            time()+3600,

            "/"

        );



        $user['full_name']=$newName;


        $success="NAME UPDATED SUCCESSFULLY";


    }


}






// CHANGE PASSWORD


if(isset($_POST['update_password'])){


    $currentPassword=$_POST['current_password'];

    $newPassword=$_POST['new_password'];

    $confirmPassword=$_POST['confirm_new_password'];



    if(empty($currentPassword)){


        $error[]="PLEASE ENTER YOUR CURRENT PASSWORD";


    }

    elseif(!password_verify($currentPassword,$user['password_hash'])){


        $error[]="CURRENT PASSWORD IS INCORRECT";


    }





    // PASSWORD VALIDATION


    if(strlen($newPassword)<8){


        $error[]="PASSWORD MUST BE AT LEAST 8 CHARACTERS";


    }



    if(!preg_match("/[A-Z]/",$newPassword)){


        $error[]="PASSWORD MUST CONTAIN ONE CAPITAL LETTER";


    }



    if(!preg_match("/[a-z]/",$newPassword)){


        $error[]="PASSWORD MUST CONTAIN ONE SMALL LETTER";


    }



    if(!preg_match("/[0-9]/",$newPassword)){


        $error[]="PASSWORD MUST CONTAIN ONE NUMBER";


    }



    if(!preg_match("/[\W]/",$newPassword)){


        $error[]="PASSWORD MUST CONTAIN ONE SPECIAL CHARACTER";


    }




    if($newPassword != $confirmPassword){


        $error[]="PASSWORD AND CONFIRM PASSWORD MUST MATCH";


    }




    if(empty($error)){



        $newHash=password_hash(

            $newPassword,

            PASSWORD_DEFAULT

        );



        $sql="
        UPDATE users
        SET password_hash=:password_hash
        WHERE user_id=:user_id
        ";



        $statement=$conn->prepare($sql);



        $statement->execute([


            ":password_hash"=>$newHash,


            ":user_id"=>$_COOKIE['user_id']


        ]);



        $success="PASSWORD UPDATED SUCCESSFULLY";


    }


}



?>

<?php

include "nav333.php";

?>

<!DOCTYPE html>
<html>


<head>

<meta charset="utf-8">

<title>EDIT PROFILE</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="project.css" rel="stylesheet">

</head>


<body>


<h2>

EDIT PROFILE

</h2>



<?php


if(!empty($error)){


    echo "<ul style='color:red;'>";


    foreach($error as $e){


        echo "<li>".htmlspecialchars($e)."</li>";


    }


    echo "</ul>";


}



if($success){


    echo "<p style='color:green;'>".

    htmlspecialchars($success).

    "</p>";


}


?>



<h3>

UPDATE FULL NAME

</h3>



<form method="post">


<label>

FULL NAME

</label>


<br>


<input

type="text"

name="fullname"

value="<?php echo htmlspecialchars($user['full_name']); ?>"

>


<br><br>


<button type="submit" name="update_name">

UPDATE NAME

</button>


</form>





<hr>





<h3>

CHANGE PASSWORD

</h3>





<form method="post">


<label>

CURRENT PASSWORD

</label>


<br>


<input

type="password"

name="current_password"

>


<hr>



<label>

NEW PASSWORD

</label>


<br>


<input

type="password"

name="new_password"

minlength="8"

>


<hr>



<label>

CONFIRM NEW PASSWORD

</label>


<br>


<input

type="password"

name="confirm_new_password"

minlength="8"

>


<br><br>



<button type="submit" name="update_password">

CHANGE PASSWORD

</button>



</form>



<br>


<a href="projecthome333.php">

BACK TO HOME

</a>



</body>

</html>