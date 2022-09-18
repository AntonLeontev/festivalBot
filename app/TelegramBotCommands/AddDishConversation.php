<?php

namespace App\TelegramBotCommands;

use App\Models\Dish;
use Illuminate\Support\Facades\Validator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Conversations\Conversation;

class AddDishConversation extends Conversation
{
	public function start(Nutgram $bot)
	{
		$bot->sendMessage('Введите название блюда');
		$this->next('handleDishName');
	}

	public function handleDishName(Nutgram $bot)
	{
		$validator = Validator::make(
			['text' => $bot->message()->getText()],
			['text' => ['required', 'between:2,20', 'unique:dishes,name']],
			[
				'between' => 'Значение должно быть длиной от :min до :max символов',
				'unique' => 'Такое название блюда уже есть. Придумайте другое',
			]
		);

		if ($validator->fails()) {
			$bot->sendMessage(implode("\n", $validator->errors()->all()));
			$bot->sendMessage('Введите название блюда');
			return;
		}

		$bot->setGlobalData('name', $bot->message()->getText());
		$bot->sendMessage('Введите цену блюда. Только цифры');
		$this->next('handleDishPrice');
	}

	public function handleDishPrice(Nutgram $bot)
	{
		$validator = Validator::make(
			['text' => $bot->message()->getText()],
			['text' => ['required', 'numeric', 'min:0']],
			[
				'numeric' => 'Вводить можно только цифры',
				'min' => 'Цена не может быть отрицательной',
			]
		);

		if ($validator->fails()) {
			$bot->sendMessage(implode("\n", $validator->errors()->all()));
			$bot->sendMessage('Введите цену блюда. Только цифры');
			return;
		}

		Dish::create(['name' => $bot->getGlobalData('name'), 'price' => $bot->message()->getText()]);
		$bot->sendMessage('Новое блюдо добавлено в меню');
		$this->end();
	}
}
