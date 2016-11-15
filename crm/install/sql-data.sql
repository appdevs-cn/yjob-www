INSERT INTO `qs_crm_category` (`c_id`, `c_parentid`, `c_alias`, `c_name`, `c_order`, `c_index`, `disabled`) VALUES
(1, 0, 'QS_crm_status', '正在跟进', 0, 'z', 1),
(2, 0, 'QS_crm_status', '意向客户', 0, 'y', 1),
(3, 0, 'QS_crm_status', '已经合作', 0, 'y', 1),
(4, 0, 'QS_crm_type', '线上客户', 0, 'x', 0),
(5, 0, 'QS_crm_type', '线下客户', 0, 'x', 0),
(6, 0, 'QS_crm_grade', '普通客户', 0, 'p', 0),
(7, 0, 'QS_crm_grade', '中端客户', 0, 'z', 0),
(8, 0, 'QS_crm_grade', '高端客户', 0, 'g', 0),
(9, 0, 'QS_crm_source', '资源池', 0, 'z', 0),
(10, 0, 'QS_crm_source', '主动联系', 0, 'z', 0),
(11, 0, 'QS_crm_source', '朋友介绍', 0, 'p', 0),
(12, 0, 'QS_crm_trustworthiness', '差', 0, 'c', 0),
(13, 0, 'QS_crm_trustworthiness', '良好', 0, 'l', 0),
(14, 0, 'QS_crm_trustworthiness', '优秀', 0, 'y', 0),
(16, 0, 'QS_crm_department', '财务部', 0, 'c', 0),
(17, 0, 'QS_crm_department', '销售部', 0, 'x', 0);

INSERT INTO `qs_crm_category_group` (`g_id`, `g_alias`, `g_name`, `g_sys`) VALUES
(1, 'QS_crm_status', '客户状态', 1),
(2, 'QS_crm_type', '客户类型', 1),
(3, 'QS_crm_grade', '客户等级', 1),
(4, 'QS_crm_source', '客户来源', 1),
(5, 'QS_crm_trustworthiness', '信用等级', 1),
(6, 'QS_crm_department', '部门管理', 1);

INSERT INTO `qs_crm_crons` (`cronid`, `available`, `admin_set`, `name`, `filename`, `lastrun`, `nextrun`, `weekday`, `day`, `hour`, `minute`) VALUES
(NULL, 1, 1, '未成交客户返回资源池', 'restore_nodeal.php', 0, 0, -1, -1, 0, '30'),
(NULL, 1, 1, '未跟进客户返回资源池', 'restore_nofollow.php', 0, 0, -1, -1, 1, '0');

INSERT INTO `qs_crm_doc_category` (`c_id`, `c_name`, `c_order`, `c_adminset`) VALUES 
(null, '合同列表', 0, 1),
(null, '服务价格', 0, 1),
(null, '优惠活动', 0, 1);

INSERT INTO `qs_crm_users_config` (`id`, `config_name`, `config_value`) VALUES
(1, 'max_receive_client_num', 30),
(2, 'follow_days', 7),
(3, 'deal_days', 15);


