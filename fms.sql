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


Certainly! Here's an example of sample data that you can insert into each table while maintaining the relationships between the foreign keys:

INSERT INTO teams (team_name, team_email) VALUES
  ('Team A', 'team_a@example.com'),
  ('Team B', 'team_b@example.com'),
  ('Team C', 'team_c@example.com'),
  ('Team D', 'team_d@example.com');

INSERT INTO competitions (comp_name) VALUES
  ('Tournament 1'),
  ('Tournament 2'),
  ('Tournament 3');

INSERT INTO playerPosition (position_id, position_descr) VALUES
  (1, 'GK'),
  (2, 'CB'),
  (3, 'LB'),
  (4, 'FB'),
  (5, 'LWB'),
  (6, 'RWB'),
  (7, 'SW'),
  (8, 'DM'),
  (9, 'CM'),
  (10, 'AM'),
  (11, 'LW'),
  (12, 'RW'),
  (13, 'CF'),
  (14, 'WF');

INSERT INTO players (team_id, player_name, player_sqd_num, position_id) VALUES
  (1, 'Player 1', 10, 1),
  (1, 'Player 2', 7, 4),
  (2, 'Player 3', 5, 6),
  (2, 'Player 4', 9, 9),
  (3, 'Player 5', 11, 3),
  (3, 'Player 6', 2, 8),
  (4, 'Player 7', 8, 11),
  (4, 'Player 8', 6, 13);


INSERT INTO fixtures (fixture_date, fixture_time, home_teamID, away_teamID, comp_id) VALUES
  ('2023-06-01', '18:00:00', 1, 2, 1),
  ('2023-06-02', '15:30:00', 3, 4, 2),
  ('2023-06-03', '20:45:00', 2, 1, 1);


INSERT INTO playerFixtures (fixture_id, player_id, goals_scored) VALUES
  (1, 1, 2),
  (1, 2, 1),
  (2, 3, 0),
  (2, 4, 1),
  (3, 5, 3),
  (3, 6, 2);

Note: This is just an example of sample data. You can modify it according to your specific requirements and add more records as needed.