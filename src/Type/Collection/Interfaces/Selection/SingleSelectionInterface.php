<?php declare(strict_types=1);

namespace LDL\Type\Collection\Interfaces\Selection;

use LDL\Type\Collection\Exception\EmptyCollectionException;
use LDL\Type\Collection\Exception\ItemSelectionException;

interface SingleSelectionInterface extends SelectionLockingInterface
{

    /**
     * Select an item in the collection
     *
     * @throws ItemSelectionException if selection is locked
     * @param string $key
     * @return SingleSelectionInterface
     */
    public function select($key) : SingleSelectionInterface;

    /**
     * Return the selected item, previously selected by the select method
     *
     * @throws EmptyCollectionException if the collection is empty
     * @throws ItemSelectionException if there is no item selected
     */
    public function getSelectedItem();

    /**
     * Returns the selected key
     * @return number|string
     * @throws ItemSelectionException If no item was selected
     */
    public function getSelectedKey();

}