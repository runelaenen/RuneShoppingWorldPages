<?php

namespace RuneShoppingWorldPages\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use RuneShoppingWorldPages\RuneShoppingWorldPages;
use Shopware\Components\Emotion\DeviceConfiguration;
use Shopware_Controllers_Frontend_Custom;

/**
 * Class ShopPageSubscriber
 * @package RuneShoppingWorldPages\Subscriber
 */
class ShopPageSubscriber implements SubscriberInterface
{
    /**
     * @var DeviceConfiguration
     */
    private $emotionDeviceConfiguration;

    /**
     * @var string
     */
    private $pluginDir;

    /**
     * ShopPageSubscriber constructor.
     * @param DeviceConfiguration $emotionDeviceConfiguration
     * @param string $pluginDir
     */
    public function __construct(
        DeviceConfiguration $emotionDeviceConfiguration,
        string $pluginDir
    ) {
        $this->emotionDeviceConfiguration = $emotionDeviceConfiguration;
        $this->pluginDir = $pluginDir;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Custom' => 'PostDispatchFrontendCustom'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function PostDispatchFrontendCustom(Enlight_Event_EventArgs $args)
    {
        /** @var Shopware_Controllers_Frontend_Custom $subject */
        $subject = $args->getSubject();

        $subject->View()->addTemplateDir(
            $this->pluginDir . '/Resources/views'
        );

        $cmsPage = $subject->View()->getAssign('sCustomPage');

        if (isset($cmsPage['attribute'][RuneShoppingWorldPages::PAGE_ATTRIBUTE])) {
            $shoppingWorldId = $cmsPage['attribute'][RuneShoppingWorldPages::PAGE_ATTRIBUTE];
            $shoppingWorld = $this->emotionDeviceConfiguration->getById($shoppingWorldId);

            $subject->View()->assign([
                'shoppingWorld' => $shoppingWorld,
                'hasShoppingWorld' => true,
            ]);
        }
    }
}
