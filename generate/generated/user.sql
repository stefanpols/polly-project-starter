DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
	`user_id` varchar(36) NOT NULL,
	`firstname` varchar(255) NOT NULL, 
	`lastname` varchar(255) NOT NULL, 
	`username` varchar(255) NOT NULL, 
	`password` varchar(255) NOT NULL, 
	`created` datetime NOT NULL, 
	`active` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `user`
	ADD PRIMARY KEY (`user_id`);
