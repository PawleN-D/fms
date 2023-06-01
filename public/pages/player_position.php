<?php
require_once('../../private/initialize.php');

$positions = get_all_position();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_position"])) {
        $position = [];
        $position['position_descr'] = $_POST['position_descr'] ?? '';
        $result = insert_position($position);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_positions.php'));
            exit;
        }
    } elseif (isset($_POST["edit_position"])) {
        $position = [];
        $position['position_id'] = $_POST['position_id'];
        $position['position_descr'] = $_POST['position_descr'] ?? '';
        // $result = update_position($position);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_positions.php'));
            exit;
        }
    } elseif (isset($_POST["delete_position"])) {
        $position_id = $_POST["position_id"];
        // $position = find_position_by_id($position_id);
        if ($position) {
            // Display confirmation message before deleting
            $confirm_msg = "Are you sure you want to delete the player position: " . h($position['position_descr']) . "?";
        } else {
            // Position not found, display error message
            $error_msg = "Player position not found.";
        }
    } elseif (isset($_POST["confirm_delete"])) {
        $position_id = $_POST["position_id"];
        // $result = delete_position($position_id);
        if ($result === true) {
            header("Location: " . url_for('/pages/player_positions.php'));
            exit;
        }
    }
}

$page_title = 'Player Positions';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="player-positions new">
        <h1>Player Positions</h1>

        <?php if (isset($confirm_msg)) { ?>
            <p><?php echo $confirm_msg; ?></p>
            <form action="<?php echo url_for('/pages/player_positions.php'); ?>" method="post">
                <input type="hidden" name="position_id" value="<?php echo $position_id; ?>">
                <input type="submit" name="confirm_delete" value="Delete">
                <a class="action" href="<?php echo url_for('/pages/player_positions.php'); ?>">Cancel</a>
            </form>
        <?php } elseif (isset($error_msg)) { ?>
            <p><?php echo $error_msg; ?></p>
        <?php } else { ?>
            <table class="list">
                <tr>
                    <th>Position ID</th>
                    <th>Position Description</th>
                    <th>Actions</th>
                    <th>&nbsp;</th>
                </tr>

                <?php while ($position = mysqli_fetch_assoc($positions)) { ?>
                    <tr>
                        <td><?php echo h($position['position_id']); ?></td>
                        <td><?php echo h($position['position_descr']); ?></td>
                        <td><a class="action" href="?edit=<?php echo $position['position_id']; ?>">Edit</a></td>
                        <td>
                            <form action="<?php echo url_for('/pages/player_positions.php'); ?>" method="post">
                                <input type="hidden" name="position_id" value="<?php echo $position['position_id']; ?>">
                                <input type="submit" name="delete_position" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <?php if (isset($_GET['edit'])) {
                $position_id = $_GET['edit'];
                // $position = find_position_by_id($position_id);
                if ($position) { ?>
                    <h2>Edit Player Position</h2>
                    <form action="<?php echo url_for('/pages/player_positions.php'); ?>" method="post">
                        <input type="hidden" name="position_id" value="<?php echo $position['position_id']; ?>">
                        <dl>
                            <dt>Position Description</dt>
                            <dd><input type="text" name="position_descr" value="<?php echo h($position['position_descr']); ?>"></dd>
                        </dl>
                        <div id="operations">
                            <input type="submit" name="edit_position" value="Update">
                        </div>
                    </form>
                <?php } else {
                    $error_msg = "Player position not found.";
                }
            } else { ?>
                <h2>Add New Player Position</h2>
                <form action="<?php echo url_for('/pages/player_positions.php'); ?>" method="post">
                    <dl>
                        <dt>Position Description</dt>
                        <dd><input type="text" name="position_descr" value=""></dd>
                    </dl>
                    <div id="operations">
                        <input type="submit" name="add_position" value="Add Position">
                    </div>
                </form>
            <?php } ?>
        <?php } ?>

    </div>
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
