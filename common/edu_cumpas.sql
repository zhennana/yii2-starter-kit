CREATE TABLE `apply_to_play` (
  `apply_to_play_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '报名人姓名',
  `phone_number` int(11) NOT NULL COMMENT '报名人电话',
  `email` varchar(128) NOT NULL COMMENT '报名人邮件',
  `city` varchar(128) NOT NULL COMMENT '市',
  `province` varchar(128) NOT NULL COMMENT '省',
  `auditor_id` int(11) NOT NULL COMMENT '审核人',
  `region` varchar(255) NOT NULL COMMENT '区',
  `status` smallint(11) NOT NULL COMMENT '报名成功：1，报名审核： 2，已过期：3',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`apply_to_play_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `auditor_id` int(11) DEFAULT NULL COMMENT '审核人',
  `phone_number` int(11) NOT NULL COMMENT '联系人电话',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '邮箱',
  `body` varchar(255) NOT NULL COMMENT '留言内容',
  `status` int(11) DEFAULT NULL COMMENT '未查看：1，已查看： 2，已过期：3'',',
  `updated_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8