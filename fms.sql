DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  team_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  team_name VARCHAR(255),
  team_email VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `competitions`;
CREATE TABLE `competitions` (
  comp_id INT AUTO_INCREMENT PRIMARY KEY,
  comp_name VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `playerPosition`;
CREATE TABLE `playerPosition` (
  position_id INT PRIMARY KEY,
  position_descr VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  player_id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  player_name VARCHAR(255),
  player_sqd_num INT,
  position_id INT,
  FOREIGN KEY (team_id) REFERENCES Teams(team_id),
  FOREIGN KEY (position_id) REFERENCES playerPosition(position_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `fixtures`;
CREATE TABLE `fixtures` (
  fixture_id INT AUTO_INCREMENT PRIMARY KEY,
  fixture_date DATE,
  fixture_time TIME,
  home_teamID INT,
  away_teamID INT,
  comp_id INT,
  FOREIGN KEY (home_teamID) REFERENCES Teams(team_id),
  FOREIGN KEY (away_teamID) REFERENCES Teams(team_id),
  FOREIGN KEY (comp_id) REFERENCES Competitions(comp_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `playerFixtures`;
CREATE TABLE `playerFixtures` (
  fixture_id INT,
  player_id INT,
  goals_scored INT,
  FOREIGN KEY (fixture_id) REFERENCES Fixtures(fixture_id),
  FOREIGN KEY (player_id) REFERENCES Players(player_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

