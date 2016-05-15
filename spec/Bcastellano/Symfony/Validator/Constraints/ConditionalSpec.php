<?php

namespace spec\Bcastellano\Symfony\Validator\Constraints;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConditionalSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bcastellano\Symfony\Validator\Constraints\Conditional');
    }
}
