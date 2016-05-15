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
        $condition = call_user_func($constraint->condition, $this->context->getObject());

        if ($constraint->mustMatch === $condition) {
            $context = $this->context;

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
