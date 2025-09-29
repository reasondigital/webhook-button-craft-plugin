<?php
namespace reasondigital\webhookbutton\models;

use craft\base\Model;

class Settings extends Model
{
    public ?string $webhookUrl = null; // 👈 make nullable so validation passes initially

    public function rules(): array
    {
        return [
            [['webhookUrl'], 'required'],
            [['webhookUrl'], 'url'],
        ];
    }
}