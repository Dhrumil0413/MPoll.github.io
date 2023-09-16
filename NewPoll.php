<?php
    session_start();
    require_once("db.php");

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); //encodes
        return $data;
    }
    // Check whether the user has logged in or not.
    if (!isset($_SESSION["UserId"])) {
        header("Location: login.php");
        exit();
    }
    else {
        $UserId = $_SESSION["UserId"];
        $UserName = $_SESSION["UserName"];
        $Avatar = $_SESSION["Avatar"];
    }

    $errors = array();
    $Question = "";
    $Op1 = "";
    $Op2 = "";
    $Op3 = "";
    $Op4 = "";
    $Op5 = "";
    $OpenTime = "";
    $OpenDate = "";
    $CloseTime = "";
    $CloseDate = "";
    $isDataOk = TRUE;
    $OptionCount = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Question = test_input($_POST["Question"]);
        $Op1 = test_input($_POST["Op1"]);
        $Op2 = test_input($_POST["Op2"]);
        $Op3 = test_input($_POST["Op3"]);
        $Op4 = test_input($_POST["Op4"]);
        $Op5 = test_input($_POST["Op5"]);
        $OpenTime = test_input($_POST["OpenTime"]);
        $OpenDate = test_input($_POST["OpenDate"]);
        $CloseTime = test_input($_POST["CloseTime"]);
        $CloseDate = test_input($_POST["CloseDate"]);

        $TimeRegEx = "/^(0\d|1\d|2[0-3]):([0-5]\d)$/";
        $DateRegEx = "/^\d{4}[-]\d{2}[-]\d{2}$/";
        $QuestionRegEx = "/\S/";

        if (strlen($Op1) >= 1) {
            $OptionCount = $OptionCount + 1;
        }
        if (strlen($Op2) >= 1) {
            $OptionCount = $OptionCount + 1;
        }
        if (strlen($Op3) >= 1) {
            $OptionCount = $OptionCount + 1;
        }
        if (strlen($Op4) >= 1) {
            $OptionCount = $OptionCount + 1;
        }
        if (strlen($Op5) >= 1) {
            $OptionCount = $OptionCount + 1;
        }
        if (!preg_match($QuestionRegEx, $Question)) {
            $errors["NoQuestion Asked"] = "There is't any question input";
            $isDataOk = FALSE;
        }
        if ($OptionCount < 2) {
            $errors["Options"] = "At least two Otions";
            $isDataOk = FALSE;
        }
        if (!preg_match($TimeRegEx, $OpenTime)) {
            $errors["OpenTime"] = "Input time is invalid";
            $isDataOk = FALSE;
        }
        if (!preg_match($DateRegEx, $OpenDate)) {
            $errors["OpenDate"] = "Input Date is invalid";
            $isDataOk = FALSE;
        }
        if (!preg_match($TimeRegEx, $CloseTime)) {
            $errors["CloseTime"] = "Input time is invalid";
            $isDataOk = FALSE;
        }
        if (!preg_match($DateRegEx, $CloseDate)) {
            $errors["CloseDate"] = "Input Date is invalid";
            $isDataOk = FALSE;
        }

       


        if ($isDataOk) {
            try {
                $db = new PDO($attr, $db_user, $db_pwd, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }

            $OpenTime = $OpenDate . " " . $OpenTime;
            $CloseTime = $CloseDate . " " . $CloseTime;

            $query = "INSERT INTO Polls (UserId, StartDateTime, CloseDateTime, Question, GenerationTime ) VALUES ('$UserId', '$OpenTime', '$CloseTime', '$Question', NOW())";
            $result = $db->exec($query);

            if ($result !== FALSE) {
                $pollid = $db->lastInsertId();
                $ExtraValues = "";
                if (strlen($Op3) >= 1) {
                    $ExtraValues .= ", ('$pollid', '$Op3')";
                }
                if (strlen($Op4) >= 1) {
                    $ExtraValues .= ", ('$pollid', '$Op4')";
                }
                if (strlen($Op5) >= 1) {
                    $ExtraValues .= ", ('$pollid', '$Op5')";
                }
                $query = "INSERT INTO Options (PollId, OptionText) VALUES ('$pollid', '$Op1'), ('$pollid', '$Op2')" . $ExtraValues;
                $result = $db->exec($query);

                if ($result !== FALSE) {
                    $db = null;
                    header("Location: HomePage.php");
                    exit();
                }
                else {
                    $errors["Database Error"] = "Failed to Insert Options";
                }

            }
            else { 
                $errors["Database Error"] = "Failed to Insert Poll";
            }
        }

        if (!empty($errors)) {
            foreach($errors as $errorKey => $Message) {
                print("$errorKey: $Message \n<br />");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/eventHandler.js"></script>
    <title>NewPoll</title>
</head>
<body>
    <div id="NavBar">
        <ul>
            <li><a href="HomePage.php"  class="PagesOptions">MyPoll</a></li>
            <li><a href="NewPoll.php" class="PagesOptions">NewPoll</a></li>
            <li><a href="YourVote.php" class="PagesOptions">YourVote</a></li>
            <li><a href="Results.php" class="PagesOptions">Results</a></li>
            <li><img src="<?= $Avatar ?>" alt="GuestNinja" id="GuestNinja" /></li>
        </ul>
    </div>

    <main id="main-NewPollPage">
        <div class="Container-Box">
            
            <form class="DateTime-NewPoll-Container" action="" method="post">
                <div>
                    <input type="text" name="Question" id="Question-Input" placeholder="Input Your Question"  />
                    <p class="error-text <?= isset($errors['Question'])?'':'hidden' ?> wordLimit">Input Question invalid</p>  
                
                    <input type="text" name="Op1" class="OptionSelection" placeholder="Write Option" />
                    <p class="error-text <?= isset($errors['Op1'])?'':'hidden' ?> wordLimit">Input is Invalid</p>
                    
                    <input type="text" name="Op2" class="OptionSelection" placeholder="Write Option" />
                    <p class="error-text <?= isset($errors['Op2'])?'':'hidden' ?> wordLimit">Input is Invalid</p>

                    <input type="text" name="Op3" class="OptionSelection" placeholder="Write Option" />
                    <p class="error-text <?= isset($errors['Op3'])?'':'hidden' ?> wordLimit">Input is Invalid</p>

                    <input type="text" name="Op4" class="OptionSelection" placeholder="Write Option" />
                    <p class="error-text <?= isset($errors['Op4'])?'':'hidden' ?> wordLimit">Input is Invalid</p>

                    <input type="text" name="Op5" class="OptionSelection" placeholder="Write Option" />
                    <p class="error-text <?= isset($errors['Op5'])?'':'hidden' ?> wordLimit">Input is Invalid</p>

                    <br />
                    <label for="StartTime-NewPoll" class="NewpollTiming-Labels">Poll Start Time</label>
                    <input type="time" name="OpenTime" id="StartTime-NewPoll" class="NewpollTiming-Input" />
                    <p class="error-text <?= isset($errors['OpenTime'])?'':'hidden' ?>">StartTime is Invalid</p>
                    <br />

                    <label for="StartDate-NewPoll" class="NewpollTiming-Labels">Poll Start Date</label>
                    <input type="date" name="OpenDate" id="StartDate-NewPoll" class="NewpollTiming-Input" />
                    <p class="error-text <?= isset($errors['OpenDate'])?'':'hidden' ?>">StartDate is Invalid</p>
                    <br />

                    <label for="EndTime-NewPoll" class="NewpollTiming-Labels">Poll End Time</label>
                    <input type="time" name="CloseTime" id="EndTime-NewPoll" class="NewpollTiming-Input" />
                    <p class="error-text <?= isset($errors['CloseTime'])?'':'hidden' ?>">EndTime is Invalid</p>
                    <br />
                    
                    <label for="EndDate-NewPoll" class="NewpollTiming-Labels">Poll End Date</label>
                    <input type="date" name="CloseDate" id="EndDate-NewPoll" class="NewpollTiming-Input" />
                    <p class="error-text <?= isset($errors['CloseDate'])?'':'hidden' ?>">EndDate is Invalid</p>

                    <input type="submit" value="Create Poll" id="CreatePoll-btn"/>
                </div>
            </form>
        </div>
    </main>
    <script src="js/eventRegisertNewVote.js"></script>
</body>
</html>