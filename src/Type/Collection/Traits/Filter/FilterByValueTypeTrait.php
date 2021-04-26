<?php declare(strict_types=1);

/**
 * This trait applies the FilterValueTypeInterface so you can just easily use it in your class.
 *
 * @see \LDL\Type\Collection\Interfaces\Filter\FilterByValueTypeInterface
 */

namespace LDL\Type\Collection\Traits\Filter;

use LDL\Type\Collection\Exception\EmptyCollectionException;
use LDL\Type\Collection\TypedCollectionInterface;
use LDL\Type\Collection\Types\String\StringCollection;

trait FilterByValueTypeTrait
{
    //<editor-fold desc="FilterByValueTypeInterface methods">
    public function filterByValueType(string $filter): TypedCollectionInterface
    {
        return $this->filterByValueTypes(new StringCollection([$filter]));
    }

    public function filterByValueTypes(StringCollection $types): TypedCollectionInterface
    {
        $collection = new static();

        foreach($this as $key=>$value){
            foreach($types as $type){
                if(gettype($value) === $type){
                    $collection->append($value, $key);
                }
            }
        }

        if(count($collection) === 0){
            $msg = sprintf(
                'No items could be found by key matching types: "%s"',
                implode(', ', \iterator_to_array($types))
            );
            throw new EmptyCollectionException($msg);
        }

        return $collection;
    }
}
