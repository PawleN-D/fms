<?php
require_once('../../private/initialize.php');

$playersFixtures = get_players_with_fixtures_and_goals();
$players = get_all_players();
$fixtures = get_all_fixtures();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_player_fixture"])) {
        $playerFixture = [];
        $playerFixture['player_id'] = $_POST['player_id'];
        $playerFixture['fixture_id'] = $_POST['fixture_id'];
        $playerFixture['goals_scored'] = $_POST['goals_scored'];
        $result = insert_player_fixture($playerFixture);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixtures.php'));
            exit;
        }
    } elseif (isset($_POST["edit"])) {
        $playerFixture = [];
        $playerFixture['player_fixture_id'] = $_POST['player_fixture_id'];
        $playerFixture['player_id'] = $_POST['player_id'];
        $playerFixture['fixture_id'] = $_POST['fixture_id'];
        $playerFixture['goals_scored'] = $_POST['goals_scored'];
        $result = update_player_fixture($playerFixture);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixtures.php'));
            exit;
        }
    } elseif (isset($_POST["delete_player_fixture"])) {
        $playerFixture_id = $_POST["fixture_id"];
        $playerFixture = find_player_fixture_by_id($playerFixture_id);
        if ($playerFixture) {
            // Display confirmation message before deleting
            $confirm_msg = "Are you sure you want to delete the player fixture?";
        } else {
            // Player fixture not found, display error message
            $error_msg = "Player fixture not found.";
        }
    } elseif (isset($_POST["confirm_delete"])) {
        $playerFixture_id = $_POST["player_fixture_id"];
        $result = delete_player_fixture($playerFixture_id);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_fixtures.php'));
            exit;
        }
    }
}

$page_title = 'Players Fixtures';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">
    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="players-fixtures">
        <h1>Players Fixtures</h1>

        <?php if (isset($confirm_msg)) { ?>
            <p><?php echo $confirm_msg; ?></p>
            <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                <input type="hidden" name="player_fixture_id" value="<?php echo $playerFixture_id; ?>">
                <input type="submit" name="confirm_delete" value="Delete">
                <a class="action" href="<?php echo url_for('/pages/player_fixtures.php'); ?>">Cancel</a>
            </form>
        <?php } elseif (isset($error_msg)) { ?>
            <p><?php echo $error_msg; ?></p>
        <?php } else { ?>
            <table class="list">
                <tr>
                    <th>Player</th>
                    <th>Fixture</th>
                    <th>Goals</th>
                    <th>Actions</th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($playersFixtures as $player) { ?>
                    <?php foreach ($player['fixtures'] as $fixture) { ?>
                        <tr>
                            <td><?php echo h($player['player_name']); ?></td>
                            <td><?php echo h($fixture['fixture_id']); ?></td>
                            <td><?php echo h($fixture['goals_scored']); ?></td>
                            <td>
                                <a class="action" href="<?php echo url_for('/pages/player_fixtures.php?edit=' . h($fixture['fixture_id'])); ?>">Edit</a>
                                <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                                    <input type="hidden" name="fixture_id" value="<?php echo h($fixture['fixture_id']); ?>">
                                    <input type="submit" name="delete_player_fixture" value="Delete">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>

            <h2>Add Player Fixture</h2>
            <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                <div class="form-fields">
                    <div class="form-group">
                        <label for="player_id">Player:</label>
                        <select name="player_id" id="player_id">
                            <option value="">Select Player</option>
                            <?php foreach ($players as $player) { ?>
                                <option value="<?php echo h($player['player_id']); ?>"><?php echo h($player['player_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fixture_id">Fixture:</label>
                        <select name="fixture_id" id="fixture_id">
                            <option value="">Select Fixture</option>
                            <?php foreach ($fixtures as $fixture) { ?>
                                <option value="<?php echo h($fixture['fixture_id']); ?>"><?php echo h($fixture['fixture_date']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="goals_scored">Goals:</label>
                        <input type="number" name="goals_scored" id="goals_scored" value="" placeholder="Enter goals">
                    </div>
                </div>
                <div class="form-actions">
                    <input type="submit" name="add_player_fixture" value="Add Player Fixture">
                </div>
            </form>

            <?php if (isset($_GET['edit'])) { ?>
                <?php
                $edit_id = $_GET['edit'];
                $playerFixture = find_player_fixture_by_id($edit_id);
                if ($playerFixture) {
                    $edit_player_id = $playerFixture['player_id'];
                    $edit_fixture_id = $playerFixture['fixture_id'];
                    $edit_goals_scored = $playerFixture['goals_scored'];
                }
                ?>
                <?php if (isset($edit_player_id)) { ?>
                    <h2>Edit Player Fixture</h2>
                    <form action="<?php echo url_for('/pages/player_fixtures.php'); ?>" method="post">
                        <input type="hidden" name="player_fixture_id" value="<?php echo h($edit_id); ?>">
                        <div class="form-fields">
                            <div class="form-group">
                                <label for="edit_player_id">Player:</label>
                                <select name="player_id" id="edit_player_id">
                                    <option value="">Select Player</option>
                                    <?php foreach ($players as $player) { ?>
                                        <option value="<?php echo h($player['player_id']); ?>" <?php if ($player['player_id'] == $edit_player_id) echo "selected"; ?>><?php echo h($player['player_name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_fixture_id">Fixture:</label>
                                <select name="fixture_id" id="edit_fixture_id">
                                    <option value="">Select Fixture</option>
                                    <?php foreach ($fixtures as $fixture) { ?>
                                        <option value="<?php echo h($fixture['fixture_id']); ?>" <?php if ($fixture['fixture_id'] == $edit_fixture_id) echo "selected"; ?>><?php echo h($fixture['fixture_date']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_goals_scored">Goals:</label>
                                <input type="number" name="goals_scored" id="edit_goals_scored" value="<?php echo h($edit_goals_scored); ?>" placeholder="Enter goals">
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" name="edit" value="Save Changes">
                            <a class="action" href="<?php echo url_for('/pages/player_fixtures.php'); ?>">Cancel</a>
                        </div>
                    </form>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
