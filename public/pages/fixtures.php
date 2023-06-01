<?php
require_once('../../private/initialize.php');

// Get all players with their fixtures and goals
$players = get_players_with_fixtures_and_goals();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_player_fixture"])) {
        $player_fixture = [];
        $player_fixture['player_id'] = $_POST['player_id'] ?? '';
        $player_fixture['fixture_id'] = $_POST['fixture_id'] ?? '';
        $player_fixture['goals_scored'] = $_POST['goals_scored'] ?? '';
        $result = insert_player_fixture($player_fixture);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixture.php'));
            exit;
        }
    } elseif (isset($_POST["edit_player_fixture"])) {
        $player_fixture = [];
        $player_fixture['player_fixture_id'] = $_POST["player_fixture_id"];
        $player_fixture['player_id'] = $_POST['player_id'] ?? '';
        $player_fixture['fixture_id'] = $_POST['fixture_id'] ?? '';
        $player_fixture['goals_scored'] = $_POST['goals_scored'] ?? '';
        $result = update_player_fixture($player_fixture);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixture.php'));
            exit;
        }
    } elseif (isset($_POST["delete_player_fixture"])) {
        $player_fixture_id = $_POST["player_fixture_id"];
        $result = delete_player_fixture($player_fixture_id);
    }
}

$page_title = 'Player Fixture Page';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="player-fixture">
        <h1>Player Fixture Page</h1>

        <table class="list">
            <tr>
                <th>Player Name</th>
                <th>Fixture Date</th>
                <th>Goals Scored</th>
                <th>Actions</th>
            </tr>

            <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                <tr>
                    <td><?php echo h($player['player_name']); ?></td>
                    <td><?php echo h($player['fixture_date']); ?></td>
                    <td><?php echo h($player['goals_scored']); ?></td>
                    <td>
                        <a class="action" href="?edit=<?php echo $player["player_fixture_id"]; ?>">Edit</a>
                        <form action="<?php echo url_for('/pages/player_fixture.php'); ?>" method="post">
                            <input type="hidden" name="player_fixture_id" value="<?php echo $player["player_fixture_id"]; ?>">
                            <input type="submit" name="delete_player_fixture" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php if (isset($_GET['edit'])) {
            $player_fixture_id = $_GET['edit'];
            $player_fixture = find_player_fixture_by_id($player_fixture_id);
            if ($player_fixture) { ?>
                <h2>Edit Player Fixture</h2>
                <form action="<?php echo url_for('/pages/player_fixture.php'); ?>" method="post">
                    <input type="hidden" name="player_fixture_id" value="<?php echo $player_fixture['player_fixture_id']; ?>">
                    <dl>
                        <dt>Player</dt>
                        <dd>
                            <select name="player_id">
                                <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                                    <option value="<?php echo h($player['player_id']); ?>" <?php if ($player['player_id'] == $player_fixture['player_id']) echo 'selected'; ?>>
                                        <?php echo h($player['player_name']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Fixture</dt>
                        <dd>
                            <select name="fixture_id">
                                <?php while ($fixture = mysqli_fetch_assoc($fixtures)) { ?>
                                    <option value="<?php echo h($fixture['fixture_id']); ?>" <?php if ($fixture['fixture_id'] == $player_fixture['fixture_id']) echo 'selected'; ?>>
                                        <?php echo h($fixture['fixture_date'] . ' ' . $fixture['fixture_time']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Goals Scored</dt>
                        <dd><input type="number" name="goals_scored" value="<?php echo h($player_fixture['goals_scored']); ?>"></dd>
                    </dl>
                    <div id="operations">
                        <input type="submit" name="edit_player_fixture" value="Update">
                    </div>
                </form>
            <?php } ?>
        <?php } else { ?>
            <h2>Add Player Fixture</h2>
            <form action="<?php echo url_for('/pages/player_fixture.php'); ?>" method="post">
                <dl>
                    <dt>Player</dt>
                    <dd>
                        <select name="player_id">
                            <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                                <option value="<?php echo h($player['player_id']); ?>">
                                    <?php echo h($player['player_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </dd>
                    <dt>Fixture</dt>
                    <dd>
                        <select name="fixture_id">
                            <?php while ($fixture = mysqli_fetch_assoc($fixtures)) { ?>
                                <option value="<?php echo h($fixture['fixture_id']); ?>">
                                    <?php echo h($fixture['fixture_date'] . ' ' . $fixture['fixture_time']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </dd>
                    <dt>Goals Scored</dt>
                    <dd><input type="number" name="goals_scored" value=""></dd>
                </dl>
                <div id="operations">
                    <input type="submit" name="add_player_fixture" value="Add Player Fixture">
                </div>
            </form>
        <?php } ?>
    </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
