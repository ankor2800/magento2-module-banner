<?php
namespace IdealCode\Banner\Ui\Component\Form\Item;

class DataProvider extends \IdealCode\Core\Ui\Component\Form\DataProvider
{
    /**
     * @var \IdealCode\Banner\Model\ItemFactory
     */
    protected $_itemFactory;

    /**
     * @var \Magento\Framework\File\Mime
     */
    protected $_mime;

    /**
     * @var \IdealCode\Banner\Model\Item
     */
    protected $_item;

    /**
     * @var string
     */
    protected $_baseMediaPath;

    /**
     * DataProvider constructor.
     * @param \IdealCode\Banner\Model\ResourceModel\Item\Collection $collection
     * @param \IdealCode\Banner\Model\ItemFactory $itemFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\File\Mime $mime
     * @param $name
     * @param array $meta
     * @param array $data
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        \IdealCode\Banner\Model\ResourceModel\Item\Collection $collection,
        \IdealCode\Banner\Model\ItemFactory $itemFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\File\Mime $mime,
        $name,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($collection, $name, $meta, $data);
        $this->_itemFactory = $itemFactory;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
        );
        $this->_mime = $mime;
    }

    public function getData()
    {
        parent::getData();

        if (!empty($this->_loadedData))
        {
            foreach ($this->_loadedData as &$data) {
                $data = $this->convertValues($data);
            }
        }

        return $this->_loadedData;
    }

    /**
     * Get or create model
     * @return \IdealCode\Banner\Model\Item
     */
    private function getItemModel()
    {
        if ($this->_item === null) {
            $this->_item = $this->_itemFactory->create();
        }

        return $this->_item;
    }

    /**
     * Get const media path
     * @return string
     */
    private function getMediaPath()
    {
        if ($this->_baseMediaPath === null) {
            /** @var \IdealCode\Banner\Model\Item $item */
            $item = $this->getItemModel();

            $this->_baseMediaPath = $item::BASE_MEDIA_PATH;
        }

        return $this->_baseMediaPath;
    }

    /**
     * Convert data for image field
     * @param $data
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function convertValues($data)
    {
        /** @var \IdealCode\Banner\Model\Item $item */
        $item = $this->getItemModel();

        $fieldCode = $item::IMAGE_FIELD;
        $fileName = $data[$fieldCode];

        if (!empty($fileName) && $this->isExist($fileName)) {
            $item->setImage($fileName);

            $data[$fieldCode] = [
                [
                    'name' => $fileName,
                    'url' => $item->getImage(),
                    'size' => $this->getSize($fileName),
                    'type' => $this->getMimeType($fileName)
                ]
            ];
        }

        return $data;
    }

    /**
     * @param $fileName
     * @return string
     */
    protected function getFilePath($fileName)
    {
        return $this->getMediaPath().'/'.ltrim($fileName, '/');
    }

    /**
     * Check if the file exists
     * @param $fileName
     * @return bool
     */
    protected function isExist($fileName)
    {
        return $this->_mediaDirectory->isExist(
            $this->getFilePath($fileName)
        );
    }

    /**
     * Get size file
     * @param $fileName
     * @return integer
     */
    protected function getSize($fileName)
    {
        $result = $this->_mediaDirectory->stat(
            $this->getFilePath($fileName)
        );

        return $result['size'];
    }

    /**
     * Get MIME type of requested file
     * @param $fileName
     * @return string
     */
    protected function getMimeType($fileName)
    {
        return $this->_mime->getMimeType(
            $this->_mediaDirectory->getAbsolutePath(
                $this->getFilePath($fileName)
            )
        );
    }
}
