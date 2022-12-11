<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php';


if(isset($_POST['create'])){
	unset($_POST['create']);
	$APPLICATION->IncludeComponent(
		"discount_users:get_admin","",array(
			'LID'=>'s1',
			'CREATE'=>$_POST,
			'NAME'=>'Скидка для пользователя'
		)
	);
}
else if(isset($_POST['delete'])){
	$APPLICATION->IncludeComponent(
            "discount_users:delete","",array('ID'=>(int)$_POST['ID'],'ID_SALE'=>(int)$_POST['ID_SALE']),false
        );
	$APPLICATION->IncludeComponent(
		"discount_users:get_admin","",array(
			'LID'=>'s1',
			'NAME'=>'TEST'
			)
	 );
}
else{
 $APPLICATION->IncludeComponent(
	"discount_users:get_admin","",array(
		'LID'=>'s1',
		'NAME'=>'TEST'
		)
 );
}
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php';
