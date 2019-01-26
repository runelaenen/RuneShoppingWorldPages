<?php

namespace RuneShoppingWorldPages\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Enlight_Event_EventArgs;
use Shopware\Components\Emotion\DeviceConfiguration;
use Shopware_Controllers_Frontend_Custom;

class ShopPageSubscriber implements SubscriberInterface
{
    /**
     * @var DeviceConfiguration
     */
    private $emotionDeviceConfiguration;

    /**
     * ShopPageSubscriber constructor.
     */
    public function __construct()
    {
        $this->emotionDeviceConfiguration = Shopware()->Container()->get('emotion_device_configuration');
    }


    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Controllers_Frontend_Custom::indexAction::after' => 'AfterFrontendCustomIndexAction'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function AfterFrontendCustomIndexAction(Enlight_Event_EventArgs $args)
    {
        /** @var Shopware_Controllers_Frontend_Custom $subject */
        $subject = $args->getSubject();

        $cmsPage = $subject->View()->getAssign('sCustomPage');

        if(isset($cmsPage['attribute']['rune_shoppingworldpage'])) {
            $this->addResourcesToTemplateDir($subject);

            $shoppingWorldId = $cmsPage['attribute']['rune_shoppingworldpage'];
            $shoppingWorld = $this->emotionDeviceConfiguration->getById($shoppingWorldId);

            $subject->View()->assign([
                'shoppingWorld' => $shoppingWorld,
                'hasShoppingWorld' => true,
            ]);
        }
    }

    /**
     * @param Enlight_Controller_Action $subject
     */
    private function addResourcesToTemplateDir(Enlight_Controller_Action $subject)
    {
        $pluginPath = Shopware()->Container()->getParameter('rune_shopping_world_pages.plugin_dir');
        $subject->View()->addTemplateDir(
            $pluginPath . '/Resources/views'
        );
    }
}
