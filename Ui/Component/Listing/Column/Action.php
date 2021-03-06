<?php
namespace IdealCode\Banner\Ui\Component\Listing\Column;

class Action extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            /** @var \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource */
            $resource = $this->getData('resource');

            $idFieldName = $resource->getIdFieldName();

            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$idFieldName])) {
                    $item[$this->getName()] = [
                        'edit' => [
                            'href' => $this->context->getUrl(
                                $this->getUrl().'/edit',
                                [
                                    $idFieldName => $item[$idFieldName]
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->context->getUrl(
                                $this->getUrl().'/delete',
                                [
                                    $idFieldName => $item[$idFieldName]
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete'),
                                'message' => __('Are you sure you want to delete a item?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
