<?php
namespace IdealCode\Banner\Controller\Adminhtml;

abstract class Action extends Banner
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_filter;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $_object;

    /**
     * Action constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magento\Framework\DataObjectFactory $objectFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\DataObjectFactory $objectFactory,
        array $data = []
    )
    {
        $this->_object = $objectFactory->create();
        $this->_object->addData($data);
        $this->_filter = $filter;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFilterCollection()
    {
        return $this->_filter->getCollection(
            $this->_object->getData('collectionFactory')->create()
        );
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    protected function getResource()
    {
        return $this->_object->getData('resource');
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     */
    protected function getModel()
    {
        return $this->_object->getData('modelFactory')->create();
    }
}
