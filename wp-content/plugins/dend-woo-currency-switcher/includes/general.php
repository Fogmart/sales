<?php

class WCS_Settings
{
    public static $settings_slug;
    public static $system_currency_slug;

    private static $instance;

    private function __construct()
    {
        self::$settings_slug = 'wcs_settings';
        self::$system_currency_slug = 'wcs_currency';
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static public function install()
    {
        $default = [];
        $default['mainTemplate'] = '<select class="wcs-container">@loop</select>';
        $default['oneTemplate'] = '<option class="wcs-curr" data-curr=@code value=@code>@name</option>';
        $default['activeTemplate'] = '<option class="active" value="@code">@name</option>';

        self::setSettings($default);
    }

    static public function uninstall()
    {
        $empty = [];
        return self::setSettings($empty);
    }

    static public function setSystemCurrency($currency)
    {
        return update_option(self::$system_currency_slug, $currency);
    }

    static public function getSystemCurrency()
    {
        $out = get_option(self::$system_currency_slug);
        if(!$out){
            $out = get_option('woocommerce_currency');
            self::setSystemCurrency($out);
        }
        return $out;
    }

    static public function getSystemCurrencyInfo(){
        $all = get_woocommerce_currencies();
        $system_curr_code = self::getSystemCurrency();
        $rez = [];

        foreach($all as $key => $value){
            if($key == $system_curr_code){
                $rez['name'] = $value;
                $rez['code'] = $key;
            }
        }
        
        return $rez;
    }

    static public function getSettings($field = null)
    {
        $settings = get_option(self::$settings_slug);
        if ($field) {
            $settings = isset($settings[$field]) ? $settings[$field] : null;
        }
        return $settings;
    }
    static public function setSettings($data)
    {
        update_option(self::$settings_slug, $data);
    }

    public static function getMainTemplate()
    {
        return trim(stripcslashes(self::getSettings('mainTemplate')));
    }

    public static function getOneTemplate()
    {
        return trim(stripcslashes(self::getSettings('oneTemplate')));
    }

    public static function getActiveTemplate()
    {
        return trim(stripcslashes(self::getSettings('activeTemplate')));
    }

    public static function getCurrencies($field = null)
    {
        $out = self::getSettings('currencies') ?: array();
        if ($field && !empty($out)) {
            $out = array_column($out, $field);
        }
        return $out;
    }

    public static function isSelectedCurrency($currency_code)
    {
        $codes = self::getCurrencies('code') ?: array();
        return in_array($currency_code, $codes);
    }

    static public function renderWidget()
    {
        $out = self::getMainTemplate();
        $oneTemplate = self::getOneTemplate();
        $activeTemplate = self::getActiveTemplate();

        $items = '';

        //firstly display active elem
        $system_currency = self::getSystemCurrencyInfo();
        $activeTemplate = str_replace('@name', $system_currency['name'], $activeTemplate);
        $activeTemplate = str_replace('@code', $system_currency['code'], $activeTemplate);
        $items .= $activeTemplate;

        //remove active elem from all 
        $currencies = self::getCurrencies();
        $currencies = array_filter($currencies, function($item) use ($system_currency){
            return $item['name'] !== $system_currency['name'];
        });

        //display all without active
        foreach ($currencies as $currency) {

            $item = str_replace('@name', $currency['name'], $oneTemplate);
            $item = str_replace('@code', $currency['code'], $item);

            $items .= $item;
        }
        $out = str_replace('@loop', $items, $out);

        return $out;
    }
}