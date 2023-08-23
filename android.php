<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<meta name="viewport" content="width=device-width, initial-scale=0.75">
<title>Guess the Player</title>
</head>
<body>
<!-- <div class="container"> -->
<!-- Include the Select2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include the Select2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<?php
include "DBConnection.php"; // include the database connection file

$points = "100";

// Set rules location
// echo '<div style="position: absolute; bottom: 25%; left: 45%;">';
echo '<div style="position: absolute; top: 0%; left: 13%;">';
echo '<p style="display: inline; font-size: 20px; margin: 0;"><b>&#11088;70 = &#129351;</b></p><span style="color: white;">.....</span>';
echo '<p style="display: inline; font-size: 20px; margin: 0;"><b>&#11088;50 = &#129352;</b></p><span style="color: white;">.....</span>';
echo '<p style="display: inline; font-size: 20px; margin: 0;"><b>&#11088;1 = &#129353;</b></p><span style="color: white;">.....</span>';
echo '<p style="display: inline; font-size: 20px; margin: 0;"><b>&#11088;0 = &#128078;</b></p>';
echo '</div>';

// Set year location
echo '<div style="position: absolute; top: 10%; left: 8%;">';
echo '<p style="display: inline; font-size: 18px; margin: 0;"><b>2022-23</b></p><br>';
echo '</div>';

// mobile / webapp button. local: http://localhost/guesstheplayer/webapp.php http://localhost/guesstheplayer/home.php
echo '<div style="position: absolute; top: 5%; left: 8%;">';
echo '<form action="home.php">
    <button type="submit" style="background-color: blue; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
      Change Device
    </button>
  </form>';
echo '</div>';

// Set star emoji location
echo '<div style="position: absolute; top: 30%; right: 51%;">';
echo '<span style="font-size: 35px;">&#11088;</span>';
echo '</div>';

// Set points location
echo '<div style="position: absolute; top: 30%; right: 42%;">';
echo '<span style="font-size: 35px;"><p id="points" style="display: inline; font-size: 30px; margin: 0;"><b>' . $points . '</b></p></span>';
echo '</div>';

// Set symbols and locations
echo '<div style="position: absolute; top: 15%; right: 4%;">';
if (isset($_POST['submit']) && !$isCorrect) {
    echo '<span id="firstSymbol" style="font-size:30px;">&#10060;</span>';
} else {
    echo '<span id="firstSymbol" style="font-size:30px;">&#127954;</span>';
}
if (isset($_POST['submit']) && !$isCorrect) {
    echo '<span id="secondSymbol" style="font-size:30px;">&#10060;</span>';
} else {
    echo '<span id="secondSymbol" style="font-size:30px;">&#127954;</span>';
}
if (isset($_POST['submit']) && !$isCorrect) {
  echo '<span id="thirdSymbol" style="font-size:30px;">&#10060;</span>';
  echo '<span id="thumbsDown" style="font-size:100px; position: absolute; top: 42%; right: 37%; ">&#128078;</span>';
} else {
  echo '<span id="thirdSymbol" style="font-size:30px;">&#127954;</span></div>';
  echo '<div style="position: absolute; top: 40%; right: 37%;"><span id="thumbsDown" style="font-size:100px;"></span></div>';
}
// echo '</div>';
echo '<div class="container">';

$query = "SELECT player FROM playerinfo23 WHERE gp > 15 ORDER BY PLAYER";
$result = mysqli_query($conn, $query);

$dropdown = '<form method="post" action="" id="playerForm">';
$dropdown .= '<select name="selected_player" class="select2" style="width: 400px;">'; // Add the "select2" class to the select element
while ($row = mysqli_fetch_assoc($result)) {
    $dropdown .= '<option value="' . $row['player'] . '">' . $row['player'] . '</option>';
}
$dropdown .= '</select> ';
// $dropdown .= '<input type="submit" name="submit" value="Guess Player" onclick="submitForm(event)">';
// $dropdown .= '<div style="position: absolute; top: 25%; right: 38%;"><input type="submit" name="submit" value="Guess Player &#11088;5" style="background-color: Chartreuse; font-weight: bold;" onclick="submitForm(event); subtract5Points();">';$dropdown .= '</div></form>';
$dropdown .= '</form><br><input type="submit" name="submit" value="Guess Player &#11088;5" style="background-color: Chartreuse; font-weight: bold;" onclick="submitForm(event); subtract5Points();">';$dropdown .= '';
$dropdown .= '<script>';
$dropdown .= '$(".select2").select2();'; // Initialize the select2 plugin on the select element
$dropdown .= '</script>';

// echo $dropdown;

// Retrieve all players who meet the condition
$query = "SELECT id, player, team, position, dateofbirth, birthcountry, draftteam, draftround, overalldraftposition, gp, avtoi, goals, totalassists, totalpoints, shots, shootingpercentage, shotattempts, pim, minorpenalties, majorpenalties, penaltiesdrawn, hits, hitstaken, shotsblocked
FROM playerinfo23 WHERE gp > 15";

$result = mysqli_query($conn, $query);

// Fetch all rows into an array
$players = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if the array is not empty
if (!empty($players)) {
    // Select a random player from the array
    $selectedPlayer = $players[array_rand($players)];
    echo '<br>';
    

    if ($selectedPlayer['position'] === 'goalie' || $selectedPlayer['goals'] > 29 || $selectedPlayer['totalpoints'] > 80 || $selectedPlayer['avtoi'] > 21.5) {
        echo '<div style="position: absolute; top: 5%; right: 8%; display: inline-flex; background-color: darkgreen; color: white; padding: 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
          <span style="margin: auto;">Difficulty: Easy</span>
      </div>';
    } elseif ($selectedPlayer['goals'] > 14 || $selectedPlayer['totalpoints'] > 29 || $selectedPlayer['avtoi'] > 19) {
        echo '<div style="position: absolute; top: 5%; right: 6%; display: inline-flex; background-color: darkorange; color: white; padding: 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
          <span style="margin: auto;">Difficulty: Medium</span>
      </div>';
    } else {
        echo '<div style="position: absolute; top: 5%; right: 8%; display: inline-flex; background-color: darkred; color: white; padding: 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
          <span style="margin: auto;">Difficulty: Hard</span>
      </div>';

    }
    
    



// Display the player's information
echo '<span style="font-size:50px;">&#129349;</span>';
echo '<div id="position"><p style="display: inline; font-size: 30px; margin: 0;"><b>' . $selectedPlayer['position'] . '</b></p></div>';
echo '<div id="avtoi"><p style="display: inline; font-size: 30px; margin: 0;"><b>' . $selectedPlayer['avtoi'] . ' </b></p>TOI/GP</div>';
echo '<br><br>';

echo $dropdown;


// echo '<h3>Hints</h3>';
echo '<h5></h5>';

// echo '<button onclick="subtract5Points(); toggleVisibility(\'team\')">Team</button><br>';
// echo '<div id="team" style="display: none;">' . $selectedPlayer['team'] . '</div>';
// echo '<br><br>';

// echo '<button onclick="subtract5Points(); toggleVisibility(\'goals\')">Goals</button><br>';
// echo '<div id="goals" style="display: none;">' . $selectedPlayer['goals'] . '</div>';
// echo '<br><br>';


echo '<div style="width: 450px; height: 1000px; overflow: off;">';
echo '<table>';


// 25 point and 5 point
echo '<tr>';
echo '<td style="text-align: center; vertical-align: bottom;"><b> &#11088;25</b></td>';
echo '<td style="width: 175px;"><div id="" style="display: none;"></div></td>';
echo '<td style="text-align: center; vertical-align: bottom;"><b> &#11088;5</b></td>';
echo '<td style="width: 175px;"><div id="" style="display: none;"></div></td>';
echo '<td style="text-align: center; color: white;">................</td>';
echo '</tr>';

// Button and result for Team and Shots
// echo '<tr><td style="text-align: center;"><b> &#11088;25</b></tr></td>';
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract25Points(); toggleVisibility(\'team\');">Team</button></td>';
echo '<td><div id="team" style="display: none;"><b>' . $selectedPlayer['team'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'shots\')">Shots</button></td>';
echo '<td><div id="shots" style="display: none;"><b>' . $selectedPlayer['shots'] . '</b></div></td>';
echo '</tr>';

// Button and result for 10 points and shots blocked
echo '<tr>';
echo '<td style="text-align: center; vertical-align: bottom;"><b> &#11088;10</b></td>';
echo '<td style="width: 175px;"><div id="team" style="display: none;"></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'shotsblocked\')">Shots Blocked</button></td>';
echo '<td><div id="shotsblocked" style="display: none;"><b>' . $selectedPlayer['shotsblocked'] . '</b></div></td>';
echo '</tr>';

// Button and result for Goals and Hits
echo '<tr><td></tr></td>';
// echo '<tr><td style="text-align: center;"><b> &#11088;10</b></tr></td>';
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'goals\')">Goals</button></td>';
echo '<td style="width: 175px;"><div id="goals" style="display: none;"><b>' . $selectedPlayer['goals'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'hits\')">Hits</button></td>';
echo '<td><div id="hits" style="display: none;"><b>' . $selectedPlayer['hits'] . '</b></div></td>';
echo '</tr>';

// Button and result for Assists andPenalties Drawn
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'totalassists\')">Assists</button></td>';
echo '<td><div id="totalassists" style="display: none;"><b>' . $selectedPlayer['totalassists'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'penaltiesdrawn\')">Penalties Drawn</button></td>';
echo '<td><div id="penaltiesdrawn" style="display: none;"><b>' . $selectedPlayer['penaltiesdrawn'] . '</b></div></td>';
echo '</tr>';

// Button and result for Points and Penalties in Minutes
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'totalpoints\')">Points</button></td>';
echo '<td><div id="totalpoints" style="display: none;"><b>' . $selectedPlayer['totalpoints'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'pim\')">Penalties in Minutes</button></td>';
echo '<td><div id="pim" style="display: none;"><b>' . $selectedPlayer['pim'] . '</b></div></td>';
echo '</tr>';

// Button and result for Birth Country and Minor Penalties
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'birthcountry\')">Birth Country</button></td>';
echo '<td><div id="birthcountry" style="display: none;"><b>' . $selectedPlayer['birthcountry'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'minorpenalties\')">Minor Penalties</button></td>';
echo '<td><div id="minorpenalties" style="display: none;"><b>' . $selectedPlayer['minorpenalties'] . '</b></div></td>';
echo '</tr>';

// Button and result for Draft Team and Major Penalties
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'draftteam\')">Draft Team</button></td>';
echo '<td><div id="draftteam" style="display: none;"><b>' . $selectedPlayer['draftteam'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'majorpenalties\')">Major Penalties</button></td>';
echo '<td><div id="majorpenalties" style="display: none;"><b>' . $selectedPlayer['majorpenalties'] . '</b></div></td>';
echo '</tr>';

// Games Played and Button for Draft Round
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'gp\')">Games Played</button></td>';
echo '<td><div id="gp" style="display: none;"><b>' . $selectedPlayer['gp'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'draftround\')">Draft Round</button></td>';
echo '<td><div id="draftround" style="display: none;"><b>' . $selectedPlayer['draftround'] . '</b></div></td>';
echo '</tr>';

// Button for Date of Birth and Draft Position
echo '<tr>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract10Points(); toggleVisibility(\'dateofbirth\')">Date of Birth</button></td>';
echo '<td><div id="dateofbirth" style="display: none;"><b>' . $selectedPlayer['dateofbirth'] . '</b></div></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract5Points(); toggleVisibility(\'overalldraftposition\')">Draft Position</button></td>';
echo '<td><div id="overalldraftposition" style="display: none;"><b>' . $selectedPlayer['overalldraftposition'] . '</b></div></td>';
echo '</tr>';

// Empty and 100 point button
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td style="text-align: center; vertical-align: bottom;"><b> &#11088;100</b></td>';
echo '</tr>';

// Empty and // Button and result for Give Up, Show Player
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td><button style="width: 150px; height: 50px; background-color: PaleTurquoise;" onclick="subtract100Points(); toggleVisibility(\'player\')">Give Up, Show Player</button></td>';
echo '</tr>';
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td><div id="player" style="display: none; text-align: center;"><b>' . $selectedPlayer['player'] . '</b></div></td>';
echo '</tr>';

// Empty and rows
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td></td>';
echo '</tr>';
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td></td>';
echo '</tr>';

// Empty and new player button
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td><form method="post">
<input type="submit" name="refresh" value="New Player" style="background-color: lightsalmon;">
</form></td>';
echo '</tr>';
echo '<tr>';
echo '<td style="text-align: center;"></td>';
echo '<td><div id="player" style="display: none; text-align: center;"><b>' . $selectedPlayer['player'] . '</b></div></td>';
echo '</tr>';


echo '</table>';
echo '</div>';

echo '</div>';

}

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Retrieve the selected player
        $selectedPlayerName = $_POST['selected_player'];

        // Check if the selected player matches the random player
        if ($selectedPlayer['player'] === $selectedPlayerName) {
            echo '<script>alert("Correct!");</script>';
        } else {
            echo '<script>alert("Incorrect.");</script>';
        }
    }

// Close the database connection
mysqli_close($conn);
?>

<script>
function toggleVisibility(columnId) {
    var column = document.getElementById(columnId);
    if (column.style.display === 'none') {
      column.style.display = 'block';
    } else {
      column.style.display = 'none';
    }
  }
  
var counter = 0;
var endP;

function submitForm(event) {
    event.preventDefault(); // Prevent the default form submission

    var form = document.getElementById('playerForm');
    var selectedPlayer = form.selected_player.value;

    // Retrieve the selected player
    var selectedPlayerName = form.selected_player.value;

    // Check if the selected player matches the random player
    if ("<?php echo $selectedPlayer['player']; ?>" === selectedPlayerName) {
        // alert("Correct!");

         // Update the symbol based on the counter value
        if (counter === 0) {
            document.getElementById("firstSymbol").innerHTML = '&#9989;'; // Change the symbol to X
        } else if (counter === 1) {
            document.getElementById("secondSymbol").innerHTML = '&#9989;'; // Change the symbol to X
        } else if (counter === 2) {
            document.getElementById("thirdSymbol").innerHTML = '&#9989;'; // Change the symbol to X
        }

            // Display different medal based on points
            // Create a new element for the medal symbol
            var medalSymbol = document.createElement("span");
            medalSymbol.style.fontSize = "100px";

            // Get the current points to be used for medal
            var pointsElement = document.getElementById("points");
            var points = parseInt(pointsElement.innerText);
            pointsElement.innerHTML = "<b>" + points + "</b>";
            var endP = points;
                // alert(endP);

            // Check the points value and assign the appropriate medal symbol
            // Points are 5 higher in this logic than on the display. this is because the 5 points for the guess button
            // happens at the same time as the submission, so it doesnt apply the subtraction when checking which medal to display
            if (endP > 74) {
            medalSymbol.innerHTML = '&#129351;'; // Gold medal symbol
            } else if (endP > 54) {
            medalSymbol.innerHTML = '&#129352;'; // Silver medal symbol
            } else if (endP > 6) {
            medalSymbol.innerHTML = '&#129353;'; // Bronze medal symbol
            } else {
            medalSymbol.innerHTML = '&#128078;'; // Thumbs Down symbol
            }

            // Set the positioning properties
            medalSymbol.style.position = "absolute";  // or "absolute" if you want it relative to a parent element
            medalSymbol.style.top = "40%";       // adjust the top position value
            medalSymbol.style.right = "37%";      // adjust the left position value

            // Append the additional symbol to the document
            document.body.appendChild(medalSymbol);

        // Increment the counter
        counter++;


    } else {
        // alert("Incorrect.");

        // Update the symbol based on the counter value
        if (counter === 0) {
            document.getElementById("firstSymbol").innerHTML = '&#10060;'; // Change the symbol to X
        } else if (counter === 1) {
            document.getElementById("secondSymbol").innerHTML = '&#10060;'; // Change the symbol to X
        } else if (counter === 2) {
            document.getElementById("thirdSymbol").innerHTML = '&#10060;'; // Change the symbol to X
            document.getElementById("thumbsDown").innerHTML = '&#128078;'; // Change the symbol to thumbs down
        }

        // Increment the counter
        counter++;
    }
}

function subtract25Points() {
  var pointsElement = document.getElementById("points");
  var points = parseInt(pointsElement.innerText);
  points -= 25;
  pointsElement.innerHTML = "<b>" + points + "</b>";
  var endP = points;
    // alert(endP);
}

function subtract10Points() {
  var pointsElement = document.getElementById("points");
  var points = parseInt(pointsElement.innerText);
  points -= 10;
  pointsElement.innerHTML = "<b>" + points + "</b>";
  var endP = points;
    // alert(endP);
}

function subtract5Points() {
  var pointsElement = document.getElementById("points");
  var points = parseInt(pointsElement.innerText);
  points -= 5;
  pointsElement.innerHTML = "<b>" + points + "</b>";
  var endP = points;
    // alert(endP);
}

function subtract100Points() {
  var pointsElement = document.getElementById("points");
  var points = parseInt(pointsElement.innerText);
  points -= 100;
//   points -= 0; // for testing
  pointsElement.innerHTML = "<b>" + points + "</b>";
}

</script>


</div>
</body>
</html>