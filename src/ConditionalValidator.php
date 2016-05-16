<?php

namespace Bcastellano\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Validate a list of constrains if a condition is valid
 */
class ConditionalValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $context = $this->context;
        if ($context instanceof ExecutionContextInterface) {
            $object = $this->context->getObject();
        } else {
            $object = $this->context->getRoot();
        }

        // execute callable condition with context object as parameter
        $condition = call_user_func($constraint->condition, $object);

        // if condition result match validate list of constraints
        if ($constraint->mustMatch === $condition) {
            if ($context instanceof ExecutionContextInterface) {
                $validator = $context->getValidator()->inContext($context);

                $validator->validate($value, $constraint->constraints, $this->context->getGroup());

            } else {
                // 2.4 API
                $context->validateValue($value, $constraint->constraints, '', $this->context->getGroup());
            }
        }
    }
}
