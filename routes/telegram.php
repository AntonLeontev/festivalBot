<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use App\TelegramBotCommands\StartCommand;
use App\TelegramBotCommands\AddDishConversation;
use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', StartCommand::class)->description('The start command!');
$bot->onCommand('addDish', AddDishConversation::class)->description('Добавить блюдо в меню');

$bot->fallback(function (Nutgram $bot) {
    $bot->sendMessage('Хз че с этим делать...');
});

$bot->onException(function (Nutgram $bot, \Throwable $e) {
    $bot->sendMessage(
        sprintf("%s\n%s\nLine %s", $e->getMessage(), $e->getFile(), $e->getLine()),
        ['chat_id' => env('TELEGRAM_CHAT_ID')]
    );
    // $bot->sendMessage(
    //     $e->getTraceAsString(),
    //     ['chat_id' => env('TELEGRAM_CHAT_ID')]
    // );
});

$bot->registerMyCommands();
