<?php require_once('../../private/initialize.php'); ?>

<?php $page_title = 'Players Info'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="competition new">
        <h1>Player Information Page</h1>

        <form action="<?php echo url_for('/staff/subjects/new.php') ?>" method="post">
            <dl>
                <dt>Surname Name</dt>
                <dd><input type="text" name="menu_name" value="" /></dd>
            </dl>
            <dl>
                <dt>Select Team</dt>
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
                <dt>Number</dt>
                <dd><input type="number" name="number" value="" /></dd>
            </dl>


            <div id="operations">
                <input type="submit" value="Submit" />
            </div>
        </form>

    </div>

</div>