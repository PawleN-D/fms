<?php
if (!isset($page_title)) {
    $page_title = 'Admin Area';
    
}
require_login(); 
?>


<!doctype html>

<html lang="en">

<head>
    <title>CSSL - <?php echo $page_title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/admin.css'); ?>" />
</head>

<body>
    <header>
        <h1>CSSL Admin Area</h1>
    </header>

    <nav>
    <ul>
            <li><a href="<?php echo url_for('/pages/competitions.php'); ?>">Competitions</a></li>
            <li><a href="<?php echo url_for('/pages/teams.php'); ?>">Teams</a></li>
            <li><a href="<?php echo url_for('/pages/fixtures.php'); ?>">Fixtures</a></li>
            <li><a href="<?php echo url_for('/pages/player_position.php'); ?>">Player Positions</a></li>
            <li><a href="<?php echo url_for('/pages/players.php'); ?>">Player Information</a></li>
            <li><a href="<?php echo url_for('/pages/player_fixtures.php'); ?>">Player Fixtures</a></li>
            <li><a href="<?php echo url_for('/pages/reports.php'); ?>">Reports</a></li>
            <li><a href="<?php echo url_for('/logout.php'); ?>">Logout</a>
        </ul>
    </nav>

    

