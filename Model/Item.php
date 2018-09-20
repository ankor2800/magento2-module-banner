<?php
namespace IdealCode\Banner\Model;

class Item extends \Magento\Framework\Model\AbstractModel
{
    const BASE_MEDIA_PATH = 'banner/images/';
    const BASE_TEMP_PATH = 'banner/temp/';
    const IMAGE_FIELD = 'img';

    protected function _construct()
    {
        $this->_init(ResourceModel\Item::class);
    }

    /**
     * Set Active flag
     *
     * @param int $active
     * @return Item
     */
    public function setActive($active)
    {
        return $this->setData(Item\Active::COLUMN, $active);
    }

    public function setImage($value)
    {
        return $this->setData(self::IMAGE_FIELD, $value);
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->getData('link');
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData('content');
    }

    /**
     * Get image url
     *
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImage()
    {
        $url = false;
        $image = $this->getData(self::IMAGE_FIELD);

        /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = $this->getData('storeManager');

        /** @var \Magento\Store\Model\Store $store */
        $store = $storeManager->getStore();

        if($image) {
            if(is_string($image)) {
                $url = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                    .self::BASE_MEDIA_PATH
                    .$image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}
