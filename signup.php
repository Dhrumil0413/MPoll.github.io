<?php
require_once("db.php");

function test_input ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();
$email = "";
$UserName = "";
$password = "";
$Avatar = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["Mail-Address"]);
    $UserName = test_input($_POST["UserName"]);
    $password = test_input($_POST["password"]);

    $passwordregex = "/^(?=.*[A-Za-z]).+$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $emailregex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    if (!preg_match($emailregex, $email)) {
        $errors["email"] = "Invalid Email Address";
    }
    if (!preg_match($unameRegex, $UserName)) {
        $errors["UserName"] = "Invalid UserName";
    }
    if (!preg_match($passwordregex, $password)) {
        $errors["password"] = "Invalid Password";
    }

    $target_file = "";

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        die ("PDO Error: Connection Failed " . $e->getMessage());
    }

    $query = "SELECT COUNT(*) AS Count FROM Users WHERE UserName = '$UserName' OR EmailAddress = '$email' ";

    $result = $db->query($query);

    $match = $result->fetch()['Count'];

    if ($match) {
        $errors["Account Taken"] = "A user with same UserName already exists.";
    }

    if (empty($errors)) {
        $query = "INSERT INTO Users (EmailAddress, password, UserName, Avatar) VALUES ('$email', '$password', '$UserName', 'img/GuestAvatar.png')";
        $result = $db->exec($query);

        if (!$result) {
            $errors["Database Error:"] = "Failed to Insert User";
        }
        else {
            $target_dir = "uploads/";
            $uploadOk = TRUE;

            $imageFileType = strtolower(pathinfo($_FILES["AvatarImage"]["name"], PATHINFO_EXTENSION));
            $uid = $db->lastInsertId();

            $target_file = "uploads/" . $uid . "." . $imageFileType;

            if (file_exists($target_file)) {
                $errors["AvatarImage"] = "Sorry, file already exists;";
                $uploadOk = FALSE;
            }

            if ($_FILES["AvatarImage"]["size"] > 1000000) {
                $errors["AvatarImage"] = "File is too large. Maximum 1MB.";
                $uploadOk = FALSE;
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors["AvatarImage"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadOk = FALSE;
            }

            if ($uploadOk) {
                $fileStatus = move_uploaded_file($_FILES["AvatarImage"]["tmp_name"], $target_file);

                if (!$fileStatus) {
                    $errors["Server Error"] = "File Transfer Failed";
                    $uploadOk = FALSE;
                } 

            }

            if (!$uploadOk) {
                $query = "DELETE FROM Users WHERE UserId = '$uid'";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error:"] = "could not delete user when avatar upload failed";
                }
                $db = null;
            }
            else {
                $query = "UPDATE Users SET Avatar = '$target_file' WHERE UserId = '$uid'";
                $result = $db->exec($query);

                if (!$result) {
                    $errors["Database Error:"] = "Could not update avatar_url";
                }
                else {
                    $db = null;

                    header("Location: login.php");

                    exit();
                }
            }
        }
    }

    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Mpoll SignUp</title>
    <script src="js/eventHandler.js"></script>
</head>
<body>
    <div id="NavBar">
        <ul>
            <li><a href="HomePage.php"  class="PagesOptions">MyPoll</a></li>
            <li><a href="NewPoll.php" class="PagesOptions">NewPoll</a></li>
            <li><a href="YourVote.php" class="PagesOptions">YourVote</a></li>
            <li><a href="Results.php" class="PagesOptions">Results</a></li>
            <li><img src="img/GuestAvatar.png" alt="GuestNinja" id="GuestNinja" /></li>
        </ul>
    </div>
    <main id="main-SingupPage">
        <div class="container">
            <div class="SignUp-Fields">
                <div class="SignUp-info">
                    <form action="" method="post" id="signup-form" enctype="multipart/form-data">
                        <div id="Main-Avatar">
                            <img src="img/GuestAvatar.png" alt="GuestAvatar" id="SignUpMainAvatar" />                    
                            <p>Select Avatar From Below</p>
        
                            <input type="file" name="AvatarImage" id="ChosenOne" />
                            <p class="error-text <?= isset($errors['AvatarImage'])?'':'hidden' ?>">Avatar Not Valid</p>
                        </div>

                        <input type="email" name="Mail-Address" id="Mail-Address" placeholder="Mail-Address" />
                        <p class="error-text <?= isset($errors['email'])?'':'hidden' ?>">Mail-Address is Invalid</p>

                        <input type="text" name="UserName" id="UserName" placeholder="UserName"/>
                        <p class="error-text <?= isset($errors['UserName'])?'':'hidden' ?>">UserName is Invalid</p>

                        <input type="password" name="password" id="password" placeholder="password"/>
                        <p class="error-text <?= isset($errors['password'])?'':'hidden' ?>">Password is Invalid</p>

                        <input type="password" name="Confirmed-Password" id="Confirmed-Password" placeholder="Confirmed-Password"/>
                        <p class="error-text <?= isset($errors['password'])?'':'hidden' ?>">Password is Invalid</p>

                        <input type="submit" value="SignUp" id="SignUp" />
                    </form>
                    <p>Already have an Account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </main>
    <script src="js/eventRegisterSignUp.js"></script>
</body>
</html>