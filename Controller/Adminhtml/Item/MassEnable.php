<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class MassEnable extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\Data\Collection\AbstractDb $collection */
        $collection = parent::getFilterCollection();
        $resource = $this->getResource();

        /** @var \IdealCode\Banner\Model\Item $item */
        foreach ($collection as $item) {
            $item->setActive(\IdealCode\Banner\Model\Item\Active::STATUS_ENABLED);
            $resource->save($item);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 item(s) have been enabled.', $collection->getSize())
        );

        return $this->_redirect('*/*/');
    }
}
