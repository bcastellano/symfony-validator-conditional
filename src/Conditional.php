<?php

namespace Bcastellano\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Composite;

/**
 *
 */
class Conditional extends Composite
{
    /**
     * @var array
     */
    public $constraints = array();

    /**
     * @var \Closure
     */
    public $condition;

    /**
     * Indicates where the condition return value must be true or false
     * @var boolean
     */
    public $mustMatch = true;

    public function getDefaultOption()
    {
        return 'constraints';
    }

    public function getRequiredOptions()
    {
        return array('constraints', 'condition');
    }

    protected function getCompositeOption()
    {
        return 'constraints';
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return [self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT];
    }
}
