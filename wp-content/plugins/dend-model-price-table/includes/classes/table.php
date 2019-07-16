<?php

class ModelPriceTable {
    private static $table_list;
    private static $table_list_key = 'mp_tables';

    public static function setTable_list($table_list){
        $table_list = json_encode($table_list);
        update_option(self::$table_list_key, $table_list);
    }

    public static function getTable_list(){
        $table_list = get_option(self::$table_list_key);
        return json_decode($table_list);
    }

    public static function setCode($name, $code){
        existsOrAddTable($name);
        
    }
    public static function getCode($name = ''){
        $table_key = self::getTableKey($name);
        $code = stripslashes(get_option($table_key));
        return $code;
    }

    public static function getTableKey($name){
        $table_key = 'mp_table_code_'.$name;
        return $table_key;
    }

    public static function existsOrAddTable($name){
        $table_key = self::getTableKey($name);

        $table_list = self::$table_list;
        if(!in_array($table_key, array_column($table_list, 'key'))){
            $new_table = [
                'name' => $name,
                'key' => $table_key,
            ];
            $table_list[] = $new_table;
        }
        self::$table_list = $table_list;

        return $table_key;
    }

    public static function deleteTable($name){
        $table_key = self::getTableKey($name);

        $table_list = self::$table_list;
        if(!in_array($table_key, $table_list)){
            array_push($table_list, $table_key);
        }
        self::$table_list = $table_list;

        return $table_key;
    }
}