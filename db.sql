CREATE TABLE `tg_users` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `first_name` text COLLATE utf8mb4_bin,
  `last_name` text COLLATE utf8mb4_bin,
  `username` text COLLATE utf8mb4_bin,
  `language_code` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `start` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

ALTER TABLE `tg_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD KEY `uid_2` (`uid`);

ALTER TABLE `tg_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

