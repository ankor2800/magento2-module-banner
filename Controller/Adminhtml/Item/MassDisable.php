<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class MassDisable extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\Data\Collection\AbstractDb $collection */
        $collection = parent::getFilterCollection();
        $resource = $this->getResource();

        /** @var \IdealCode\Banner\Model\Item $item */
        foreach ($collection as $item) {
            $item->setActive(\IdealCode\Banner\Model\Item\Active::STATUS_DISABLED);
            $resource->save($item);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 item(s) have been disabled.', $collection->getSize())
        );

        return $this->_redirect('*/*/');
    }
}
