<?php
require_once("db.php");

function test_input ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors  = array();
$UserName = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}
?>
<!-- php code for main page -->
<?php

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    }
    catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    $FirstTable = null;
    // query starts;
    $query = "SELECT Users.UserName, Users.Avatar, Polls.GenerationTime, Polls.PollId, Polls.Question, GROUP_CONCAT(Options.OptionText ORDER BY Options.OptionId ASC SEPARATOR '_ ') AS Options FROM Users INNER JOIN Polls ON Users.UserId = Polls.UserId LEFT JOIN Options ON Polls.PollId = Options.PollId GROUP BY Polls.PollId ORDER BY Polls.GenerationTime DESC LIMIT 5";
    // query ends;

    $result = $db->query($query);
    if (!$result) {
        $errors["Database Error"] = "Could not retrieve User Informatoin";
    }
    elseif ($result->rowCount() == 0) {
        echo "<p>No Polls Available at this moment.</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['loginSubmit'])) {
            $UserName = test_input($_POST["UserName"]);
            $password = test_input($_POST["Password"]);

            $passwordregex = "/^(?=.*[A-Za-z]).+$/";
            $unameRegex = "/^[a-zA-Z0-9_]+$/";
            $isDataOk = TRUE;

            if (!preg_match($unameRegex, $UserName)) {
                $errors["UserName"] = "Invalid UserName";
                $isDataOk = FALSE;
            }
            if (!preg_match($passwordregex, $password)) {
                $errors["password"] = "Invalid Password";
                $isDataOk = FALSE;
            }

            if ($isDataOk) {
                try {
                    $db = new PDO($attr, $db_user, $db_pwd, $options);
                }
                catch (PDOException $e) {
                    throw new PDOException($e->getMessage(), (int) $e->getCode());
                }

                $query = "SELECT UserId, UserName, Avatar  FROM Users WHERE UserName = '$UserName' AND password = '$password'";
                $result = $db->query($query);

                if (!$result) {
                    $errors["Database Error"] = "Could not retrieve User Informatoin";
                }
                elseif ($row = $result->fetch()) {
                    session_start();

                    $_SESSION['UserId'] = $row['UserId'];
                    $_SESSION['UserName'] = $row['UserName'];
                    $_SESSION['Avatar'] = $row['Avatar'];

                    // $ip = $_SERVER["REMOTE_ADDR"]; //To take out ip address;

                    $db = null;
                    header("Location: HomePage.php");
                    exit();
                }
                else {
                    $errors["Account Exists"] = "No users exists with Details you've provided";
                    $db = null;
                    header("Location: signup.php");
                    exit();
                }
                $db = null;
            }else {
                $errors["Login Failed"] = "You've entered invalid data";
            }
            
            if (!empty($errors)) {
                foreach ($errors as $errorKey => $Message) {
                    print("$errorKey: $Message \n<br />");
                    # code...
                }
            }    
        }
        else  {
            if (isset($_POST['FormType']) && isset($_POST['selected_option'])) {
                $pollId = $_POST['FormType'];               // Poll ID for the current poll
                $selectedOptionIndex = $_POST['selected_option'];  
                $pollId = $pollId;  // Replace with actual value
                $selectedOptionIndex = $selectedOptionIndex;  // Replace with actual value
                try {
                    $db = new PDO($attr, $db_user, $db_pwd, $options);
                }
                catch (PDOException $e) {
                    throw new PDOException($e->getMessage(), (int) $e->getCode());
                }
                $query = "INSERT INTO Vote (OptionId, VoteDateTime)
                SELECT OptionId, NOW()
                FROM Options
                WHERE OptionText = '$selectedOptionIndex' AND Options.PollId = '$pollId' LIMIT 1";
    
                $db->exec($query);

                $query = "UPDATE Polls
                SET LastVoteDate = NOW()
                WHERE PollId = '$pollId'";
                $db->exec($query);
                $db = null; 
    
                // Redirect to another page with the variables as query parameters
                header("Location: Results.php?pollId=$pollId&selectedOptionIndex=$selectedOptionIndex");
                exit(); 
            }
        }
    }
?>

<!DOCTYPE html />
<html lang="en-US">
<head>
    <title>Mpoll Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandler.js"></script>
</head>
<body>
    <div id="NavBar">
        <ul>
            <li><a href="HomePage.php" class="PagesOptions">MyPoll</a></li>
            <li><a href="NewPoll.php" class="PagesOptions">NewPoll</a></li>
            <li><a href="YourVote.php" class="PagesOptions">YourVote</a></li>
            <li><a href="Results.php" class="PagesOptions">Results</a></li>
            <li><img src="img/GuestAvatar.png" alt="GuestNinja" id="GuestNinja" /></li>
        </ul>
    </div>
    <main id="main-page">
        <div class="hotpolls">
            <?php
                $increase = 1;
                while ($row = $result->fetch()) {
                    $OptionArray = explode("_ ", $row["Options"]);

            ?>
                <div class="topPolls-containers">
                <div class="UserAvatar-Name">
                    <img src="<?=$row["Avatar"]?>" alt="ItachiGod-img" class="Avatar-images" />
                    <small class="UserName"><?=$row["UserName"]?></small>
                </div>
                <div class="Question-Zone">
                    <p><?=$row["Question"]?></p>
                    <form action="" class="Poll-Options" method="POST">
                        <div>
                            <input type="hidden" name="FormType" value="<?=$row["PollId"]?>">
                            <?php
                                foreach($OptionArray as $Option) {
                            ?>
                                <input type="radio" name="selected_option" value="<?=$Option?>" id="<?=$increase . $row["PollId"]?>" />
                                <label for="<?=$increase . $row["PollId"]?>">
                                    <?=$Option?>
                                </label>
                                <br />                                
                            <?php
                                $increase = $increase + 1;
                                }
                                $increase = 0;
                            ?>           
                            <input type="submit" value="Vote" class="Vote-btn" name="pollSubmit" />
                        </div>
                    </form>
                </div>
                <div class="timeZone">
                    <span><?=$row["GenerationTime"]?></span>
                </div>
            </div>
            <?php

                }

                $db = null;
            ?>
            
        </div>
        <div class="login-info">
            <div class="form-Content">
                <form action="" method="post" id="login-form">
                    <div>
                        <input type="text" name="UserName" id="UserName" placeholder="UserName" />
                        <p class="error-text <?= isset($errors['UserName'])?'':'hidden' ?>">UserName invalid</p>
                        <input type="password" name="Password" id="Password" placeholder="Password" />
                        <p class="error-text <?= isset($errors['password'])?'':'hidden' ?>">Password invalid</p>
                        <input type="submit" value="Login" id="Login-btn" name="loginSubmit"/>
                    </div>
                </form>
                <p>New to Mpoll? <a href="signup.php">SignUp</a></p>
            </div>            
        </div>
        <script src="js/eventRegisterLogin.js"></script>
    </main>
</body>
</html>