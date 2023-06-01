<?php
require_once('../../private/initialize.php');

$competitions = get_all_competitions();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_comp"])) {
        $competition = [];
        $competition['comp_name'] = $_POST['comp_name'] ?? '';
        $result = insert_competition($competition);
        if ($result === true) {
            $new_id = mysqli_insert_id($db);
            header("Location: " . url_for('/pages/competitions.php'));
            exit;
        }
    } elseif (isset($_POST["edit_comp"])) {
        $competition = [];
        $competition['comp_id'] = $_POST["comp_id"];
        $competition['comp_name'] = $_POST['comp_name'] ?? '';
        $result = update_competition($competition);
        if ($result === true) {
            header("Location: " . url_for('/pages/competitions.php'));
            exit;
        }
    } elseif (isset($_POST["delete_comp"])) {
        $competition_id = $_POST["comp_id"];
        $result = delete_competition($competition_id);
        if ($result === true) {
            header("Location: " . url_for('/pages/competitions.php'));
            exit;
        }
    }
}

$page_title = 'Competition Page';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="competition new">
        <h1>Competitions Page</h1>

        <table class="list">
            <tr>
                <th>Competition</th>
                <th>Actions</th>
                <th>&nbsp;</th>
            </tr>

            <?php while ($competition = mysqli_fetch_assoc($competitions)) { ?>
                <tr>
                    <td><?php echo h($competition['comp_name']); ?></td>
                    <td><a class="action" href="?edit=<?php echo $competition["comp_id"]; ?>">Edit</a></td>
                    <td>
                        <form action="<?php echo url_for('/pages/competitions.php'); ?>" method="post">
                            <input type="hidden" name="comp_id" value="<?php echo $competition['comp_id']; ?>">
                            <input type="submit" name="delete_comp" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php if (isset($_GET['edit'])) {
            $comp_id = $_GET['edit'];
            $edit_comp_sql = "SELECT comp_id, comp_name FROM competitions WHERE comp_id = $comp_id";
            $edit_comp_result = mysqli_query($db, $edit_comp_sql);
            $competition = mysqli_fetch_assoc($edit_comp_result);
        ?>
            <form action="<?php echo url_for('/pages/competitions.php'); ?>" method="post">
                <input type="hidden" name="comp_id" value="<?php echo $competition['comp_id']; ?>">
                <dl>
                    <dt>Competition Name</dt>
                    <dd><input type="text" name="comp_name" value="<?php echo h($competition['comp_name']); ?>" /></dd>
                </dl>

                <div id="operations">
                    <input type="submit" name="edit_comp" value="Save Changes" />
                </div>
            </form>
        <?php } else { ?>
            <form action="<?php echo url_for('/pages/competitions.php'); ?>" method="post">
                <dl>
                    <dt>Competition Name</dt>
                    <dd><input type="text" name="comp_name" value="" /></dd>
                </dl>

                <div id="operations">
                    <input type="submit" name="add_comp" value="Add Competition" />
                </div>
            </form>
        <?php } ?>

    </div>

</div>
