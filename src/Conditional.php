<?php

namespace Bcastellano\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Composite;

/**
 * @Annotation
 * @Target({"CLASS", "PROPERTY", "METHOD", "ANNOTATION"})
 */
class Conditional extends Composite
{
    /**
     * Constraint list to apply
     * @var array
     */
    public $constraints = array();

    /**
     * Function or callable to indicates if constraints must be validated or not
     * @var callable
     */
    public $condition;

    /**
     * Indicates where the condition return value must be true or false
     * @var boolean
     */
    public $mustMatch = true;

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'constraints';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
        return array('constraints', 'condition');
    }

    /**
     * {@inheritdoc}
     */
    protected function getCompositeOption()
    {
        return 'constraints';
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return array(self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT);
    }
}
