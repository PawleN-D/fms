<?php
require_once('../../private/initialize.php');

$players = get_all_players();
$teams = get_all_teams();
$positions = get_all_position();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_player"])) {
        $player = [];
        $player['team_id'] = $_POST['team_id'] ?? '';
        $player['player_name'] = $_POST['player_name'] ?? '';
        $player['player_sqd_num'] = $_POST['player_sqd_num'] ?? '';
        $player['position_id'] = $_POST['position_id'] ?? '';
        $result = insert_player($player);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_information.php'));
            exit;
        }
    } elseif (isset($_POST["edit_player"])) {
        $player = [];
        $player['player_id'] = $_POST['player_id'];
        $player['team_id'] = $_POST['team_id'] ?? '';
        $player['player_name'] = $_POST['player_name'] ?? '';
        $player['player_sqd_num'] = $_POST['player_sqd_num'] ?? '';
        $player['position_id'] = $_POST['position_id'] ?? '';
        $result = update_player($player);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_information.php'));
            exit;
        }
    } elseif (isset($_POST["delete_player"])) {
        $player_id = $_POST["player_id"];
        $player = find_player_by_id($player_id);
        if ($player) {
            // Display confirmation message before deleting
            $confirm_msg = "Are you sure you want to delete the player: " . h($player['player_name']) . "?";
        } else {
            // Player not found, display error message
            $error_msg = "Player not found.";
        }
    } elseif (isset($_POST["confirm_delete"])) {
        $player_id = $_POST["player_id"];
        $result = delete_player($player_id);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_information.php'));
            exit;
        }
    }
}

$page_title = 'Player Information';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="player-information new">
        <h1>Player Information</h1>

        <?php if (isset($confirm_msg)) { ?>
            <p><?php echo $confirm_msg; ?></p>
            <form action="<?php echo url_for('/pages/player_information.php'); ?>" method="post">
                <input type="hidden" name="player_id" value="<?php echo $player_id; ?>">
                <input type="submit" name="confirm_delete" value="Delete">
                <a class="action" href="<?php echo url_for('/pages/player_information.php'); ?>">Cancel</a>
            </form>
        <?php } elseif (isset($error_msg)) { ?>
            <p><?php echo $error_msg; ?></p>
        <?php } else { ?>
            <table class="list">
                <tr>
                    <th><a href="?sort=surname">Player</a></th>
                    <th><a href="?sort=team">Team</a></th>
                    <th>Shirt Number</th>
                    <th>Position</th>
                    <th>Actions</th>
                </tr>
                <?php while ($player = mysqli_fetch_assoc($players)) { ?>
                    <tr>
                        <td><?php echo h($player['player_name']); ?></td>
                        <td><?php echo h($player['team_name']); ?></td>
                        <td><?php echo h($player['player_sqd_num']); ?></td>
                        <td><?php echo h($player['position_descr']); ?></td>
                        <td>
                            <a class="action" href="?edit=<?php echo $player["player_id"]; ?>">Edit</a>
                            <form action="<?php echo url_for('/pages/player_information.php'); ?>" method="post">
                                <input type="hidden" name="player_id" value="<?php echo $player["player_id"]; ?>">
                                <input type="submit" name="delete_player" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <?php if (isset($_GET['edit'])) {
                $player_id = $_GET['edit'];
                $player = find_player_by_id($player_id);
                if ($player) { ?>
                    <h2>Edit Player</h2>
                    <form action="<?php echo url_for('/pages/player_information.php'); ?>" method="post">
                        <input type="hidden" name="player_id" value="<?php echo $player['player_id']; ?>">
                        <dl>
                            <dt>Player Name</dt>
                            <dd><input type="text" name="player_name" value="<?php echo h($player['player_name']); ?>"></dd>
                            <dt>Team</dt>
                            <dd>
                                <select name="team_id">
                                    <?php while ($team = mysqli_fetch_assoc($teams)) { ?>
                                        <option value="<?php echo h($team['team_id']); ?>" <?php if ($team['team_id'] == $player['team_id']) echo 'selected'; ?>><?php echo h($team['team_name']); ?></option>
                                    <?php } ?>
                                </select>
                            </dd>
                            <dt>Shirt Number</dt>
                            <dd><input type="number" name="player_sqd_num" value="<?php echo h($player['player_sqd_num']); ?>"></dd>
                            <dt>Position</dt>
                            <dd>
                                <?php while ($position = mysqli_fetch_assoc($positions)) { ?>
                                    <input type="radio" name="position_id" value="<?php echo h($position['position_id']); ?>" <?php if ($position['position_id'] == $player['position_id']) echo 'checked'; ?>>
                                    <?php echo h($position['position_descr']); ?>
                                    <br>
                                <?php } ?>
                            </dd>
                        </dl>
                        <div id="operations">
                            <input type="submit" name="edit_player" value="Update">
                        </div>
                    </form>
                <?php } else {
                    $error_msg = "Player not found.";
                }
            } else { ?>
                <h2>Add New Player</h2>
                <form action="<?php echo url_for('/pages/player_information.php'); ?>" method="post">
                    <dl>
                        <dt>Player Name</dt>
                        <dd><input type="text" name="player_name" value=""></dd>
                        <dt>Team</dt>
                        <dd>
                            <select name="team_id">
                                <?php while ($team = mysqli_fetch_assoc($teams)) { ?>
                                    <option value="<?php echo h($team['team_id']); ?>"><?php echo h($team['team_name']); ?></option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Shirt Number</dt>
                        <dd><input type="number" name="player_sqd_num" value=""></dd>
                        <dt>Position</dt>
                        <dd>
                            <?php while ($position = mysqli_fetch_assoc($positions)) { ?>
                                <input type="radio" name="position_id" value="<?php echo h($position['position_id']); ?>">
                                <?php echo h($position['position_descr']); ?>
                                <br>
                            <?php } ?>
                        </dd>
                    </dl>
                    <div id="operations">
                        <input type="submit" name="add_player" value="Add Player">
                    </div>
                </form>
            <?php } ?>
        <?php } ?>

    </div>

</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
