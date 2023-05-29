<?php
require_once('../../private/initialize.php');

// Function to get all teams from the database
// function get_all_teams()
// {
//     global $db;
//     $sql = "SELECT * FROM teams";
//     $result = mysqli_query($db, $sql);
//     return $result;
// }

$teams_set = get_all_teams();

// Function to insert a new team into the database
// function insert_team($team)
// {
//     global $db;
//     $team_name = mysqli_real_escape_string($db, $team['team_name']);
//     $team_email = mysqli_real_escape_string($db, $team['team_email']);
//     $sql = "INSERT INTO teams (team_name, team_email) VALUES ('$team_name', '$team_email')";
//     $result = mysqli_query($db, $sql);
//     return $result;
// }

// Function to update a team in the database
// function update_team($team_id, $team_name, $team_email)
// {
//     global $db;
//     $team_name = mysqli_real_escape_string($db, $team_name);
//     $team_email = mysqli_real_escape_string($db, $team_email);
//     $sql = "UPDATE teams SET team_name = '$team_name', team_email = '$team_email' WHERE team_id = '$team_id'";
//     $result = mysqli_query($db, $sql);
//     return $result;
// }

// Function to delete a team from the database
// function delete_team($team_id)
// {
//     global $db;
//     $sql = "DELETE FROM teams WHERE team_id = '$team_id'";
//     $result = mysqli_query($db, $sql);
//     return $result;
// }

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_team"])) {
        $team = [];
        $team['team_name'] = $_POST['team_name'] ?? '';
        $team['team_email'] = $_POST['team_email'] ?? '';
        $result = insert_team($team);
        if ($result === true) {
            $new_id = mysqli_insert_id($db);
            // header("Location: " . url_for('/staff/teams/show.php?id=' . $new_id));
            // exit;
        }
    } elseif (isset($_POST["edit_team"])) {
        $team_id = $_POST["team_id"];
        $team_name = $_POST["team_name"];
        $team_email = $_POST["team_email"];
        $result = update_team($team_id, $team_name, $team_email);
    } elseif (isset($_POST["delete_team"])) {
        $team_id = $_POST["team_id"];
        $result = delete_team($team_id);
    }
}

$teams_set = get_all_teams();
$team_title = 'Add Team team';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">
    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>

    <table class="list">
        <tr>
            <th>Team</th>
            <th>Team email</th>
            <th>Actions</th>
            <th>&nbsp;</th>
        </tr>

        <?php while ($team = mysqli_fetch_assoc($teams_set)) { ?>
            <tr>
                <td><?php echo h($team['team_name']); ?></td>
                <td><?php echo h($team['team_email']); ?></td>
                <td><a href="?edit=<?php echo $team["team_id"]; ?>">Edit</a><td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="team_id" value="<?php echo $team["team_id"]; ?>">
                        <input type="submit" name="delete_team" value="Delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="team new">
        <h1>Add Team</h1>
        <form action="<?php echo url_for('pages/teams.php') ?>" method="post">
            <dl>
                <dt>Team</dt>
                <dd><input type="text" name="team_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Team Email</dt>
                <dd><input type="text" name="team_email" value="" /></dd>
            </dl>

            <div id="operations">
                <input type="submit" name="add_team" value="Submit" />
            </div>
        </form>
    </div>

    <!-- Edit team form -->
    <?php if (isset($_GET["edit"])) : ?>
        <?php
        $edit_team_id = $_GET["edit"];
        $edit_team_sql = "SELECT team_id, team_name, team_email FROM teams WHERE team_id = $edit_team_id";
        $edit_team_result = mysqli_query($db, $edit_team_sql);
        $edit_team_row = mysqli_fetch_assoc($edit_team_result);
        if ($edit_team_row) :
        ?>
            <h2>Edit Team</h2>
            <form method="POST">
                <input type="hidden" name="team_id" value="<?php echo $edit_team_row["team_id"]; ?>">
                <dl>
                    <dt>Team Name</dt>
                    <dd><input type="text" name="team_name" value="<?php echo $edit_team_row["team_name"]; ?>" required></dd>
                </dl>
                <dl>
                    <dt>Team Email</dt>
                    <dd><input type="text" name="team_email" value="<?php echo $edit_team_row["team_email"]; ?>" required></dd>
                </dl>
                <div id="operations">
                    <input type="submit" name="edit_team" value="Update Team">
                </div>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
