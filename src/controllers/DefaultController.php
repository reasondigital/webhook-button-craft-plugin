<?php
namespace reasondigital\webhookbutton\controllers;

use Craft;
use craft\web\Controller;
use reasondigital\webhookbutton\WebhookButton;
use yii\web\Response;
use GuzzleHttp\Client;

class DefaultController extends Controller
{
    protected int|bool|array $allowAnonymous = false;

    public function actionIndex(): Response
    {
        return $this->renderTemplate('webhookbutton/index');
    }

    public function actionFire(): Response
    {
        $settings = WebhookButton::getInstance()->getSettings();
        $webhookUrl = $settings->webhookUrl;


        if ($webhookUrl) {
            $client = new Client();
            try {
                $client->post($webhookUrl, [
                    'json' => ['firedAt' => date('c')]
                ]);
                Craft::$app->getSession()->setSuccess('Webhook fired successfully!');
            } catch (\Exception $e) {
                Craft::$app->getSession()->setError('Webhook failed: ' . $e->getMessage());
            }
        } else {
            Craft::$app->getSession()->setError('Webhook URL is not configured.');
        }

        return $this->redirect('webhookbutton');
    }
}