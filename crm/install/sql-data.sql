INSERT INTO `qs_crm_category` (`c_id`, `c_parentid`, `c_alias`, `c_name`, `c_order`, `c_index`, `disabled`) VALUES
(1, 0, 'QS_crm_status', '���ڸ���', 0, 'z', 1),
(2, 0, 'QS_crm_status', '����ͻ�', 0, 'y', 1),
(3, 0, 'QS_crm_status', '�Ѿ�����', 0, 'y', 1),
(4, 0, 'QS_crm_type', '���Ͽͻ�', 0, 'x', 0),
(5, 0, 'QS_crm_type', '���¿ͻ�', 0, 'x', 0),
(6, 0, 'QS_crm_grade', '��ͨ�ͻ�', 0, 'p', 0),
(7, 0, 'QS_crm_grade', '�ж˿ͻ�', 0, 'z', 0),
(8, 0, 'QS_crm_grade', '�߶˿ͻ�', 0, 'g', 0),
(9, 0, 'QS_crm_source', '��Դ��', 0, 'z', 0),
(10, 0, 'QS_crm_source', '������ϵ', 0, 'z', 0),
(11, 0, 'QS_crm_source', '���ѽ���', 0, 'p', 0),
(12, 0, 'QS_crm_trustworthiness', '��', 0, 'c', 0),
(13, 0, 'QS_crm_trustworthiness', '����', 0, 'l', 0),
(14, 0, 'QS_crm_trustworthiness', '����', 0, 'y', 0),
(16, 0, 'QS_crm_department', '����', 0, 'c', 0),
(17, 0, 'QS_crm_department', '���۲�', 0, 'x', 0);

INSERT INTO `qs_crm_category_group` (`g_id`, `g_alias`, `g_name`, `g_sys`) VALUES
(1, 'QS_crm_status', '�ͻ�״̬', 1),
(2, 'QS_crm_type', '�ͻ�����', 1),
(3, 'QS_crm_grade', '�ͻ��ȼ�', 1),
(4, 'QS_crm_source', '�ͻ���Դ', 1),
(5, 'QS_crm_trustworthiness', '���õȼ�', 1),
(6, 'QS_crm_department', '���Ź���', 1);

INSERT INTO `qs_crm_crons` (`cronid`, `available`, `admin_set`, `name`, `filename`, `lastrun`, `nextrun`, `weekday`, `day`, `hour`, `minute`) VALUES
(NULL, 1, 1, 'δ�ɽ��ͻ�������Դ��', 'restore_nodeal.php', 0, 0, -1, -1, 0, '30'),
(NULL, 1, 1, 'δ�����ͻ�������Դ��', 'restore_nofollow.php', 0, 0, -1, -1, 1, '0');

INSERT INTO `qs_crm_doc_category` (`c_id`, `c_name`, `c_order`, `c_adminset`) VALUES 
(null, '��ͬ�б�', 0, 1),
(null, '����۸�', 0, 1),
(null, '�Żݻ', 0, 1);

INSERT INTO `qs_crm_users_config` (`id`, `config_name`, `config_value`) VALUES
(1, 'max_receive_client_num', 30),
(2, 'follow_days', 7),
(3, 'deal_days', 15);


