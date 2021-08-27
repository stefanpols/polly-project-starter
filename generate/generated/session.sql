DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
	`session_id` varchar(36) NOT NULL,
	`user_id` varchar(36) NOT NULL, 
	`token` varchar(255) NOT NULL, 
	`created` datetime NOT NULL, 
	`last_activity` datetime NOT NULL, 
	`ip_address` varchar(255) NOT NULL, 
	`user_agent` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `session`
	ADD PRIMARY KEY (`session_id`),
	ADD KEY `user_id` (`user_id`);
COMMIT;
