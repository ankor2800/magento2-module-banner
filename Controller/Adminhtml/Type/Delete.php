<?php
namespace IdealCode\Banner\Controller\Adminhtml\Type;

class Delete extends Action
{
    public function execute()
    {
        $resource = $this->getResource();

        $idFieldName = $resource->getIdFieldName();

        $id = $this->getRequest()->getParam($idFieldName);

        if ($id) {
            try {
                /** @var \IdealCode\Banner\Model\Type $type */
                $type = $this->getModel();

                $resource->load($type, $id)->delete($type);

                $this->messageManager->addSuccessMessage(__('You deleted the type.'));
                return $this->_redirect('*/*/');
            }
            catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->_redirect('*/*/edit', [$idFieldName => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a type to delete.'));
        return $this->_redirect('*/*/');
    }
}
