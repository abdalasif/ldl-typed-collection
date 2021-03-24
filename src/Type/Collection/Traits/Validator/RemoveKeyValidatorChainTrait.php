<?php declare(strict_types=1);

namespace LDL\Type\Collection\Traits\Validator;

use LDL\Type\Collection\AbstractCollection;
use LDL\Type\Collection\Interfaces\Validation\HasAppendValidatorChainInterface;
use LDL\Type\Collection\Types\String\StringCollection;
use LDL\Validators\Chain\ValidatorChain;
use LDL\Validators\Chain\ValidatorChainInterface;

trait RemoveKeyValidatorChainTrait
{
    /**
     * @var StringCollection
     */
    private $_tRemoveKeyCollection;

    public function getRemoveKeyValidatorChain(): ValidatorChainInterface
    {
        if(null !== $this->_tRemoveKeyCollection){
            return $this->_tRemoveKeyCollection->getAppendValidatorChain();
        }

        /**
         * Use an anonymous class here, a proper class is not needed
         */
        $this->_tRemoveKeyCollection = new class extends AbstractCollection implements HasAppendValidatorChainInterface
        {
            use AppendValidatorChainTrait;

            /**
             * @var ValidatorChainInterface
             */
            private $validatorChain;

            public function __construct(iterable $items = null)
            {
                parent::__construct($items);

                $this->validatorChain = new ValidatorChain();

                $this->getBeforeRemove()->append(function($collection, $item, $key){
                    $this->validatorChain->validate($item, $key, $collection);
                });
            }

            public function getValidatorChain(): ValidatorChainInterface
            {
                return $this->validatorChain;
            }
        };

        return $this->_tRemoveKeyCollection->getValidatorChain();
    }
}