<?php
namespace IdealCode\Banner\Ui\Component\Listing\Column;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {

            /** @var \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource */
            $resource = $this->getData('resource');

            $idFieldName = $resource->getIdFieldName();
            $fieldName = $this->getName();

            /** @var \IdealCode\Banner\Model\Item $item */
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';

                if ($item[$fieldName] != '') {
                    $url = $this->getData('storeManager')->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ).$this->getData('mediaPath').$item[$fieldName];
                }

                $item[$fieldName.'_src'] = $url;
                $item[$fieldName.'_link'] = $this->context->getUrl(
                    $this->getUrl().'/edit',
                    [$idFieldName => $item[$idFieldName]]
                );

                $item[$fieldName.'_orig_src'] = $url;
           }
        }

        return $dataSource;
    }
}
