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

        self::getInstance()->setSettings($default);
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
        if (!$out) {
            $out = self::getSystemCurrencyInfo();
            self::setSystemCurrency($out);
        }

        return $out;
    }

    static public function getSystemCurrencyInfo()
    {
        $all = get_woocommerce_currencies();
        $system_curr_code = self::getSystemCurrency();
        $rez = [];

        foreach ($all as $key => $value) {
            if ($key == $system_curr_code) {
                $rez['name'] = $value;
                $rez['code'] = $key;
                $rez['symbol'] = get_woocommerce_currency_symbol($key);
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

    private static function fillTemplateItem($currency_obj, $template)
    {
        $item = $template;

        $item = str_replace('@name', $currency_obj['name'], $item);
        $item = str_replace('@code', $currency_obj['code'], $item);
        $item = str_replace('@symbol', $currency_obj['symbol'], $item);

        return $item;
    }

    static public function renderWidget($atts)
    {
        $out = self::getMainTemplate();
        $oneTemplate = self::getOneTemplate();
        $activeTemplate = self::getActiveTemplate();

        $items = '';

        //fill active elem
        $system_currency = self::getSystemCurrencyInfo();
        $active = self::fillTemplateItem($system_currency, $activeTemplate);

        //remove active elem from all 
        $currencies = self::getCurrencies();
        $currencies = array_filter($currencies, function ($item) use ($system_currency) {
            return $item['name'] !== $system_currency['name'];
        });

        //display all without active
        foreach ($currencies as $currency) {
            $items .= self::fillTemplateItem($currency, $oneTemplate);
        }
        $out = str_replace('@active', $active, $out);
        $out = str_replace('@all', $items, $out);

        //adding extra classes
        if ($atts['classes']) {
            $class_pos = strpos($out, 'class');
            $class_content_start = strpos($out, '"', $class_pos);
            $class_content_end = strpos($out, '"', $class_content_start + 1);

            $out = substr_replace($out, ' ' . $atts['classes'], $class_content_end, 0);
        }

        return $out;
    }
}