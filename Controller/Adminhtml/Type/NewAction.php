<?php
namespace IdealCode\Banner\Controller\Adminhtml\Type;

class NewAction extends Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
