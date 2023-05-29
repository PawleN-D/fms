<?php 
require_once('../../private/initialize.php'); 

$page = ''

?>

<?php $page_title = 'Competition Page'; ?>
<?php include(SHARED_PATH . '/admin_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to Menu</a>

    <div class="competition new">
        <h1>Competitions Page</h1>

        <table class="list">
  	  <tr>
        <th>Competition</th>
        <th>Actions</th>
  	  </tr>

      <?php while($page) { ?>
        <tr>
          <td><?php echo h('Competi'); ?></td>
           <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>



        <form action="<?php echo url_for('/staff/subjects/new.php') ?>" method="post">
            <dl>
                <dt>Competion Name</dt>
                <dd><input type="text" name="menu_name
                " value="" /></dd>
            </dl>

            <div id="operations">
                <input type="submit" value="Submit" />
            </div>
        </form>

    </div>

</div>