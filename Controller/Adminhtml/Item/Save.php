<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class Save extends Action
{
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $idFieldName = $this->_itemResource->getIdFieldName();

        if ($data) {
            $id = $this->getRequest()->getParam($idFieldName);

            if (empty($data[$idFieldName]))
            {
                $data[$idFieldName] = null;
            }

            /** @var \IdealCode\Banner\Model\Item $item */
            $item = $this->_itemFactory->create();

            $this->_itemResource->load($item, $id);

            if (!$item->getId() && $id)
            {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                return $this->_redirect('*/*/');
            }

            // Image save
            if ($this->getRequest()->getParam('img')) {
                try {
                    $data['img'] = $this->_imageUploader->moveFileFromTmp($data['img'][0]['name']);
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addErrorMessage($e->getMessage());
                    }
                }
            }

            $item->setData($data);

            try {
                $this->_itemResource->save($item);
                $this->messageManager->addSuccessMessage(__('The item has been saved.'));

                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', [$idFieldName => $item->getId()]);
                }

                return $this->_redirect('*/*/');

            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
                return $this->_redirect('*/*/edit', [$idFieldName => $id]);
            }
        }

        return $this->_redirect('*/*/');
    }
}
