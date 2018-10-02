<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class Edit extends Action
{
    public function execute()
    {
        $resource = $this->getResource();

        $id = $this->getRequest()->getParam($resource->getIdFieldName());

        /** @var \IdealCode\Banner\Model\Item $item */
        $item = $this->getModel();

        if ($id) {
            $resource->load($item, $id);

            if (!$item->getId()) {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        return $this->initPage($item->getId() ? 'Edit Item' : 'New Item', 'IdealCode_Banner::item');
    }
}
