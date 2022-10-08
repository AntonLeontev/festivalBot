<?php

namespace App\TelegramBotCommands;

use App\Models\Dish;
use SergiX44\Nutgram\Nutgram;

class ShowMenuCommand
{
	public function __invoke(Nutgram $bot)
	{
		$dishes = Dish::all();
		$text = '';
		foreach ($dishes as $dish) {
			$text .= sprintf('%s. %s - %sр' . PHP_EOL, $dish->id, $dish->name, $dish->price);
		}
		$bot->sendMessage($text);
	}
}
