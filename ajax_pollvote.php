<?php
require_once("db.php");
function test_input ($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$VoteCount = array(); 

if (isset($_GET['pollId']) && isset($_GET['selectedOptionIndex'])) {
    
    $pollId = intval($_GET['pollId']);
    $selectedOptionIndex = test_input($_GET['selectedOptionIndex']);

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = "INSERT INTO Vote (OptionId, VoteDateTime)
    SELECT OptionId, NOW()
    FROM Options
    WHERE OptionText = :selectedOptionIndex AND Options.PollId = '$pollId'  LIMIT 1";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':selectedOptionIndex', $selectedOptionIndex, PDO::PARAM_STR);
    $stmt->execute();

    $query = "UPDATE Polls
    SET LastVoteDate = NOW()
    WHERE PollId = '$pollId'";
    $db->exec($query);
   
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

    $result = $db->query($query);
    $row = $result->fetch();
    
    $query = "SELECT OptionId, OptionText
    FROM Options
    WHERE PollId = '$pollId'";

    $result2 = $db->query($query);
    $optionArray = array();

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

   header('Content-Type: application/json');
   echo json_encode($VoteCount);
}
else {
    $VoteCount["Message"] = "There is some error in request code";
}

?>