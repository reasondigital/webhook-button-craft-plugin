<?php
namespace reasondigital\webhookbutton;

use Craft;
use craft\base\Plugin;
use craft\base\Model;
use craft\web\UrlManager;
use yii\base\Event;
use reasondigital\webhookbutton\models\Settings;

class WebhookButton extends Plugin
{
    public bool $hasCpSection = true;
    public bool $hasCpSettings = true;

    public function init(): void
    {
        parent::init();

        // Register CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function($event) {
                $event->rules['webhookbutton'] = 'webhookbutton/default/index';
                $event->rules['webhookbutton/fire'] = 'webhookbutton/default/fire';
            }
        );
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate(
            'webhookbutton/settings',
            ['settings' => $this->getSettings()]
        );
    }
}
