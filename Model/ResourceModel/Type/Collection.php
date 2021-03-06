<?php
namespace IdealCode\Banner\Model\ResourceModel\Type;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    public function _construct()
    {
        $this->_init(
            \IdealCode\Banner\Model\Type::class,
            \IdealCode\Banner\Model\ResourceModel\Type::class
        );
    }
}
