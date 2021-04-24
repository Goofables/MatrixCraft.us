<?php
include "header.html";
error_reporting(0); // Just in case i am debugging
global $ip_address;
$ip_address = $_SERVER["REMOTE_ADDR"];

global $mysqli;
$mysqli = null;
try { // Connect
    $creds = json_decode(file_get_contents("../matrixcraft-auth.json"), true);
    /** @noinspection PhpUsageOfSilenceOperatorInspection */
    $mysqli = @new mysqli("127.0.0.1", $creds["username"], $creds["password"], "bungee");
    $creds = null;
    if ($mysqli->connect_errno) {
        throw new Exception("Error: " . $mysqli->connect_errno . ". " . $mysqli->connect_error . "");
    }
} catch (Exception $e) {
    return;
}

$lookup = $mysqli->prepare("SELECT * FROM BAT_players WHERE lastip = ? ORDER BY BAT_players.lastlogin DESC LIMIT 1");
$lookup->bind_param("s", $ip_address);
if (!$lookup->execute() || !$query_result = $lookup->get_result()) return;
if ($query_result->num_rows == 0) return;
$result_array = $query_result->fetch_assoc();
$username = $result_array["BAT_player"];

if (isset($username)):?>
    <div id="player_info" class="page_text round">
        <h4>Welcome <?php echo $username; ?>!</h4>
        <img src="https://minotar.net/avatar/<?php echo $username; ?>" class="player"
             title="<?php echo $username; ?>" alt="" style="float: left; margin: 5px 0 0 25px;">
        Last played: <span
                style="white-space: nowrap;"><?php echo preg_split("/ /", $result_array["lastlogin"])[0]; ?></span><br>
        First played: <span
                style="white-space: nowrap;"><?php echo preg_split("/ /", $result_array["firstlogin"])[0]; ?></span>
    </div>
<?php endif; ?>


