CREATE USER 'aw'@'%' IDENTIFIED BY 'aw';
GRANT ALL PRIVILEGES ON `Campus360`.* TO 'aw'@'%';

CREATE USER 'aw'@'localhost' IDENTIFIED BY 'aw';
GRANT ALL PRIVILEGES ON `Campus360`.* TO 'aw'@'localhost';