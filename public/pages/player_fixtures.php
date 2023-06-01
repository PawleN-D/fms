<?php
require_once('../../private/initialize.php');

$playerFixtures = get_all_player_fixtures();
$players = get_all_players();
$fixtures = get_all_fixtures();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_player_fixture"])) {
        $playerFixture = [];
        $playerFixture['fixture_id'] = $_POST['fixture_id'] ?? '';
        $playerFixture['player_id'] = $_POST['player_id'] ?? '';
        $playerFixture['goals_scored'] = $_POST['goals_scored'] ?? '';
        $result = insert_player_fixture($playerFixture);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixtures'));
            exit;
        }
    } elseif (isset($_POST["edit_player_fixture"])) {
        $playerFixture = [];
        $playerFixture['fixture_id'] = $_POST['fixture_id'] ?? '';
        $playerFixture['player_id'] = $_POST['player_id'] ?? '';
        $playerFixture['goals_scored'] = $_POST['goals_scored'] ?? '';
        $result = update_player_fixture($playerFixture);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixtures'));
            exit;
        }
    } elseif (isset($_POST["delete_player_fixture"])) {
        $fixture_id = $_POST["fixture_id"];
        $player_id = $_POST["player_id"];
        $result = delete_player_fixture($fixture_id, $player_id);
    }
}

$page_title = 'Player Fixtures Page';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="player-fixtures">
        <h1>Player Fixtures Page</h1>

        <table class="list">
            <tr>
                <th>Player</th>
                <th>Fixture</th>
                <th>Goals Scored</th>
                <th>Actions</th>
            </tr>
            <?php while ($playerFixture = mysqli_fetch_assoc($playerFixtures)) { ?>
                <tr>
                    <td><?php echo h($playerFixture['player_name']); ?></td>
                    <td><?php echo h($playerFixture['fixture_name']); ?></td>
                    <td><?php echo h($playerFixture['goals_scored']); ?></td>
                    <td>
                        <a class="action" href="?edit=<?php echo $playerFixture["fixture_id"]; ?>&player=<?php echo $playerFixture["player_id"]; ?>">Edit</a>
                        <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                            <input type="hidden" name="fixture_id" value="<?php echo $playerFixture["fixture_id"]; ?>">
                            <input type="hidden" name="player_id" value="<?php echo $playerFixture["player_id"]; ?>">
                            <input type="submit" name="delete_player_fixture" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php if (isset($_GET['edit'])) {
            $fixture_id = $_GET['edit'];
            $player_id = $_GET['player'];
            $playerFixture = find_player_fixture($fixture_id, $player_id);
            if ($playerFixture) { ?>
                <h2>Edit Player Fixture</h2>
                <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                    <dl>
                        <dt>Fixture</dt>
                        <dd>
                            <select name="fixture_id">
                                <?php while ($fixture = mysqli_fetch_assoc($fixtures)) { ?>
                                    <option value="<?php echo h($fixture['fixture_id']); ?>" <?php if ($fixture['fixture_id'] == $playerFixture['fixture_id']) {
                                                                                                        echo 'selected';
                                                                                                    } ?>><?php echo h($fixture['fixture_name']); ?></option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Player</dt>
                        <dd>
                            <select name="player_id">
                                <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                                    <option value="<?php echo h($player['player_id']); ?>" <?php if ($player['player_id'] == $playerFixture['player_id']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo h($player['player_name']); ?></option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Goals Scored</dt>
                        <dd><input type="number" name="goals_scored" value="<?php echo h($playerFixture['goals_scored']); ?>"></dd>
                    </dl>
                    <div id="operations">
                        <input type="submit" name="edit_player_fixture" value="Save">
                    </div>
                </form>
            <?php }
        } else { ?>
            <h2>Add Player Fixture</h2>
            <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                <dl>
                    <dt>Fixture</dt>
                    <dd>
                        <select name="fixture_id">
                            <?php while ($fixture = mysqli_fetch_assoc($fixtures)) { ?>
                                <option value="<?php echo h($fixture['fixture_id']); ?>"><?php echo h($fixture['fixture_name']); ?></option>
                            <?php } ?>
                        </select>
                    </dd>
                    <dt>Player</dt>
                    <dd>
                        <select name="player_id">
                            <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                                <option value="<?php echo h($player['player_id']); ?>"><?php echo h($player['player_name']); ?></option>
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
