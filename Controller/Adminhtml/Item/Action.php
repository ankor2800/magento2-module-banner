<?php
namespace IdealCode\Banner\Controller\Adminhtml\Item;

abstract class Action extends \IdealCode\Banner\Controller\Adminhtml\Action
{
    /**
     * @return \Magento\Catalog\Model\ImageUploader
     */
    protected function getImageUploader()
    {
        return $this->_object->getData('imageUploader');
    }

    /**
     * @return \Magento\Framework\Filesystem\Directory\ReadInterface
     */
    protected function getMediaDirectory()
    {
        return $this->_object->getData('filesystem')->getDirectoryRead(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
        );
    }
}
