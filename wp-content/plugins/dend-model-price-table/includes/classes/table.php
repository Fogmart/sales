<?php

class ModelPriceTable {
    private static $table_list;
    protected static $table_list_key = 'mp_tables';

    public static function setTableList($table_list){
        $table_list = json_encode($table_list);
        update_option(self::$table_list_key, $table_list);
    }

    public static function getTableList(){
        $table_list = get_option(self::$table_list_key);
        self::$table_list = json_decode($table_list);
        array_walk(self::$table_list, function($item){
            $item->name = urldecode($item->name);
        });
        return self::$table_list ?? array();
    }

    public static function setCode($name, $code){
        $table_key = self::existsOrAddTable($name);
        $rez = update_option($table_key, $code);
        return $rez;
    }
    public static function getCode($table_key = ''){
        $code = stripslashes(get_option($table_key));        
        return $code;
    }

    public static function getTableKey($name){
        $table_key = 'mp_table_code_'.$name;
        return $table_key;
    }

    public static function existsOrAddTable($name){
        $table_key = self::getTableKey($name);

        $table_list = self::getTableList();
        if(!in_array($table_key, array_column($table_list, 'key'))){
            $new_table = [
                'name' => $name,
                'key' => $table_key,
            ];
            $table_list[] = $new_table;
            self::setTableList($table_list);
        }

        return $table_key;
    }

    public static function deleteTable($name){
        $table_key = self::getTableKey($name);
        $table_list = self::getTableList();
        $rmIndex = false;

        foreach($table_list as $index => $one){
            if($one->key == $table_key){
                delete_option($table_key);
                $rmIndex = $index;
            }
        }
        if($rmIndex !== false){
            unset($table_list[$rmIndex]);
        }

        self::setTableList($table_list);
        return $table_key;
    }
}
