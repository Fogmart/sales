<?php

class ModelPriceTable {
    public static function setCode($code){
        return update_option('mp_table_code', $code);
    }
    public static function getCode(){
        return stripslashes(get_option('mp_table_code'));
    }
}