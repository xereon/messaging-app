<?php
include 'db.php';
global $connect;

header('Content-Type: text/html; charset=utf-8');

function addEmojis($message) {
    // Define a mapping of possible emojis and their corresponding text representations
    $emojiMapping = [
        ':)' => '😊',
        ':D' => '😃',
        ':(' => '😞',
        '<3' => '❤️',
        // Add more emojis and their text representations as needed
    ];

    // Iterate over each emoji in the emoji mapping and replace the text representation with the actual emoji
    foreach ($emojiMapping as $text => $emoji) {
        $message = str_replace($text, $emoji, $message);
    }

    return $message;
}

function timeElapsed($currentTimestamp, $timestamp) {
    $elapsedTime = $currentTimestamp - $timestamp;

    $seconds = $elapsedTime % 60;
    $minutes = floor(($elapsedTime % 3600) / 60);
    $hours = floor(($elapsedTime % 86400) / 3600);
    $days = floor($elapsedTime / 86400);

    $result = '';

    if ($days > 0) {
        $result .= $days . ' day(s) ';
    }

    if ($hours > 0) {
        $result .= $hours . ' hour(s) ';
    }

    if ($minutes > 0) {
        $result .= $minutes . ' minute(s) ';
    }

    if ($seconds > 0) {
        $result .= $seconds . ' second(s) ';
    }

    $result .= 'ago';

    return $result;
}

// Check if the "Delete All Messages" form was submitted
if (isset($_POST['delete_all'])) {
    // Include the delete_all.php file to handle the deletion
    include 'delete_all.php';
}

// Retrieve all messages from the database
$sql = "SELECT * FROM chat ORDER BY id DESC";
$run = mysqli_query($connect, $sql);
// Get the total number of messages
$totalMessages = mysqli_num_rows($run);
// Get the current time
$currentTimestamp = time();
while ($row = mysqli_fetch_array($run)) {
    $name = $row['name'];
    $msg = $row['msg'];
    $date = formatDate($row['date']);
    $timestamp = strtotime($row['date']);
    $timeElapsed = timeElapsed($currentTimestamp, $timestamp);

    // Add emojis to the message
    $msg = addEmojis($msg);

    echo '
    <div class="chat_data">
    <span title="Delete"><a style="text-decoration:none; color: #ff0000;" href="delete.php?id='.$row['id'].'">X</a></span>
    <span>'.$name.': </span>
    <span>'.$timeElapsed.'</span>
    <span>'.$msg.'</span>
    <span><small>'.$date.'</small></span>
    </div>';
}
// Display the total number of messages and the "Delete All Messages" button
echo '<div class="total_messages">Total Messages: '.$totalMessages.'</div>';

?>

<!-- Add the "Delete All Messages" form -->
<form style="text-align: center;" method="post" action="delete_all.php">
    <input type="submit" name="delete_all" value="Delete All Messages">
</form>
    <span style="color: #ff0000; text-align: center;"><small>Deletions are permanent</small></span> 


