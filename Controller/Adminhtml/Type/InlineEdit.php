<?php
namespace IdealCode\Banner\Controller\Adminhtml\Type;

class InlineEdit extends Action
{
    public function execute()
    {
        $postItems = $this->getRequest()->getParam('items', []);

        $resource = $this->getResource();

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(
            \Magento\Framework\Controller\ResultFactory::TYPE_JSON
        );

        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach ($postItems as $id => $post) {
            /** @var \IdealCode\Banner\Model\Type $type */
            $type = $this->getModel();

            $resource->load($type, $id);

            foreach ($post as $key => $value) {
                $type->setData($key, $value);
            }

            $resource->save($type);
        }

        return $resultJson->setData([
            'message' => __('A total of %1 type(s) have been saved.', count($postItems)),
            'error' => false
        ]);
    }
}
