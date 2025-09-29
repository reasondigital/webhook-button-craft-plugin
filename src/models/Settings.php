<?php
namespace reasondigital\buildsite\models;

use craft\base\Model;

class Settings extends Model
{
	public ?string $webhookUrl = null;

	public function rules(): array
	{
		return [
			[['webhookUrl'], 'required'],
			[['webhookUrl'], 'url'],
		];
	}
}