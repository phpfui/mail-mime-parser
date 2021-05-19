<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Message\Factory;

use ZBateson\MailMimeParser\Stream\StreamFactory;
use ZBateson\MailMimeParser\Message\MimePart;
use ZBateson\MailMimeParser\Message\MultiPart;

/**
 * Responsible for creating MimePart instances.
 *
 * @author Zaahid Bateson
 */
class MimePartFactory extends MessagePartFactory
{
    /**
     * @var PartHeaderContainerFactory
     */
    protected $partHeaderContainerFactory;

    /**
     * @var PartChildrenContainerFactory
     */
    protected $partChildrenContainerFactory;

    public function __construct(
        StreamFactory $streamFactory,
        PartStreamContainerFactory $partStreamContainerFactory,
        PartHeaderContainerFactory $partHeaderContainerFactory,
        PartChildrenContainerFactory $partChildrenContainerFactory
    ) {
        parent::__construct($streamFactory, $partStreamContainerFactory);
        $this->partHeaderContainerFactory = $partHeaderContainerFactory;
        $this->partChildrenContainerFactory = $partChildrenContainerFactory;
    }

    /**
     * Constructs a new IMimePart object and returns it
     *
     * @return \ZBateson\MailMimeParser\Message\IMimePart
     */
    public function newInstance()
    {
        $streamContainer = $this->partStreamContainerFactory->newInstance();
        $headerContainer = $this->partHeaderContainerFactory->newInstance();
        $part = new MimePart(
            null,
            $streamContainer,
            $headerContainer,
            $this->partChildrenContainerFactory->newInstance()
        );
        $streamContainer->setStream($this->streamFactory->newMessagePartStream($part));
        return $part;
    }
}
