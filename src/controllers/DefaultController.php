<?php
namespace reasondigital\buildsite\controllers;

use Craft;
use craft\web\Controller;
use reasondigital\buildsite\Buildsite;
use yii\web\Response;
use GuzzleHttp\Client;

class DefaultController extends Controller
{
	protected int|bool|array $allowAnonymous = false;

	public function actionIndex(): Response
	{
		return $this->renderTemplate('buildsite/index');
	}

	public function actionFire(): Response
	{
		$settings = Buildsite::getInstance()->getSettings();
		$webhookUrl = $settings->webhookUrl;

		if ($webhookUrl) {
			$client = new Client();
			try {
				$client->post($webhookUrl, [
					'json' => ['firedAt' => date('c')]
				]);
				Craft::$app->getSession()->setSuccess('Build triggered successfully!');
			} catch (\Exception $e) {
				Craft::$app->getSession()->setError('Build failed: ' . $e->getMessage());
			}
		} else {
			Craft::$app->getSession()->setError('Build hook URL is not configured.');
		}

		return $this->redirect('buildsite');
	}
}