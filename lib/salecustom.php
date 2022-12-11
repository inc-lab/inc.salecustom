<?php

namespace Inc\Salecustom;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;
Loc::loadMessages(__FILE__);

class SalecustomTable extends DataManager
{
    // название таблицы
    public static function getTableName()
    {
        return 'salecustom';
    }
    // создаем поля таблицы
    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'autocomplete' => true,
                'primary' => true
            )),
            new StringField('PROCENT', array(
                'required' => false,
                'title' => Loc::getMessage('MYMODULE_PROCENT'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_PROCENT_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }              
            )),
            new StringField('COUPON', array(
                'required' => false,
                'title' => Loc::getMessage('MYMODULE_COUPON'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_COUPON_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }              
            )),
            new StringField('USER', array(
                'required' => false,
                'title' => Loc::getMessage('MYMODULE_USER'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_USER_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }              
            )),
            new StringField('TIME', array(
                'required' => false,
                'title' => Loc::getMessage('MYMODULE_TIME'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_TIME_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }              
            )),
            new StringField('ID_SALE', array(
                'required' => false,
                'title' => Loc::getMessage('MYMODULE_ID_SALE'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_ID_SALE_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }              
            )),
            //обязательная строка с default значением  и длиной не более 255 символов
            new DatetimeField('UPDATED_AT',array(
                'required' => true)),//обязательное поле даты
            new DatetimeField('CREATED_AT',array(
                'required' => true)),//обязательное поле даты
        );
    }
}