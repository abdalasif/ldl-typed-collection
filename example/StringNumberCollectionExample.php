<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use LDL\Type\Collection\AbstractCollection;
use LDL\Type\Collection\Traits\Validator\AppendValueValidatorChainTrait;
use LDL\Type\Collection\Interfaces\Validation\HasAppendValueValidatorChainInterface;
use LDL\Validators\NumericValidator;
use LDL\Validators\StringValidator;
use LDL\Validators\Chain\Exception\CombinedException;
use LDL\Validators\Chain\OrValidatorChain;

class StringNumberCollectionExample extends AbstractCollection implements HasAppendValueValidatorChainInterface
{
    use AppendValueValidatorChainTrait;

    public function __construct(iterable $items = null)
    {
        parent::__construct($items);

        $this->getAppendValueValidatorChain(OrValidatorChain::class)
            ->getChainItems()
            ->append(new NumericValidator())
            ->append(new StringValidator());
    }
}

echo "Create string/number collection instance\n";

$collection  = new StringNumberCollectionExample();

echo "Append string item: 'hello'\n";
$collection->append('hello');

echo "Append number item: 123\n";
$collection->append(123);

try {

    echo "Try to add an object, exception must be thrown\n\n";
    $collection->append(new \stdClass());

}catch(CombinedException $e){

    echo "EXCEPTION: {$e->getCombinedMessage()}\n";

}