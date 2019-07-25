<?php


namespace Hiicup\Layui\Html;


use Illuminate\Support\Facades\Facade;

class LayuiFacade extends Facade {

    protected static function getFacadeAccessor() {
        return LayuiHtmlBuilder::class;
    }

}