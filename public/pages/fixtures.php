<?php
require_once('../../private/initialize.php');

$fixtures = get_all_fixtures();

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["add_fixture"])) {
    $fixture = [];
    $fixture['fixture_date'] = $_POST['fixture_date'] ?? '';
    $fixture['fixture_time'] = $_POST['fixture_time'] ?? '';
    $fixture['home_teamID'] = $_POST['home_teamID'] ?? '';
    $fixture['away_teamID'] = $_POST['away_teamID'] ?? '';
    $fixture['comp_id'] = $_POST['comp_id'] ?? '';
    $result = insert_fixture($fixture);
    if ($result === true) {
      header("Location: " . url_for('/pages/fixtures.php'));
      exit;
    }
  } elseif (isset($_POST["edit_fixture"])) {
    $fixture = [];
    $fixture['fixture_id'] = $_POST['fixture_id'];
    $fixture['fixture_date'] = $_POST['fixture_date'] ?? '';
    $fixture['fixture_time'] = $_POST['fixture_time'] ?? '';
    $fixture['home_teamID'] = $_POST['home_teamID'] ?? '';
    $fixture['away_teamID'] = $_POST['away_teamID'] ?? '';
    $fixture['comp_id'] = $_POST['comp_id'] ?? '';
    $result = update_fixture($fixture);
    if ($result === true) {
      header("Location: " . url_for('/pages/fixtures.php'));
      exit;
    }
  } elseif (isset($_POST["delete_fixture"])) {
    $fixture_id = $_POST["fixture_id"];
    $fixture = find_fixture_by_id($fixture_id);
    if ($fixture) {
      // Display confirmation message before deleting
      $confirm_msg = "Are you sure you want to delete the fixture between " . h($fixture['home_team']) . " and " . h($fixture['away_team']) . "?";
    } else {
      // Fixture not found, display error message
      $error_msg = "Fixture not found.";
    }
  } elseif (isset($_POST["confirm_delete"])) {
    $fixture_id = $_POST["fixture_id"];
    $result = delete_fixture($fixture_id);
    if ($result === true) {
      header("Location: " . url_for('/pages/fixtures.php'));
      exit;
    }
  }
}

$teams = get_all_teams();
$competitions = get_all_competitions();

$page_title = 'Fixtures';
include(SHARED_PATH . '/admin_header.php');
?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

  <div class="fixtures new">
    <h1>Fixtures</h1>

    <?php if (isset($confirm_msg)) { ?>
      <p><?php echo $confirm_msg; ?></p>
      <form action="<?php echo url_for('/pages/fixtures.php'); ?>" method="post">
        <input type="hidden" name="fixture_id" value="<?php echo $fixture_id; ?>">
        <input type="submit" name="confirm_delete" value="Delete">
        <a class="action" href="<?php echo url_for('/pages/fixtures.php'); ?>">Cancel</a>
      </form>
    <?php } elseif (isset($error_msg)) { ?>
      <p><?php echo $error_msg; ?></p>
    <?php } else { ?>
      <table class="list">
        <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Home Team</th>
          <th>Away Team</th>
          <th>Competition</th>
          <th>Actions</th>
          <th>&nbsp;</th>
        </tr>

        <?php foreach ($fixtures as $fixture) { ?>
          <tr>
            <td><?php echo h($fixture['fixture_date']); ?></td>
            <td><?php echo h($fixture['fixture_time']); ?></td>
            <td><?php echo h($fixture['home_team']); ?></td>
            <td><?php echo h($fixture['away_team']); ?></td>
            <td><?php echo h($fixture['competition']); ?></td>
            <td><a class="action" href="?edit=<?php echo $fixture['fixture_id']; ?>">Edit</a></td>
            <td>
              <form action="<?php echo url_for('/pages/fixtures.php'); ?>" method="post">
                <input type="hidden" name="fixture_id" value="<?php echo $fixture['fixture_id']; ?>">
                <input type="submit" name="delete_fixture" value="Delete">
              </form>
            </td>
          </tr>
        <?php } ?>
      </table>

      <?php if (isset($_GET['edit'])) {
        $fixture_id = $_GET['edit'];
        $fixture = find_fixture_by_id($fixture_id);
        if ($fixture) { ?>
          <h2>Edit Fixture</h2>
          <form action="<?php echo url_for('/pages/fixtures.php'); ?>" method="post">
            <input type="hidden" name="fixture_id" value="<?php echo $fixture['fixture_id']; ?>">
            <dl>
              <dt>Date</dt>
              <dd><input type="date" name="fixture_date" value="<?php echo h($fixture['fixture_date']); ?>"></dd>
              <dt>Time</dt>
              <dd><input type="time" name="fixture_time" value="<?php echo h($fixture['fixture_time']); ?>"></dd>
              <dt>Home Team</dt>
              <dd>
                <select name="home_teamID">
                  <?php while ($team = mysqli_fetch_assoc($teams)) { ?>
                    <option value="<?php echo h($team['team_id']); ?>" <?php if ($team['team_id'] == $fixture['home_teamID']) echo "selected"; ?>><?php echo h($team['team_name']); ?></option>
                  <?php } ?>
                </select>
              </dd>
              <dt>Away Team</dt>
              <dd>
                <select name="away_teamID">
                  <?php mysqli_data_seek($teams, 0); // Reset the teams result set pointer ?>
                  <?php while ($team = mysqli_fetch_assoc($teams)) { ?>
                    <option value="<?php echo h($team['team_id']); ?>" <?php if ($team['team_id'] == $fixture['away_teamID']) echo "selected"; ?>><?php echo h($team['team_name']); ?></option>
                  <?php } ?>
                </select>
              </dd>
              <dt>Competition</dt>
              <dd>
                <select name="comp_id">
                  <?php while ($competition = mysqli_fetch_assoc($competitions)) { ?>
                    <option value="<?php echo h($competition['comp_id']); ?>" <?php if ($competition['comp_id'] == $fixture['comp_id']) echo "selected"; ?>><?php echo h($competition['comp_name']); ?></option>
                  <?php } ?>
                </select>
              </dd>
            </dl>
            <div id="operations">
              <input type="submit" name="edit_fixture" value="Save">
            </div>
          </form>
        <?php } else { ?>
          <p>Fixture not found.</p>
        <?php }
      } else { ?>
        <h2>Add Fixture</h2>
        <form action="<?php echo url_for('/pages/fixtures.php'); ?>" method="post">
          <dl>
            <dt>Date</dt>
            <dd><input type="date" name="fixture_date"></dd>
            <dt>Time</dt>
            <dd><input type="time" name="fixture_time"></dd>
            <dt>Home Team</dt>
            <dd>
              <select name="home_teamID">
                <?php while ($team = mysqli_fetch_assoc($teams)) { ?>
                  <option value="<?php echo h($team['team_id']); ?>"><?php echo h($team['team_name']); ?></option>
                <?php } ?>
              </select>
            </dd>
            <dt>Away Team</dt>
            <dd>
              <select name="away_teamID">
                <?php mysqli_data_seek($teams, 0); // Reset the teams result set pointer ?>
                <?php while ($team = mysqli_fetch_assoc($teams)) { ?>
                  <option value="<?php echo h($team['team_id']); ?>"><?php echo h($team['team_name']); ?></option>
                <?php } ?>
              </select>
            </dd>
            <dt>Competition</dt>
            <dd>
              <select name="comp_id">
                <?php while ($competition = mysqli_fetch_assoc($competitions)) { ?>
                  <option value="<?php echo h($competition['comp_id']); ?>"><?php echo h($competition['comp_name']); ?></option>
                <?php } ?>
              </select>
            </dd>
          </dl>
          <div id="operations">
            <input type="submit" name="add_fixture" value="Add Fixture">
          </div>
        </form>
      <?php } ?>
    <?php } ?>
  </div>
</div>

<?php include(SHARED_PATH . '/admin_footer.php'); ?>
