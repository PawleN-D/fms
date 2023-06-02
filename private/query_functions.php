<?php

  // Get all teams
  function get_all_teams() {
    global $db;

    $sql = "SELECT * FROM teams ";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    // echo $result;
    confirm_result_set($result);
    return $result;
  }

  function insert_team($team) {
    global $db;

    // $errors = validate_page($team);
    // if(!empty($errors)) {
    //   return $errors;
    // }

    $sql = "INSERT INTO teams ";
    $sql .= "(team_name, team_email) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $team['team_name']) . "',";
    $sql .= "'" . db_escape($db, $team['team_email']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function delete_team($team_id) {
    global $db;

    // Get player IDs associated with the team
    $player_ids_sql = "SELECT player_id FROM players WHERE team_id = '" . db_escape($db, $team_id) . "'";
    $player_ids_result = mysqli_query($db, $player_ids_sql);
    
    // Delete associated playerfixture records
    while ($player_id_row = mysqli_fetch_assoc($player_ids_result)) {
        $delete_playerfixtures_sql = "DELETE FROM playerfixtures WHERE player_id = '" . db_escape($db, $player_id_row['player_id']) . "'";
        mysqli_query($db, $delete_playerfixtures_sql);
    }

    // Delete associated players
    $delete_players_sql = "DELETE FROM players WHERE team_id = '" . db_escape($db, $team_id) . "'";
    mysqli_query($db, $delete_players_sql);

    // Delete the team
    $delete_team_sql = "DELETE FROM teams WHERE team_id = '" . db_escape($db, $team_id) . "' LIMIT 1";
    $result = mysqli_query($db, $delete_team_sql);

    if ($result && mysqli_affected_rows($db) > 0) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
  }

  function update_team($team) {
    global $db;

    // $errors = validate_subject($subject);
    // if(!empty($errors)) {
    //   return $errors;
    // }

    $sql = "UPDATE teams SET ";
    $sql .= "team_name='" . db_escape($db, $team['team_name']) . "', ";
    $sql .= "team_email='" . db_escape($db, $team['team_email']) . "' ";
    $sql .= "WHERE team_id='" . db_escape($db, $team['team_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  //Competitions
  function get_all_competitions() {
    global $db;

    $sql = "SELECT * FROM competitions ";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    // echo $result;
    confirm_result_set($result);
    return $result;
  }

  function insert_competition($competition) {
    global $db;

    // $errors = validate_page($team);
    // if(!empty($errors)) {
    //   return $errors;
    // }

    $sql = "INSERT INTO competitions ";
    $sql .= "(comp_name) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $competition['comp_name']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_competition($competition) {
    global $db;

    // $errors = validate_subject($subject);
    // if(!empty($errors)) {
    //   return $errors;
    // }

    $sql = "UPDATE competitions SET ";
    $sql .= "comp_name='" . db_escape($db, $competition['comp_name']) . "' ";
    $sql .= "WHERE comp_id='" . db_escape($db, $competition['comp_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  function delete_competition($id) {
    global $db;

    $sql = "DELETE FROM competitions ";
    $sql .= "WHERE comp_id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  // Positions
  function get_all_position() {
    global $db;

    $sql = "SELECT * FROM playerPosition ";
    //echo $sql;
    $result = mysqli_query($db, $sql);
    // echo $result;
    confirm_result_set($result);
    return $result;
  }

  function insert_position($competition) {
    global $db;

    // $errors = validate_page($team);
    // if(!empty($errors)) {
    //   return $errors;
    // }

    $sql = "INSERT INTO playerPosition ";
    $sql .= "(comp_name) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $competition['comp_name']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }


  // Player Fixtures 

  // function get_all_fixtures() {
  //   global $db;

  //   $sql = "SELECT * FROM fixtures";
  //   $result = mysqli_query($db, $sql);
  //   confirm_result_set($result);
  //   return $result;
  // }


  function insert_player_fixture($player_fixture) {
    global $db;

    $sql = "INSERT INTO playerfixtures ";
    $sql .= "(player_id, fixture_id, goals_scored) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $player_fixture['player_id']) . "', ";
    $sql .= "'" . db_escape($db, $player_fixture['fixture_id']) . "', ";
    $sql .= "'" . db_escape($db, $player_fixture['goals_scored']) . "'";
    $sql .= ")";

    $result = mysqli_query($db, $sql);
    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
  }

  function get_all_player_fixtures() {
    global $db;

    $sql = "SELECT * FROM playerfixtures";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function update_player_fixture($player_fixture) {
    global $db;

    $sql = "UPDATE playerfixtures SET ";
    $sql .= "goals_scored='" . db_escape($db, $player_fixture['goals_scored']) . "' ";
    $sql .= "WHERE fixture_id='" . db_escape($db, $player_fixture['player_fixture_id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    if ($result) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
  }

  function delete_player_fixture($player_fixture_id) {
    global $db;

    $sql = "DELETE FROM playerfixtures ";
    $sql .= "WHERE fixture_id='" . db_escape($db, $player_fixture_id) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    if ($result && mysqli_affected_rows($db) > 0) {
        return true;
    } else {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
  }


  function find_player_fixture($fixture_id, $player_id) {
    global $db;

    $fixture_id = db_escape($db, $fixture_id);
    $player_id = db_escape($db, $player_id);

    $sql = "SELECT * FROM playerfixtures ";
    $sql .= "WHERE fixture_id = '" . $fixture_id . "' ";
    $sql .= "AND player_id = '" . $player_id . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $player_fixture = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $player_fixture;
}

// Fixtures 

// Retrieve all fixtures
function get_all_fixtures() {
  global $db;

  $sql = "SELECT f.fixture_id, f.fixture_date, f.fixture_time, t1.team_name AS home_team, t2.team_name AS away_team, c.comp_name AS competition
          FROM fixtures f
          INNER JOIN teams t1 ON f.home_teamID = t1.team_id
          INNER JOIN teams t2 ON f.away_teamID = t2.team_id
          INNER JOIN competitions c ON f.comp_id = c.comp_id
          ORDER BY f.fixture_date DESC";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);

  $fixtures = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $fixtures[] = $row;
  }

  mysqli_free_result($result);
  return $fixtures;
}

// Insert a new fixture
function insert_fixture($fixture) {
  global $db;

  $fixture_date = $fixture['fixture_date'] ?? '';
  $fixture_time = $fixture['fixture_time'] ?? '';
  $home_teamID = $fixture['home_teamID'] ?? '';
  $away_teamID = $fixture['away_teamID'] ?? '';
  $comp_id = $fixture['comp_id'] ?? '';

  $sql = "INSERT INTO fixtures (fixture_date, fixture_time, home_teamID, away_teamID, comp_id)
          VALUES ('$fixture_date', '$fixture_time', $home_teamID, $away_teamID, $comp_id)";

  $result = mysqli_query($db, $sql);
  if ($result) {
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

// Find a fixture by ID
function find_fixture_by_id($fixture_id) {
  global $db;

  $sql = "SELECT f.fixture_id, f.fixture_date, f.fixture_time, f.home_teamID, f.away_teamID, f.comp_id, t1.team_name AS home_team, t2.team_name AS away_team, c.comp_name AS competition
          FROM fixtures f
          INNER JOIN teams t1 ON f.home_teamID = t1.team_id
          INNER JOIN teams t2 ON f.away_teamID = t2.team_id
          INNER JOIN competitions c ON f.comp_id = c.comp_id
          WHERE f.fixture_id = $fixture_id";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $fixture = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $fixture;
}

// Update a fixture
function update_fixture($fixture) {
  global $db;

  $fixture_id = $fixture['fixture_id'] ?? '';
  $fixture_date = $fixture['fixture_date'] ?? '';
  $fixture_time = $fixture['fixture_time'] ?? '';
  $home_teamID = $fixture['home_teamID'] ?? '';
  $away_teamID = $fixture['away_teamID'] ?? '';
  $comp_id = $fixture['comp_id'] ?? '';

  $sql = "UPDATE fixtures SET
          fixture_date = '$fixture_date',
          fixture_time = '$fixture_time',
          home_teamID = $home_teamID,
          away_teamID = $away_teamID,
          comp_id = $comp_id
          WHERE fixture_id = $fixture_id";

  $result = mysqli_query($db, $sql);
  if ($result) {
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

// Delete a fixture
function delete_fixture($fixture_id) {
  global $db;

  $sql = "DELETE FROM fixtures WHERE fixture_id = $fixture_id";
  $result = mysqli_query($db, $sql);
  if ($result) {
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}





function find_player_fixture_by_id($player_fixture_id) {
  global $db;

  $player_fixture_id = db_escape($db, $player_fixture_id);

  $sql = "SELECT * FROM playerfixtures ";
  $sql .= "WHERE fixture_id = '$player_fixture_id' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $player_fixture = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $player_fixture;
}


  // Players

  function get_all_players() {
    global $db;
    $sql = "SELECT players.*, teams.team_name, playerPosition.position_descr FROM players 
            INNER JOIN teams ON players.team_id = teams.team_id 
            INNER JOIN playerPosition ON players.position_id = playerPosition.position_id";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

// function get_players_with_fixtures_and_goals() {
//   global $db;

//   $sql = "SELECT p.player_id, p.player_name, f.fixture_id, f.goals
//           FROM players p
//           LEFT JOIN fixtures f ON p.player_id = f.player_id";

//   $result = mysqli_query($db, $sql);
//   confirm_result_set($result);

//   $players = array();
//   while ($row = mysqli_fetch_assoc($result)) {
//       $player_id = $row['player_id'];
//       if (!isset($players[$player_id])) {
//           $players[$player_id] = array(
//               'player_id' => $row['player_id'],
//               'player_name' => $row['player_name'],
//               'fixtures' => array()
//           );
//       }

//       if (!empty($row['fixture_id'])) {
//           $players[$player_id]['fixtures'][] = array(
//               'fixture_id' => $row['fixture_id'],
//               'goals' => $row['goals']
//           );
//       }
//   }

//   mysqli_free_result($result);
//   return array_values($players);
// }

function get_players_with_fixtures_and_goals() {
  global $db;

  $sql = "SELECT p.player_id, p.player_name, f.fixture_id, f.goals_scored
          FROM players p
          LEFT JOIN playerfixtures f ON p.player_id = f.player_id";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);


  $players = array();
  while ($row = mysqli_fetch_assoc($result)) {
      $player_id = $row['player_id'];
      if (!isset($players[$player_id])) {
          $players[$player_id] = array(
              'player_id' => $row['player_id'],
              'player_name' => $row['player_name'],
              'fixtures' => array()
          );
      }

      if (!empty($row['fixture_id'])) {
          $players[$player_id]['fixtures'][] = array(
              'fixture_id' => $row['fixture_id'],
              'goals_scored' => $row['goals_scored']
          );
      
      }
  }

  mysqli_free_result($result);
  return $players;
}



function insert_player($player) {
  global $db;

  $team_id = $player['team_id'];
  $player_name = $player['player_name'];
  $player_sqd_num = $player['player_sqd_num'];
  $position_id = $player['position_id'];

  $sql = "INSERT INTO players (team_id, player_name, player_sqd_num, position_id)
          VALUES ('$team_id', '$player_name', '$player_sqd_num', '$position_id')";
  $result = mysqli_query($db, $sql);

  if ($result) {
      return true;
  } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
  }
}


function update_player($player) {
  global $db;

  $player_id = $player['player_id'];
  $team_id = $player['team_id'];
  $player_name = $player['player_name'];
  $player_sqd_num = $player['player_sqd_num'];
  $position_id = $player['position_id'];

  $sql = "UPDATE players 
          SET team_id = '$team_id', player_name = '$player_name', player_sqd_num = '$player_sqd_num', position_id = '$position_id' 
          WHERE player_id = '$player_id'";
  $result = mysqli_query($db, $sql);

  if ($result) {
      return true;
  } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
  }
}


function find_player_by_id($player_id) {
  global $db;

  $player_id = db_escape($db, $player_id);

  $sql = "SELECT * FROM players ";
  $sql .= "WHERE player_id = '$player_id' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $player = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $player;
}

function delete_player($player_id) {
  global $db;

  $player_id = db_escape($db, $player_id);

  $sql = "DELETE FROM players ";
  $sql .= "WHERE player_id = '$player_id' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  // For DELETE statements, $result is true/false
  if ($result) {
      return true;
  } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
  }
}

// Positions 
function update_position($position) {
  global $db;

  $position_id = $position['position_id'];
  $position_descr = $position['position_descr'];

  $sql = "UPDATE playerPosition SET position_descr = '$position_descr' WHERE position_id = $position_id";
  $result = mysqli_query($db, $sql);

  return $result;
}

function find_position_by_id($position_id) {
  global $db;

  $sql = "SELECT * FROM playerPosition WHERE position_id = $position_id";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);

  $position = mysqli_fetch_assoc($result);
  mysqli_free_result($result);

  return $position;
}

function delete_position($position_id) {
  global $db;

  $sql = "DELETE FROM playerPosition WHERE position_id = $position_id";
  $result = mysqli_query($db, $sql);

  return $result;
}

// Goals 

function get_goals_by_fixture($player_id) {
  global $db;

  $sql = "SELECT fixture_id, goals_scored
          FROM playerfixtures
          WHERE player_id = " . $player_id;

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);

  $goals = array();
  while ($row = mysqli_fetch_assoc($result)) {
      $goals[$row['fixture_id']] = $row['goals'];
  }

  mysqli_free_result($result);
  return $goals;
}

function get_total_goals_by_player($player_id) {
  global $db;

  $sql = "SELECT SUM(goals_scored) AS total_goals
          FROM playerfixtures
          WHERE player_id = " . $player_id;

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);

  $row = mysqli_fetch_assoc($result);
  $total_goals = $row['total_goals'];

  mysqli_free_result($result);
  return $total_goals;
}
