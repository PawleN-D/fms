<?php require_once('../../private/initialize.php'); ?>

<?php $page_title = 'Fixture Page'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>
<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>

    <div class="team new">
        <h1>Add Fixture</h1>

        <form action="<?php echo url_for('/staff/subjects/new.php') ?>" method="post">
            <dl>
                <dt>Team</dt>
                <dd><input type="text" name="menu_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Team Email</dt>
                <dd><input type="text" name="email" value="" /></dd>
            </dl>
            <dl>
                <dt>Select Home Team</dt>
                <dd>
                    <select name="subject_id">

                        <option value="">Team A</option>
                        <option value="">Team B</option>
                        <option value="">Team C</option>
                        <option value="">Team D</option>
                        <option value="">Team C</option>
                        <?php
                        //$subject_set = find_all_subjects();
                        //while ($subject = mysqli_fetch_assoc($subject_set)) {
                        //    echo "<option value=\"" . h($subject['id']) . "\"";
                        //    if ($page["subject_id"] == $subject['id']) {
                        //        echo " selected";
                        //   }
                        //  echo ">" . h($subject['menu_name']) . "</option>";
                        // }
                        //mysqli_free_result($subject_set);
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Select Away team</dt>
                <dd>
                    <select name="subject_id">
                        <option value="">Team A</option>
                        <option value="">Team B</option>
                        <option value="">Team C</option>
                        <option value="">Team D</option>
                        <option value="">Team C</option>
                        <?php
                        //$subject_set = find_all_subjects();
                        //while ($subject = mysqli_fetch_assoc($subject_set)) {
                        //    echo "<option value=\"" . h($subject['id']) . "\"";
                        //    if ($page["subject_id"] == $subject['id']) {
                        //        echo " selected";
                        //   }
                        //  echo ">" . h($subject['menu_name']) . "</option>";
                        // }
                        //mysqli_free_result($subject_set);
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Select Competition</dt>
                <dd>
                    <select name="subject_id">
                        <option value="">Team A</option>
                        <option value="">Team B</option>
                        <option value="">Team C</option>
                        <option value="">Team D</option>
                        <option value="">Team C</option>
                        <?php
                        //$subject_set = find_all_subjects();
                        //while ($subject = mysqli_fetch_assoc($subject_set)) {
                        //    echo "<option value=\"" . h($subject['id']) . "\"";
                        //    if ($page["subject_id"] == $subject['id']) {
                        //        echo " selected";
                        //   }
                        //  echo ">" . h($subject['menu_name']) . "</option>";
                        // }
                        //mysqli_free_result($subject_set);
                        ?>
                    </select>
                </dd>
            </dl>

            <div id="operations">
                <input type="submit" value="Submit" />
            </div>
        </form>

    </div>

</div>