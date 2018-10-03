<?php
namespace IdealCode\Banner\Controller\Adminhtml\Type;

class Save extends Action
{
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resource = $this->getResource();

        $idFieldName = $resource->getIdFieldName();

        if ($data) {
            $id = $this->getRequest()->getParam($idFieldName);

            if (empty($data[$idFieldName]))
            {
                $data[$idFieldName] = null;
            }

            /** @var \IdealCode\Banner\Model\Type $type */
            $type = $this->getModel();

            $resource->load($type, $id);

            if (!$type->getId() && $id)
            {
                $this->messageManager->addErrorMessage(__('This type no longer exists.'));
                return $this->_redirect('*/*/');
            }

            $type->setData($data);

            try {
                $resource->save($type);
                $this->messageManager->addSuccessMessage(__('The type has been saved.'));

                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', [$idFieldName => $type->getId()]);
                }

                return $this->_redirect('*/*/');

            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the type.'));
                return $this->_redirect('*/*/edit', [$idFieldName => $id]);
            }
        }

        return $this->_redirect('*/*/');
    }
}
