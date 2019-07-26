<?php


namespace Hiicup\Layui\Html;


use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\ServiceProvider;

class LayuiHtmlBuilderServiceProvider extends ServiceProvider {



    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){
        $this->app->register(HtmlServiceProvider::class);
        $this->app->singleton("layui",function($app){
            return new LayuiHtmlBuilder();
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        view()->share("html",app('html'));
        view()->share("form",app('form'));
        view()->share("layui",app('layui'));
        $this->loadViewsFrom(dirname(__DIR__).DIRECTORY_SEPARATOR."resources/views","layui");

        $this->publishes([
            dirname(__DIR__).DIRECTORY_SEPARATOR."resources".DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."layui-form" =>public_path("layui-form"),
        ]);

    }

}