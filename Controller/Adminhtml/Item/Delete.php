<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class Delete extends Action
{
    public function execute()
    {
        $resource = $this->getResource();

        $idFieldName = $resource->getIdFieldName();

        $id = $this->getRequest()->getParam($idFieldName);

        if ($id) {
            try {
                /** @var \IdealCode\Banner\Model\Item $item */
                $item = $this->getModel();

                $resource->load($item, $id)->delete($item);

                $this->messageManager->addSuccessMessage(__('You deleted the item.'));
                return $this->_redirect('*/*/');
            }
            catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->_redirect('*/*/edit', [$idFieldName => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a item to delete.'));
        return $this->_redirect('*/*/');
    }
}
