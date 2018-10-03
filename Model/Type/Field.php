<?php
namespace IdealCode\Banner\Model\Type;

class Field implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \IdealCode\Banner\Model\ResourceModel\Type\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param \IdealCode\Banner\Model\ResourceModel\Type\CollectionFactory $collectionFactory
     */
    public function __construct(
        \IdealCode\Banner\Model\ResourceModel\Type\CollectionFactory $collectionFactory
    )
    {
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $options = [
            0 => [
                'value' => '',
                'label' => '-- Please Select --'
            ]
        ];

        /** @var \IdealCode\Banner\Model\ResourceModel\Type\Collection $collection */
        $collection = $this->_collectionFactory->create();

        /** @var \IdealCode\Banner\Model\Type $type */
        foreach ($collection as $type) {
            $options[] = [
                'value' => $type->getId(),
                'label' => $type->getName()
            ];
        }

        return $options;
    }
}
