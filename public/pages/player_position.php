<?php require_once('../../private/initialize.php'); ?>

<?php $page_title = 'Player Positions'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="page new">
        <h1>Player Positions Page</h1>


        <form action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">

            <dl>
                <dt>Add player position</dt>
                <dd><input type="text" name="menu_name" /></dd>
            </dl>


            <div id="operations">
                <input type="submit" value="Submit" />
            </div>
        </form>

    </div>

</div>