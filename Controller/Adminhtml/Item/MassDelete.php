<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class MassDelete extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\Data\Collection\AbstractDb $collection */
        $collection = parent::getFilterCollection();
        $resource = $this->getResource();

        $size = $collection->getSize();

        /** @var \IdealCode\Banner\Model\Item $item */
        foreach ($collection as $item) {
            $resource->delete($item);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 item(s) have been delete.', $size)
        );

        return $this->_redirect('*/*/');
    }
}
