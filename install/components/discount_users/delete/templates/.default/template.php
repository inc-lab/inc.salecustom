<?
if(!$arResult['error']){
    echo json_encode($arResult);
}
else{
    header("HTTP/1.1 404 Not Found");
    echo json_encode($arResult);
}
