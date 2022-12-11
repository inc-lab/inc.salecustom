<div class="createcoupondiv">
	<form action="" method="post">
		<input type="text" name="USER" class="isdinput" placeholder="id пользователя">
		<input type="text" name="PROCENT" class="isdinput" placeholder="Процент скидки" value="<?=mt_rand(1,50);?>">
		<input type="submit" name="create" value="Добавить запись">
	</form>
</div>
<?
if(!$arResult['error']){?>
<div class="isdiscount">
	<?foreach($arResult as $item){?>
	<form action="" method="post">
		<?foreach($item as $key=>$field){?>
			<input type="text" name="<?=$key;?>" class="isdinput" value="<?=$field;?>">
		<?}?>
		<input type="submit" name="delete" class="is_coupon" value="Удалить">
	</form>
	<?}?>
</div>
<?
}
else{
    header("HTTP/1.1 404 Not Found");
    echo json_encode($arResult);
}
?>

