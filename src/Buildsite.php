<?php
namespace reasondigital\buildsite;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\web\UrlManager;
use yii\base\Event;
use reasondigital\buildsite\models\Settings;

class Buildsite extends Plugin
{
	public bool $hasCpSection = true;
	public bool $hasCpSettings = true;

	public function init(): void
	{
		parent::init();

		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_CP_URL_RULES,
			function($event) {
				$event->rules['buildsite'] = 'buildsite/default/index';
				$event->rules['buildsite/fire'] = 'buildsite/default/fire';
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
			'buildsite/settings',
			['settings' => $this->getSettings()]
		);
	}

	public function getCpNavItem(): ?array
	{
		$item = parent::getCpNavItem();
		if (!$item) {
			return null;
		}
		$item['label'] = Craft::t('buildsite', 'Build Site');
		return $item;
	}
}
