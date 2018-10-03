<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

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

            /** @var \IdealCode\Banner\Model\Item $item */
            $item = $this->getModel();

            $resource->load($item, $id);

            if (!$item->getId() && $id)
            {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                return $this->_redirect('*/*/');
            }

            $item->setData($data);

            // Image save
            if ($this->getRequest()->getParam($item::IMAGE_FIELD)) {

                $item->setImage($data['img'][0]['name']);

                try {
                    $image = $this->getImageUploader();

                    if (!$this->getMediaDirectory()->isExist(
                        $image->getFilePath($image->getBasePath(), $item->getData($item::IMAGE_FIELD))
                    )) {
                        $item->setImage(
                            $this->getImageUploader()->moveFileFromTmp(
                                $item->getData($item::IMAGE_FIELD)
                            )
                        );
                    }
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addErrorMessage($e->getMessage());
                    }
                }
            } else {
                // Delete image
                $item->setImage(false);
            }

            try {
                $resource->save($item);
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
