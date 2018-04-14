<?php

namespace App\Providers;

use App\Events\MessageUploaded;
use App\Message;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションサービスの初期化処理
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

    }

    /**
     * アプリケーションサービスの登録
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
