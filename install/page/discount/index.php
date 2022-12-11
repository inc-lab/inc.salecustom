<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?><?php
if(isset($_GET['discount'])){
	$APPLICATION->IncludeComponent(
		"discount_users:get","",array(
			'LID'=>'s1',
			'CREATE'=>'yes',
			'NAME'=>'Скидка для пользователя'
		)
	);
}
else if(isset($_GET['coupon'])){
	$APPLICATION->IncludeComponent(
		"discount_users:get","",array(
			'LID'=>'s1',
			'COUPON'=>$_GET['coupon'],
			'NAME'=>'Скидка для пользователя'
		)
	);
}
else{
	$APPLICATION->IncludeComponent(
		"discount_users:get","",array(
			'LID'=>'s1',
			'NAME'=>'Скидка для пользователя'
		)
	);
}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>