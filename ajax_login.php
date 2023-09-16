<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $pollId = test_input($_GET["pollId"]);
    $errors = array();
    $jsonArray = array();
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $query = "SELECT PollId FROM Polls ORDER BY PollId DESC LIMIT 1";
        $result = $db->query($query);
        if ($row = $result->fetch()) {
            if ($pollId != $row["PollId"]) {

                $query = "SELECT Users.UserName, Users.Avatar, Polls.GenerationTime, Polls.PollId, Polls.Question, GROUP_CONCAT(Options.OptionText ORDER BY Options.OptionId ASC SEPARATOR '_ ') AS Options FROM Users INNER JOIN Polls ON Users.UserId = Polls.UserId LEFT JOIN Options ON Polls.PollId = Options.PollId GROUP BY Polls.PollId ORDER BY Polls.GenerationTime DESC LIMIT 5";

                $result = $db->query($query);
                if (!$result) {
                    $jsonArray["Database Error"] = "Could not retrieve User information";
                }
                elseif ($result->rowCount() != 0) {
                    while ($row = $result->fetch()) {
                        if ($row["PollId"] == $pollId) {
                            break;
                        }
                        $jsonArray[] = $row;
                    }
                }

            }
            else {
                $jsonArray["Message"] = "There hasn't been any change";
                
            }
        }
        else {
            $jsonArray["Message"] = "There is nothing to fetch";
        }
        header('Content-Type: application/json');
        echo json_encode($jsonArray);
    }
    catch (PDOException $e){
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>