[![Build Status](https://travis-ci.org/bcastellano/symfony-validator-conditional.svg?branch=master)](https://travis-ci.org/bcastellano/symfony-validator-conditional)
[![Coverage Status](https://coveralls.io/repos/github/bcastellano/symfony-validator-conditional/badge.svg?branch=master)](https://coveralls.io/github/bcastellano/symfony-validator-conditional?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f544eb6c-9c1c-4728-8758-e6d3d004af9e/mini.png)](https://insight.sensiolabs.com/projects/f544eb6c-9c1c-4728-8758-e6d3d004af9e)
[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)

# Symfony Conditional validator
Symfony validator for conditional validations based on object properties

## Install

The recommended way to install is through composer:

```bash
$ composer require bcastellano/symfony-validator-conditional
```

or adding to require section in `composer.json`

## Usage
You can use PHP, Annotations, YAML or XML.

### Configuration example with PHP

```php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Bcastellano\Symfony\Validator\Constraints\Conditional;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class User
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        // property validator usage
        $metadata->addPropertyConstraint('name', new Conditional(array(
            'constraints' => array(
                new Assert\NotBlank(),
            ),
            'condition' => function($value){
                
                // add login here... $value is object of this property and can be use to check context 
                
                return $boolean; 
            }
        )));
        
        // class validator usage
        $metadata->addConstraint(new Conditional(array(
            'constraints' => array(
                new Assert\Callback('validate'),
            ),
            'condition' => function($value){
                             
                // add login here... $value is object validating and can be use to check context
             
                return $boolean; 
            }
        )));
    }
}
```

### Configuration example with annotations
```php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Bcasellano\Symfony\Validator\Constraints\Conditional;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class validator
 *
 * @Conditional(
 *     constraints = {
 *         @Assert\Callback({"AppBundle\Entity\User","validate"})
 *     },
 *     condition = "AppBundle\Entity\User::shouldValidateName"
 * )
 */
class User
{
    /**
     * Property validator
     *
     * @Conditional(
     *     constraints = {
     *         @Assert\NotBlank()
     *     },
     *     condition = "AppBundle\Entity\User::shouldValidateName"
     * )
     */
    protected $name;

    public static function shouldValidateName($object)
    {
        // add login here... $value is object validating and can be use to check context
                 
        return $boolean;
    }
    
    
    public static function validate($object, ExecutionContextInterface $context, $payload)
    {
        // ...
    }
}
```
