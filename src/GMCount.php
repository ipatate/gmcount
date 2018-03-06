<?php
/**
 * GMCount plugin for Craft CMS 3.x
 *
 * @link      www.goodmotion.fr
 * @copyright Copyright (c) 2018 Faramaz Pat
 */

namespace goodmotion\gmcount;

use goodmotion\gmcount\services\GMCountService;
use goodmotion\gmcount\elements\GMCountElement;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 *
 * @author    Faramaz Pat
 * @package   GMCount
 * @since     1.0.0
 *
 * @property  GMCountService $gmcount
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class GMCount extends Plugin
{

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * GMCount::$plugin
     *
     * @var $plugin
     */
    public static $plugin;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'gmcount', GMCountService::class
        ]);


        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function (Event $event) {
            /** @var CraftVariable $variable */
            $variable = $event->sender;
            $variable->set('gmcount', GMCountService::class);
        });


        Craft::info(
            Craft::t(
                'gmcount',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

        return true;
    }
}
