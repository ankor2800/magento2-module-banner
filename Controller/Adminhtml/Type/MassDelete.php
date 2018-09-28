<?php
namespace IdealCode\Banner\Controller\Adminhtml\Type;

class MassDelete extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\Data\Collection\AbstractDb $collection */
        $collection = parent::getFilterCollection();

        $resource = $this->getResource();

        $size = $collection->getSize();

        /** @var \IdealCode\Banner\Model\Type $type */
        foreach ($collection as $type) {
            $resource->delete($type);
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 type(s) have been delete.', $size)
        );

        return $this->_redirect('*/*/');
    }
}
