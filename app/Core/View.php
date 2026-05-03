<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    private \Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new \Smarty();
        $this->smarty->setTemplateDir(Config::get('smarty.template_dir'));
        $this->smarty->setCompileDir(Config::get('smarty.compile_dir'));
        $this->smarty->setCacheDir(Config::get('smarty.cache_dir'));
        $this->smarty->caching = Config::get('smarty.caching', false);

        $this->smarty->assign('appName', Config::get('app.name'));
        $this->smarty->assign('appUrl', Config::get('app.url'));
        $this->smarty->assign('currentYear', date('Y'));

        $this->smarty->registerPlugin('modifier', 'format_date', static function (string $date, string $format = 'd.m.Y'): string {
            $ts = strtotime($date);
            return $ts !== false ? date($format, $ts) : $date;
        });
    }

    public function assign(string $key, mixed $value): void
    {
        $this->smarty->assign($key, $value);
    }

    public function render(string $template): void
    {
        $this->smarty->display($template . '.tpl');
    }
}
