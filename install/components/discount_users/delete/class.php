<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;
use Inc\Salecustom\SalecustomTable;

class deleteClass extends CBitrixComponent{
    protected function checkModules(){
        if(!Main\Loader::includeModule('inc.salecustom')){
            throw new Main\LoaderException('Модуль inc.salecustom не установлен');
        }
    }

    public function onPrepareComponentParams($arParams = []): array
    {
        if (isset($arParams['ID'])) {
            $arParams['ID']=(int)$arParams['ID'];
        }
        return $arParams;
    }
    public function delete(){
        if(isset($this->arParams['ID'])){
            $result = SalecustomTable::delete($this->arParams['ID']);
			CSaleDiscount::Delete($this->arParams['ID_SALE']);
        }
        else{
            $result=false;
        }
        return $result;
    }
    public function executeComponent(){
        $this->includeComponentLang('lang.php');
        $this->checkModules();
        $result = $this->delete();
        if($result){
        if($result->isSuccess()){
            $this->arResult=array('status'=>true,'text'=>'Элемент удален','error'=>false);
        }
        else{
            $error = $result->getErrorMessages();
            $this->arResult=array('status'=>'system-error','text'=>$error,'error'=>true);
        }
        }else{
            $this->arResult=array('status'=>'warning-error','text'=>'не задан параметр ID','error'=>true);
        }
        $this->IncludeComponentTemplate();
    }
}