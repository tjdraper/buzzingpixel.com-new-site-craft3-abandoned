<?php

namespace modules\store\commands;

use modules\store\Store;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * Class RunScheduleCommand
 */
class SyncStripeProductsCommand extends Controller
{
    public function actionIndex()
    {
        Console::output(Console::wrapText(Console::renderColoredString(
            '%YSyncing products with Stripe...%n'
        )));

        Store::syncStripeProductsService()();

        Console::output(Console::wrapText(Console::renderColoredString(
            '%GProducts successfully synced with Stripe%n'
        )));
    }
}
