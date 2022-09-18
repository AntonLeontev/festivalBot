<?php

namespace App\TelegramBotCommands;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class StartCommand
{

	public function __invoke(Nutgram $bot)
	{
		User::firstOrCreate(
			['telegram_id' => $bot->userId()],
			['username' => $bot->user()->username, 'first_name' => $bot->user()->first_name]
		);
		$bot->sendMessage($bot->user()->first_name . ", вы зарегистрированы", ['chat_id' => $bot->chatId()]);
	}
}
