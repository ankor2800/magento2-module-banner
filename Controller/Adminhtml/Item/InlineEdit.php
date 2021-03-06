<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

class InlineEdit extends Action
{
    public function execute()
    {
        $postItems = $this->getRequest()->getParam('items', []);

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

        $resource = $this->getResource();

        foreach ($postItems as $id => $post) {
            /** @var \IdealCode\Banner\Model\Item $item */
            $item = $this->getModel();

            $resource->load($item, $id);

            foreach ($post as $key => $value) {
                $item->setData($key, $value);
            }

            $resource->save($item);
        }

        return $resultJson->setData([
            'message' => __('A total of %1 item(s) have been saved.', count($postItems)),
            'error' => false
        ]);
    }
}
