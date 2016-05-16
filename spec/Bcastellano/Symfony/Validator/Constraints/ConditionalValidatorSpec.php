<?php

namespace spec\Bcastellano\Symfony\Validator\Constraints;

use Bcastellano\Symfony\Validator\Constraints\Conditional;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\Context\ExecutionContextInterface as NewContext;
use Symfony\Component\Validator\ExecutionContextInterface as DeprecatedContext;
use Symfony\Component\Validator\Validator\ContextualValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConditionalValidatorSpec extends ObjectBehavior
{
    function let(Conditional $constraint)
    {
        $constraint->condition = function() {return true;};
        $constraint->constraints = array();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bcastellano\Symfony\Validator\Constraints\ConditionalValidator');
    }

    function it_validates_new_context($constraint, NewContext $context, ValidatorInterface $validator, ContextualValidatorInterface $contextValidator)
    {
        $context->getGroup()->shouldBeCalled();
        $context->getObject()->shouldBeCalled();

        $context->getValidator()->willReturn($validator);
        $validator->inContext($context)->willReturn($contextValidator);
        $contextValidator->validate('some value', $constraint->constraints, Argument::any())->shouldBeCalled();

        $this->initialize($context);
        $this->validate('some value', $constraint);
    }

    function it_validates_deprecated_context($constraint, DeprecatedContext $context)
    {
        $context->getGroup()->shouldBeCalled();
        $context->getRoot()->shouldBeCalled();
        $context->validateValue('some value', $constraint->constraints, Argument::any(), Argument::any())->shouldBeCalled();

        $this->initialize($context);
        $this->validate('some value', $constraint);
    }

    function it_validates_object($constraint, NewContext $context, ValidatorInterface $validator, ContextualValidatorInterface $contextValidator)
    {
        $constraint->condition = function($object) {return $object->name=='some name';};

        $object = new \stdClass();
        $object->name = 'some name';

        $context->getGroup()->shouldBeCalled();
        $context->getObject()->willReturn($object);

        $context->getValidator()->willReturn($validator);
        $validator->inContext($context)->willReturn($contextValidator);
        $contextValidator->validate($object, $constraint->constraints, Argument::any())->shouldBeCalled();

        $this->initialize($context);
        $this->validate($object, $constraint);
    }

    function it_does_not_validate_false_condition($constraint, NewContext $context, ValidatorInterface $validator, ContextualValidatorInterface $contextValidator)
    {
        $constraint->condition = function() {return false;};

        $context->getObject()->shouldBeCalled();

        $context->getValidator()->shouldNotBeCalled();
        $context->validateValue(Argument::any(), Argument::any(), Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->initialize($context);
        $this->validate('some value', $constraint);
    }
}
