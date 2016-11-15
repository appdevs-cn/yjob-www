<?php

 /*

 * 74cms WAP

 * ============================================================================

 * 版权所有: 骑士网络，并保留所有权利。

 * 网站地址: http://www.74cms.com；

 * ----------------------------------------------------------------------------

 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和

 * 使用；不允许对程序代码以任何形式任何目的的再发布。

 * ============================================================================

*/

define('IN_QISHI', true);

define('REQUEST_MOBILE',true);



require_once(dirname(__FILE__).'/../../include/common.inc.php');

require_once(QISHI_ROOT_PATH.'include/fun_wap.php');

require_once(QISHI_ROOT_PATH.'include/mysql.class.php');

require_once(QISHI_ROOT_PATH.'include/fun_personal.php');

$smarty->cache = false;

$db = new mysql($dbhost,$dbuser,$dbpass,$dbname);

wap_weixin_openid($_GET['code']);

$act = !empty($_REQUEST['act']) ? trim($_REQUEST['act']) : 'apply';

if ($_SESSION['uid']=='' || $_SESSION['username']==''||intval($_SESSION['utype'])==1)

{

	header("Location: ../login.php");

}

$user = get_user_info($_SESSION['uid']);

if($_CFG['login_per_audit_mobile'] && $user['mobile_audit']=="0")

{

	$str= "<script>";

	$str.="alert('请先验证手机！');";

	$str.="window.location.href='account_security.php';";

	$str.= "</script>";

	echo $str;

}

elseif ($act == 'apply')

{

	$wheresql=" WHERE a.personal_uid='{$_SESSION['uid']}' ";

	$perpage = 6;

	$count  = 0;

	$page = empty($_GET['page'])?1:intval($_GET['page']);

	if($page<1) $page = 1;

	$start = ($page-1)*$perpage;

	$total_sql="SELECT COUNT(*) AS num FROM  ".table('personal_jobs_apply')." as a  {$wheresql}";

	$count=$db->get_total($total_sql);

	$joinsql.=" LEFT JOIN ".table('jobs')." AS j ON a.jobs_id=j.id ";

	$smarty->assign('apply',$ddd=get_apply_jobs($start,$perpage,$joinsql,$wheresql));

	$smarty->display("m/personal/m-apply.html");	

}

elseif ($act == 'apply_add')
{
    $postData['job_id']=intval($_POST["job_id"])?intval($_POST["job_id"]):exit("出错了");
    $postData['job_info_id']=intval($_POST["job_info_id"])?intval($_POST["job_info_id"]):exit("请选择点位");
    $postData['resume_id']= $resumeid = intval($_POST["resume_id"])?intval($_POST["resume_id"]):exit("出错了");
    $postData['enroll_type'] = 100;
    $postData['uid'] = $_SESSION['uid'];
    if(empty($_POST['work_date'])) {
        exit("请选择报名日期!");
    }
    $work_dates = explode(',', $_POST['work_date']);
    $postData['company_id'] = $_POST["company_id"];
    $resume_basic=get_resume_basic($_SESSION['uid'],$postData['resume_id']);
    $resume_basic = array_map("addslashes", $resume_basic);

    if (empty($resume_basic)) {
        exit("简历丢失");
    }
    if($_SESSION['utype']!=2){
        exit("请登录后申请职位");
    } elseif($row){
        exit("已报名！");
    } else{
        $sexx=$db->getone("select * from ".table('resume')." where id=".$resumeid);
        if(empty($sexx['sex_cn']) || empty($sexx['fullname'])){
            echo '<script type="text/javascript">
                    alert("请先完善简历信息！");

                    window.location.href="personal/user.php?act=resume_basic&pid='.$resumeid.'";
            </script>';

        }else{

                if ($resume_basic['display_name']=="2") {
                    $personal_fullname="N".str_pad($resume_basic['id'],7,"0",STR_PAD_LEFT);
                } elseif($resume_basic['display_name']=="3") {
                    if($resume_basic['sex']==1) {
                        $personal_fullname=cut_str($resume_basic['fullname'],1,0,"先生");
                    } elseif($resume_basic['sex']==2) {
                        $personal_fullname=cut_str($resume_basic['fullname'],1,0,"女士");

                    }
                } else {
                    $personal_fullname=$resume_basic['fullname'];
                }
                foreach($work_dates as $k => $v) {
                    $postData['date'] = strtotime($v);
                    $addRst = https_request_api('/enroll/add', $postData);
                    if(!$addRst['codes']){
                        $jobTmp = https_request_api("job/info/".$postData['job_id']);
                        $jobs=$jobTmp['data'];
                        $mailconfig=get_cache('mailconfig');	
                        $weixinconfig=get_cache('weixin_config');	
                        $sms=get_cache('sms_config');
                        $companyInfo = get_company_by_id($jobs['company_id']);
                        $jobs['uid'] = $companyInfo['uid'];
                        $comuser=get_user_info($_SESSION['uid']);
                        if ($mailconfig['set_applyjobs']=="1"  && $comuser['email_audit']=="1" && $jobs['push_email']=="100") {
                            dfopen($_CFG['site_domain'].$_CFG['site_dir']."plus/asyn_mail.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id={$jobs['id']}&jobs_name={$jobs['job_name']}&personal_fullname={$personal_fullname}&email={$comuser['email']}&resume_id={$resumeid}");
                        }
                        if ($sms['open']=="1"  && $sms['set_applyjobs']=="1"  && $comuser['mobile_audit']=="1") {
                            //修正bug,求职者申请职位不发送短信
                            dfopen($_CFG['site_domain'].$_CFG['site_dir']."plus/asyn_sms.php?uid={$_SESSION['uid']}&key=".asyn_userkey($_SESSION['uid'])."&act=jobs_apply&jobs_id=".$jobs['id']."&jobs_name=".$jobs['job_name'].'&jobs_uid='.$jobs['uid']."&personal_fullname=".$personal_fullname."&mobile=".$comuser['mobile']);

                        }
                        if($pms_notice=='1'){
                            $user=$db->getone("select username from ".table('members')." where uid ={$jobs['uid']} limit 1");
                            $user = array_map("addslashes", $user);
                            $jobs_url=url_rewrite('QS_jobsshow',array('id'=>$jobs['id']));
                            $resume_url=url_rewrite('QS_resumeshow',array('id'=>$resumeid));
                            $message=$personal_fullname."申请了您发布的职位：<a href=\"{$jobs_url}\" target=\"_blank\">{$jobs['jobs_name']}</a>,<a href=\"{$resume_url}\" target=\"_blank\">点击查看</a>";
                            write_pmsnotice($jobs['uid'],$user['username'],$message);
                        }
                        // 查看操作记录表 统计创建简历积分所奖励积分  判断是否超过上限   若没超过上限 则继续添加积分
                        $today=mktime(0, 0, 0,date('m'), date('d'), date('Y'));
                        $info=$db->getone("SELECT sum(points) as num FROM ".table('members_handsel')." WHERE uid ='{$_SESSION['uid']}' AND htype='resumeapplyjobs' AND addtime>{$today} ");
                        if(intval($info['num']) >= intval($_CFG['apply_jobs_points_max'])) {
                                write_memberslog($_SESSION['uid'],2,1301,$_SESSION['username'],"投递了简历，职位:{$jobs['jobs_name']}");
                        } else {
                            $points_rule=get_cache('points_rule');
                            $user_points=get_user_points($_SESSION['uid']);
                            if ($points_rule['apply_jobs']['value']>0) {
                                    $time=time();
                                    $members_handsel_arr['uid']=$_SESSION['uid'];
                                    $members_handsel_arr['htype']="resumeapplyjobs";
                                    $members_handsel_arr['points']=$points_rule['apply_jobs']['value'];
                                    $members_handsel_arr['addtime']=$time;
                                    $db->inserttable(table("members_handsel"),$members_handsel_arr);
                                    report_deal($_SESSION['uid'],$points_rule['apply_jobs']['type'],$points_rule['apply_jobs']['value']);
                                    $user_points=get_user_points($_SESSION['uid']);
                                    $operator=$points_rule['apply_jobs']['type']=="1"?"+":"-";
                                    write_memberslog($_SESSION['uid'],2,9001,$_SESSION['username'],"投递了简历，职位:{$jobs['jobs_name']}，({$operator}{$points_rule['apply_jobs']['value']})，(剩余:{$user_points})",2,1301,"申请职位","{$operator}{$points_rule['apply_jobs']['value']}","{$user_points}");
                            } else {
                                write_memberslog($_SESSION['uid'],2,1301,$_SESSION['username'],"投递了简历，职位:{$jobs['jobs_name']}");
                                }
                        }
                    if(intval($_CFG['weixin_apiopen'])==1 && $weixinconfig['set_applyjobs']=='1'){
                        $user=$db->getone("select weixin_openid from ".table('members')." where uid = {$jobs['uid']} limit 1");
                        if($user['weixin_openid']!=""){
                            $resume_url=$_CFG['wap_domain']."/resume-show.php?id=".$resumeid;
                            $template = array(
                                'touser' => $user['weixin_openid'],
                                'template_id' => "u_yoFifHb-ryYXMtNSlATj_Wfm1CWTKEjf8EkiM6dvY",
                                'url' => $resume_url,
                                'topcolor' => "#7B68EE",
                                'data' => array(
                                    'first' => array(
                                        'value' => urlencode(gbk_to_utf8("你收到了一份新简历，请及时登录".$_CFG['site_name']."查阅")),
                                        'color' => "#743A3A",
                                    ),
                                    'job' => array(
                                        'value' => urlencode(gbk_to_utf8($jobs['jobs_name'])),
                                        'color' => "#743A3A",
                                    ),
                                    'resuname' => array(
                                        'value' => urlencode(gbk_to_utf8("--")),
                                        'color' => "#743A3A",
                                    ),
                                    'realname' => array(
                                        'value' => urlencode(gbk_to_utf8($personal_fullname)),
                                        'color' => "#743A3A",
                                    ),
                                    'exp' => array(
                                        'value' => urlencode(gbk_to_utf8($resume_basic['experience_cn'])),
                                        'color' => "#743A3A",
                                    ),
                                    'lastjob' => array(
                                        'value' => urlencode(gbk_to_utf8("--")),
                                        'color' => "#743A3A",
                                    ),
                                    'remark' => array(
                                        'value' => urlencode("\\n".$notes),
                                        'color' => "#743A3A",
                                    )
                                )
                        );
                        send_template_message(urldecode(json_encode($template)));
                    }
                }
            }
        }
        exit('ok');
    }
    }
} elseif ($act == 'apply_del')
{
    $yid =!empty($_POST['id'])?$_POST['id']:exit("请选择删除项目！");
    $n=del_jobs_apply($yid,$_SESSION['uid']);
	if(intval($n) > 0)

	{

		exit("ok");

	}

	else

	{

		exit("err");

	}

}

?>