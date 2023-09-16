<?php
    session_start();
    require_once("db.php");

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

?>

<?php

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    }
    catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    // query starts;
    $query = "SELECT Users.UserName, Users.Avatar, Polls.GenerationTime, Polls.PollId, Polls.Question, GROUP_CONCAT(Options.OptionText ORDER BY Options.OptionId ASC SEPARATOR '_ ') AS Options, Polls.LastVoteDate FROM Users INNER JOIN Polls ON Users.UserId = Polls.UserId LEFT JOIN Options ON Polls.PollId = Options.PollId WHERE Users.UserId = '$UserId' GROUP BY Polls.PollId ORDER BY Polls.GenerationTime DESC LIMIT 5";
    // query ends;

    $result = $db->query($query);
    if (!$result) {
        $errors["Database Error"] = "Could not retrieve User Informatoin";
    }
    elseif ($result->rowCount() == 0) {
        echo "<p>No Polls Available at this moment.</p>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            ?>
            WHERE OptionText = :selectedOptionIndex LIMIT 1";

            $stmt = $db->prepare($query);
            // Bind the parameter
            $stmt->bindParam(':selectedOptionIndex', $selectedOptionIndex, PDO::PARAM_STR);
            // Execute the prepared statement
            $stmt->execute();

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
?>



<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title>MyPolls</title>
</head>
<body>
    <div id="NavBar">
        <ul>
            <li><a href="HomePage.php"  class="PagesOptions">MyPoll</a></li>
            <li><a href="NewPoll.php" class="PagesOptions">NewPoll</a></li>
            <li><a href="YourVote.php" class="PagesOptions">YourVote</a></li>
            <li><a href="Results.php" class="PagesOptions">Results</a></li>
            <li><a href="logout.php" class="PagesOptions">Logout</a></li>
            <li><img src="<?= $Avatar ?>" alt="GuestNinja" id="GuestNinja" /></li>
        </ul>
    </div>
    <main id="main-Homepage">
        <div class="MyPoll-mainContent">
            <?php 
                $increase = 1;
                while ($row = $result->fetch()) {
                    $OptionArray = explode("_ ", $row["Options"]);
            ?>
                    <div class="MyPoll-Containers">
                        <div class="UserAvatar-Name">
                            <img src="<?= $Avatar ?>" alt="<?= $Avatar ?>" class="Avatar-images" />
                            <small class="UserName"><?= $UserName ?></small>
                        </div>
                        <div class="OtherContent">
                            <div class="HomeQuestion-Zone">
                                <p><?=$row["Question"]?></p>
                                <form action="" class="Poll-Options" method="post">
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
                            list($Date, $time) = explode(" ", $row["GenerationTime"]);
            ?>
                                <input type="submit" value="Vote" class="Vote-btn" />
                            </div>
                        </form>
                    </div>
                    <div class="Recent-Vote">
                        <p>Recent Vote:</p>
                    </div>
                </div>
                <div class="timeZone-HomePage">
                    <div class="QuestionTimeZone">
                        Day: <span class="Date"><?= $Date ?></span>
                        Time: <span class="Time"><?= $time ?></span>
                    </div>
                    <?php
                    if ($row["LastVoteDate"] != null) {
                        list($Date, $time) = explode(" ", $row["LastVoteDate"]);
                    }
                    ?>
                    <div class="RecentTimeZone">
                        <p class="DateTimePara">
                            Day: <span class="Recent-Date"><?= $Date ?></span>
                            Time: <span class="Recent-Time"><?= $time ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
                                
                                
                
        </div>
    </main>
</body>
</html>
