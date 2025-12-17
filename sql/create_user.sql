CREATE USER IF NOT EXISTS 'memory_of_war_db_user'@'%' IDENTIFIED BY 'user_pass123';
GRANT ALL PRIVILEGES ON memory_of_war_db.* TO 'memory_of_war_db_user'@'%';