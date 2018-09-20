<?php
namespace IdealCode\Banner\Model\ResourceModel\Item;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init(
            \IdealCode\Banner\Model\Item::class,
            \IdealCode\Banner\Model\ResourceModel\Item::class
        );
    }
}
