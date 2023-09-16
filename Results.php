<?php
    require_once("db.php");

    if (isset($_GET['pollId']) && isset($_GET['selectedOptionIndex'])) {
        $pollId = intval($_GET['pollId']); // Convert to integer
        $selectedOptionIndex = intval($_GET['selectedOptionIndex']);

        $query = "SELECT
        Polls.PollId,
        Polls.Question,
        Users.UserName,
        Polls.LastVoteDate,
        Users.Avatar,
        Polls.GenerationTime
    FROM
        Polls
    INNER JOIN
        Options ON Polls.PollId = Options.PollId
    INNER JOIN
        Users ON Polls.UserId = Users.UserId
    WHERE
        Options.PollId = '$pollId'";

        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $result = $db->query($query);
        $row = $result->fetch();
        
        $query = "SELECT OptionId, OptionText
        FROM Options
        WHERE PollId = '$pollId'";

        $result2 = $db->query($query);
        $optionArray = array();
        $VoteCount = array();

        while ($row1 = $result2->fetch()) {
            $OptionID = $row1['OptionId'];
            $query = "SELECT Options.OptionId, COUNT(Vote.OptionId) AS VoteCount FROM Options LEFT JOIN Vote ON Options.OptionId = Vote.OptionId WHERE Vote.OptionId  = '$OptionID' GROUP BY Options.OptionId";
            $temp1 = $db->query($query);
            if ($temp = $temp1->fetch()) {
                $VoteCount[] = $temp;
            }
            else  {
                $VoteCount[] = array('OptionId' => $row1['OptionId'], 'VoteCount' => 0);
            }

            $optionArray[] = $row1;
        }
        $db = null;

        $sum = 0;

       foreach($VoteCount as $Vote) {
            $sum = $sum + $Vote['VoteCount'];
       }

       if ($sum == 0) {
        $sum = 1;
       }

       foreach($VoteCount as $key => $Value) {
        $VoteCount[$key] = ($Value['VoteCount']/ $sum) * 100;
       }


    }
    else {
        header("Location: YourVote.php");
        exit();
    }
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Mpoll Results</title>
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
    <div id="main-YourVote">
        <div class="MyPoll-mainContent">
            <div class="MyPoll-Containers">
                <div class="UserAvatar-Name">
                    <img src="<?=$row["Avatar"]?>" alt="ItachiGod-img" class="Avatar-images" />
                    <small class="UserName"><?=$row["UserName"]?></small>
                </div>
                <div class="OtherContent">
                    <div class="HomeQuestion-Zone">
                        <p><?=$row["Question"]?></p>
                        <form action="#" class="Poll-Options">
                            <div>
                                <?php
                                    $increase = 0;
                                    foreach($optionArray as $resultant) {
                                ?>
                                    <input type="radio" name="option" value="A" id="<?=$resultant["OptionId"]?>" disabled/>
                                    <label for="<?=$resultant["OptionId"]?>">
                                        <?=$resultant["OptionText"]?>
                                        <?php $percentage = $VoteCount[$increase]?>
                                    </label>
                                    <div class="graph-container">
                                        <div class="graph-bar" id="graph-barA" style="width:<?=$percentage?>%">
                                        <span class="graph-label"><?=$percentage?>%</span>
                                        </div>
                                    </div>
                                <?php
                                    $increase = $increase + 1;
                                    }
                                    $increase = 0;
                                    list($Date, $time) = explode(" ", $row["GenerationTime"]);
                                ?>
                                
                                
                                <input type="button" value="Vote" class="Vote-btn" />
                            </div>    
                        </form>
                              
                    </div>
                    <div class="Recent-Vote">
                        <p>Recent Vote:</p>
                    </div>
                </div>
                <div class="timeZone-HomePage">
                    <div class="QuestionTimeZone">
                        Day: <span class="Date"><?=$Date?></span>
                        Time: <span class="Time"><?=$time?></span>
                    </div>
                    <?php if ($row["LastVoteDate"] != null) {
                        list($Date, $time) = explode(" ", $row["LastVoteDate"]);
                        }?>
                    <div class="RecentTimeZone">
                        <p class="DateTimePara">
                            Day: <span class="Recent-Date"><?=$Date?></span>
                            Time: <span class="Recent-Time"><?=$time?></span>
                        </p>
                    </div>
                </div>
                <div class="Scrollers">
                    <button class="previousQuestion">Previous</button>
                    <button class="NextQuestion">Next</button>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>