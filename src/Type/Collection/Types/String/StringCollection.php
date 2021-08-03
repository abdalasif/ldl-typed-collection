<?php declare(strict_types=1);

namespace LDL\Type\Collection\Types\String;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Type\Collection\AbstractCollection;
use LDL\Type\Collection\Interfaces\Validation\HasAppendValueValidatorChainInterface;
use LDL\Type\Collection\Traits\Validator\AppendValueValidatorChainTrait;
use LDL\Validators\StringValidator;

class StringCollection extends AbstractCollection implements HasAppendValueValidatorChainInterface
{
    use AppendValueValidatorChainTrait;

    /**
     * @var ?string
     */
    private $imploded;

    public function __construct(iterable $items = null)
    {
        parent::__construct($items);

        $this->getAppendValueValidatorChain()
            ->getChainItems()
            ->append(new StringValidator())
            ->lock();
    }

    public function implode(string $separator=',', bool $considerToStringObjects=true) : string
    {
        if(null !== $this->imploded){
            return $this->imploded;
        }

        $this->imploded = implode($separator, \iterator_to_array($this));
        return $this->imploded;
    }

    public function append($item, $key = null) : CollectionInterface
    {
        $this->imploded = null;
        return parent::append($item, $key);
    }

    public function remove($offset) : CollectionInterface
    {
        $this->imploded = null;
        return parent::remove($offset);
    }

    public function toUnique(): UniqueStringCollection
    {
        return new UniqueStringCollection(array_map(
            static function($item) {
                return (string) $item;
            },
            array_keys(array_flip(\iterator_to_array($this)))
        ));
    }
}