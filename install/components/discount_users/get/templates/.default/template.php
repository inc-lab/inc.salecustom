<div class="createcoupondiv">
	<form action="" method="get">
		<input type="submit" name="discount" class="create_coupon" value="Получить скидку">
	</form>
</div>
<div class="isdiscount">
	<form action="" method="get">
		<input type="text" name="coupon" class="isdinput" placeholder="Введите купон для проверки">
		<input type="submit" class="is_coupon" value="Проверить скидку">
	</form>
</div>
<?
if(!$arResult['error']){
if(isset($arResult['no_coupon'])){?>
	<p>Скидка недоступна</p>
<?}else if(isset($arResult[0]['COUPON'])){?>
	<p>Ваш купон:<?=$arResult[0]['COUPON'];?> - Ваша скидка: <?=$arResult[0]['PROCENT'];?>%</p>
<?}else{}}
else{
    header("HTTP/1.1 404 Not Found");
    echo json_encode($arResult);
}