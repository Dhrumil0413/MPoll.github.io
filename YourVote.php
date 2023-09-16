<?php
    session_start();
    require_once("db.php");

    // Check whether the user has logged in or not.
    if (isset($_SESSION["Avatar"])) {
        $Avatar = $_SESSION["Avatar"];

    }
    else {
        $Avatar = "img/GuestAvatar.png";
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
    $query = "SELECT Users.UserName, Users.Avatar, Polls.GenerationTime, Polls.PollId, Polls.Question, GROUP_CONCAT(Options.OptionText ORDER BY Options.OptionId ASC SEPARATOR '_ ') AS Options, Polls.LastVoteDate FROM Users INNER JOIN Polls ON Users.UserId = Polls.UserId LEFT JOIN Options ON Polls.PollId = Options.PollId GROUP BY Polls.PollId ORDER BY Polls.GenerationTime DESC";
    // query ends;

    $result = $db->query($query);
    if (!$result) {
        $errors["Database Error"] = "Could not retrieve User Informatoin";
    }
    elseif ($result->rowCount() == 0) {
        echo "<p>No Polls Available at this moment.</p>";
    }

    
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/eventHandler.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <title>Mpoll YourVote</title>
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
    <div id="main-YourVote">
        <div class="MyPoll-mainContent">
            <?php 
                $increase = 1;
                while ($row = $result->fetch()) {
                    $OptionArray = explode("_ ", $row["Options"]);
            ?>
                    <div class="MyPoll-Containers">
                        <div class="UserAvatar-Name">
                            <img src="<?= $row['Avatar'] ?>" alt="<?= $row['Avatar'] ?>" class="Avatar-images" />
                            <small class="UserName"><?= $row["UserName"] ?></small>
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
                                    <div class="graph-container <?='i'.$row["PollId"]?>" style="display:none;">
                                        <div class="graph-bar" id="graph-barA" style="width:0%">
                                            <span class="graph-label">x%</span>
                                        </div>
                                    </div>
                                    <br />
            <?php
                
                                $increase = $increase + 1;
                            }
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
    </div>
    <script src="js/eventRegisterYourVote.js"></script>    
</body>
</html>