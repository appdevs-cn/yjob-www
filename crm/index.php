<?php
if(!file_exists(dirname(__FILE__).'/data/install.lock')) header("Location:install/index.php");
else header("Location:crm_login.php"); 
?>