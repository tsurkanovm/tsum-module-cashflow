<?php

namespace Tsum\CashFlow\UI\DataProvider\Modifier\Product\Form;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Tsum\CashFlow\Helper\CfStorageHelper;

class StorageAttributes extends AbstractModifier
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var CfStorageHelper
     */
    private $storageHelper;

    /**
     * StorageAttributes constructor.
     * @param ArrayManager $arrayManager
     * @param CfStorageHelper $storageHelper
     */
    public function __construct(ArrayManager $arrayManager, CfStorageHelper $storageHelper)
    {
        $this->arrayManager = $arrayManager;
        $this->storageHelper = $storageHelper;
    }

    public function modifyMeta(array $meta)
    {
        if ($this->storageHelper->isStorage()) {
            $qtyPath = $this->arrayManager->findPath('qty', $meta, null, 'children');
            $qtyLinkPath = $this->arrayManager->findPath('advanced_inventory_button', $meta, null, 'children');
            $meta = $this->arrayManager->set(
                "{$qtyPath}/arguments/data/config/visible",
                $meta,
                0
            );
            $meta = $this->arrayManager->set(
                "{$qtyLinkPath}/arguments/data/config/visible",
                $meta,
                0
            );
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }
}