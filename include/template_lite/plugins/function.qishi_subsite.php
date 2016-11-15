<?php
function tpl_function_qishi_subsite($params, &$smarty)
{
global $db;
$list = $db->getall("select d.id,d.categoryname,s.s_id from ".table('category_district')." as d left join ".table('subsite')." as s on d.id=s.s_district AND s.s_effective=1 where d.parentid=0");
$data = array();
foreach ($list as $key => $value) {
	$data[$key]['s_id'] = $value['s_id'];
	$data[$key]['s_district'] = $value['id'];
	$data[$key]['s_districtname'] = $value['categoryname'];
}
$smarty->assign('list',$data);
}
?>