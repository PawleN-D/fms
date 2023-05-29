<?php require_once('../../private/initialize.php'); ?>

<?php $page_title = 'Report Page'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="reports new">
        <h1>Reports Page</h1>

        <form action="<?php echo url_for('/staff/subjects/new.php') ?>" method="post">
            <dl>
                <dt>Competion Name</dt>
                <dd><input type="text" name="menu_name" value="" /></dd>
            </dl>

            <div id="operations">
                <input type="submit" value="Submit" />
            </div>
        </form>

    </div>

</div>