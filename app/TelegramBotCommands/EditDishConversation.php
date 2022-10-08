<?php

namespace App\TelegramBotCommands;

use App\Models\Dish;
use Illuminate\Support\Facades\Validator;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class EditDishConversation extends InlineMenu
{
	public function start(Nutgram $bot)
	{
		$bot->sendMessage('Введите номер блюда, которое нужно отредактировать');
		$this->next('findDish');
	}

	public function findDish(Nutgram $bot)
	{
		$validator = Validator::make(
			['text' => $bot->message()->getText()],
			['text' => ['exists:dishes,id']],
			['exists' => 'Должен быть существующий номер в меню']
		);

		if ($validator->fails()) {
			$bot->sendMessage(implode("\n", $validator->errors()->all()));
			$bot->sendMessage('Введите номер блюда, которое нужно отредактировать');
			return;
		}

		$dish = Dish::find($bot->message()->getText());
		$bot->setGlobalData('dish', $dish);
		$this->menuText("Редактируем {$dish->name}. Что изменить?")
			->addButtonRow(
				InlineKeyboardButton::make('Название', callback_data: 'name@handleChoise'),
				InlineKeyboardButton::make('Цена', callback_data: 'price@handleChoise'),
			)->orNext('none')->showMenu();
	}

	public function handleChoise(Nutgram $bot)
	{
		if ($bot->callbackQuery()->data === 'name') {
			$this->menuText('Введите новое название')
				->clearButtons()
				->orNext('saveDishName')
				->showMenu();
			return;
		}

		if ($bot->callbackQuery()->data === 'price') {
			$this->menuText('Введите новую цену')
				->clearButtons()
				->orNext('saveDishPrice')
				->showMenu();
			return;
		}
	}

	public function saveDishName(Nutgram $bot)
	{
		$dish = $bot->getGlobalData('dish');
		if (!isset($dish)) {
			throw new \Exception('Model dish is not saved');
		}

		$newName = $bot->message()->getText();
		$dish->update(['name' => $newName]);
		$bot->sendMessage("Сохранено {$dish->name}");
		$this->end();
	}

	public function saveDishPrice(Nutgram $bot)
	{
		$dish = $bot->getGlobalData('dish');
		if (!isset($dish)) {
			throw new \Exception('Model dish is not saved');
			$this->end();
		}

		$validator = Validator::make(
			['price' => $bot->message()->getText()],
			['price' => ['numeric']],
			['numeric' => 'Должно быть число']
		);

		if ($validator->fails()) {
			$bot->sendMessage(implode("\n", $validator->errors()->all()));
			$bot->sendMessage('Введите цену');
			return;
		}

		$newPrice = $bot->message()->getText();
		$dish->update(['price' => $newPrice]);
		$bot->sendMessage("Новая цена {$dish->price}");
		$this->end();
	}

	public function none(Nutgram $bot)
	{
		$bot->sendMessage('Изменение отменено');
	}
}
