<?php
require_once('../../private/initialize.php');

$players = get_all_players();
$fixtures = get_all_fixtures();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["player_id"])) {
        $player_id = $_POST["player_id"];
        $player = find_player_by_id($player_id);
        $playerGoalsTotal = get_total_goals_by_player($player_id);
        $playerFixtureGoals = get_goals_by_fixture($player_id);

        // Generate and download the report file
        $filename = "player_report_" . $player_id . ".txt";
        $file = fopen($filename, "w");
        fwrite($file, "Player: " . $player["player_name"] . "\n");
        fwrite($file, "Total Goals: " . $playerGoalsTotal . "\n\n");
        fwrite($file, "Fixture Goals:\n");
        fwrite($file, "Home Fixtures:\n");
        foreach ($playerFixtureGoals["home_fixtures"] as $fixture) {
            fwrite($file, "Fixture ID: " . $fixture["fixture_id"] . ", Goals: " . $fixture["goals_scored"] . "\n");
        }
        fwrite($file, "\n");
        fwrite($file, "Away Fixtures:\n");
        foreach ($playerFixtureGoals["away_fixtures"] as $fixture) {
            fwrite($file, "Fixture ID: " . $fixture["fixture_id"] . ", Goals: " . $fixture["goals_scored"] . "\n");
        }
        fclose($file);

        // Force file download
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename);
        readfile($filename);
        exit;
    }
}

$page_title = 'Reports Page';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="reports">
        <h1>Reports Page</h1>

        <h2>Player Goals</h2>
        <form action="<?php echo url_for('/pages/reports.php'); ?>" method="post">
            <label for="player">Select Player:</label>
            <select name="player_id" id="player">
                <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                    <option value="<?php echo h($player['player_id']); ?>"><?php echo h($player['player_name']); ?></option>
                <?php } ?>
            </select>
            <input type="submit" value="Generate Report">
        </form>

    </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
