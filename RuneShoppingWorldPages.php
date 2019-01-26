<?php

namespace RuneShoppingWorldPages;

use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Bundle\AttributeBundle\Service\TypeMapping;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Emotion\Emotion;

class RuneShoppingWorldPages extends Plugin
{
    /**
     * @param InstallContext $context
     * @throws \Exception
     */
    public function install(InstallContext $context)
    {
        /** @var CrudService $crudService */
        $crudService = $this->container->get('shopware_attribute.crud_service');
        $crudService->update('s_cms_static_attributes',
            'rune_shoppingworldpage',
            'single_selection',
            [
                'label' => 'Shopping World',
                'displayInBackend' => true,
                'translatable' => true,
                'helpText' => 'Will replace Shop Page content.',
                'columnType' => TypeMapping::TYPE_SINGLE_SELECTION, 'entity' => Emotion::class,
                'position' => 0,
                'custom' => 'false'
            ],
            null,
            true);

        parent::install($context);
    }

    /**
     * @param UninstallContext $context
     * @throws \Exception
     */
    public function uninstall(UninstallContext $context)
    {
        /** @var CrudService $crudService */
        $crudService = $this->container->get('shopware_attribute.crud_service');
        $crudService->delete("s_cms_static_attributes", "rune_shoppingworldpage");

        $context->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);

        return parent::uninstall($context);
    }
}
