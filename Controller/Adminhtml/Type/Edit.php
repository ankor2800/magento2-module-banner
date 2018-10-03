<?php
namespace IdealCode\Banner\Controller\Adminhtml\Type;

class Edit extends Action
{
    public function execute()
    {
        $resource = $this->getResource();

        $id = $this->getRequest()->getParam($resource->getIdFieldName());

        /** @var \IdealCode\Banner\Model\Type $type */
        $type = $this->getModel();

        if ($id) {
            $resource->load($type, $id);

            if (!$type->getId()) {
                $this->messageManager->addErrorMessage(__('This type no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        return $this->initPage($type->getId() ? 'Edit Type' : 'New Type', 'IdealCode_Banner::type');
    }
}
