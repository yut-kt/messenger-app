<?php

namespace App\Providers;

use App\Events\MessageUploaded;
use App\Message;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションのイベントリスナーのマップ
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * アプリケーションのイベント登録
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // メッセージが書き込まれたときに発火
        Message::saved(function ($message) {
            \Event::fire(new MessageUploaded($message));
        });
    }
}
