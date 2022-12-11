<?
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;
use Inc\Salecustom\SalecustomTable;
use Bitrix\Sale\Internals;
use Bitrix\Main\Loader;

class getClass extends CBitrixComponent{
    protected function checkModules(){
        if(!Loader::includeModule('inc.salecustom')){
            throw new Main\LoaderException('Модуль inc.salecustom не установлен');//Loc::getMessage('INC_SaleCustom_NOT_INSTALL')
        }
    }
    public function discountCastom($lid='s1',$name='Скидка для пользователя',$create){
        if (Loader::includeModule("catalog"))
        {
            if (Loader::includeModule("iblock")){ 
                $rand = mt_rand(1,50);
                $UserId = CUser::GetID();
                $arr = Array(
                    'LID' => $lid,
                    'NAME' => $name,
                    'ACTIVE_FROM' => '',
                    'ACTIVE_TO' => '',
                    'PRICE_FROM' => '',
                    'ACTIVE' => 'Y',
                    'PRIORITY' => 1,
                    'SORT' => 100,
                    'XML_ID'=>'',
                    "CONDITIONS" =>  array (
                      'CLASS_ID' => 'CondGroup',
                      'DATA' => 
                      array (
                        'All' => 'AND',
                        'True' => 'True',
                      ),
                      'CHILDREN' => 
                      array (
                        0 => 
                        array (
                          'CLASS_ID' => 'CondMainUserId',
                          'DATA' => 
                          array (
                            'logic' => 'Equal',
                            'value' => 
                            array (
                              0 => $create['USER'],
                            ),
                          ),
                        ),
                      ),
                    ),
                    'CURRENCY' => 'RUB',
                    'USER_GROUPS'=>CUser::GetUserGroup($create['USER']),
                    'ACTIONS' => array (
                        'CLASS_ID' => 'CondGroup',
                        'DATA' => 
                        array (
                            'All' => 'AND',
                        ),
                        'CHILDREN' => 
                        array (
                            0 => array (
                                'CLASS_ID' => 'ActSaleBsktGrp',
                                'DATA' => 
                                array (
                                    'Type' => 'Discount',
                                    'Value' => $create['PROCENT'],
                                    'Unit' => 'Perc',
                                    'Max' => 0,
                                    'All' => 'AND',
                                    'True' => 'True',
                                ),
                                'CHILDREN' => 
                                array (
                                ),
                            ),
                        ),
                    )
                );
                $ID = CSaleDiscount::Add($arr);    
                $res = $ID>0;
                if (!$res) { 
                    return ['error'=>true]; 
                }
                else{
                    $res = $ID>0;
                    if ($res) { 	
                        $codeCoupon = \CatalogGenerateCoupon(); //Генирация купона
                        $fields["DISCOUNT_ID"] = $ID;
                        $fields["COUPON"] = $codeCoupon;
                        $fields["ACTIVE"] = "Y";
                        $fields["TYPE"] = Internals\DiscountCouponTable::TYPE_MULTI_ORDER;
                        $fields["MAX_USE"] = 0;
                        $dd = Internals\DiscountCouponTable::add($fields); //Создаем купон для этого правила
                        if (!$dd->isSuccess())
                        {
                            $err = $dd->getErrorMessages();
                        }else{
                            return ['PROCENT'=>$create['PROCENT'],'COUPON'=>$codeCoupon,'USER'=>$create['USER'],'TIME'=>time(),'ID_SALE'=>$ID];
                        }
                    }else{ 
                        return ['error'=>true];
                    }
                } 
            }
        }
    }
    public function onPrepareComponentParams($arParams = []): array
    {
        if (isset($arParams['SID']) && isset($arParams['NAME'])) {
            $arParams['SID']=preg_replace('#([^0-9a-zA-Zа-яёА-ЯЁ]+)#','',$arParams['SID']);
            $arParams['NAME']=preg_replace('#([^0-9a-zA-Zа-яёА-ЯЁ ]+)#','',$arParams['NAME']);
        }
		if (isset($arParams['COUPON'])) {
			$arParams['COUPON']=preg_replace('#([^0-9a-zA-Zа-яёА-ЯЁ-]+)#','',$arParams['COUPON']);
		}
        return $arParams;
    }

    public function select($arParams=[]){
		if(isset($arParams['CREATE'])){
			$result = $this->discountCastom($arParams['LID'],$arParams['NAME'],$arParams['CREATE']);
			if(empty($result['error'])){
				$result['UPDATED_AT']=new Type\DateTime();
				$result['CREATED_AT']=new Type\DateTime();
				SalecustomTable::add($result);
			}
		}
		$result = SalecustomTable::getList()->fetchAll();
		return $result;
	}


    public function executeComponent(){
        $this->includeComponentLang('lang.php');
        $this->checkModules();
        $result = $this->select($this->arParams);
        $this->arResult=$result;
        $this->IncludeComponentTemplate();
    }
}