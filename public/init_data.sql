CREATE TABLE `sql_execution_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` varchar(30) NOT NULL,
  `sql` varchar(500) NOT NULL DEFAULT '',
  `time` double(8,2) NOT NULL DEFAULT '0.00',
  `error` varchar(500) DEFAULT '',
  `create_time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin_menu_node` (`id`, `pid`, `sort`, `level`, `title`, `url`, `is_show`, `is_delete`, `create_time`) VALUES
(1, 0, 1, 1, 'Index', 'admin/index/index', 1, 0, 1731320894),
(2, 0, 2, 1, 'Data Management', '', 1, 0, 1731320894),
(3, 2, 3, 2, 'SQl Execution', 'admin/dev/index', 1, 0, 1731320894);

INSERT INTO `admin_role` (`id`, `role_name`, `create_time`) VALUES
(1, 'Super Admin', 1731324060),
(2, 'Normal User', 1731324060);


INSERT INTO `admin_role_nodes` (`id`, `role_id`, `node_id`, `create_time`) VALUES
(1, 2, 1, 1731322201);


INSERT INTO `admin_user` (`id`, `username`, `password`, `salt`, `role_ids`, `disabled`, `last_login_time`, `create_time`) VALUES
(1, 'admin', 'cd8b70f295f363c8bacb4e447b1b1b6b884fa67a', 'KHL2fe', '1', 0, 1731067921, 1731067921),
(2, 'user2', 'cd8b70f295f363c8bacb4e447b1b1b6b884fa67a', 'KHL2fe', '2', 0, 1731074461, 1731074461);