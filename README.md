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

Configuration example for PHP. You also can use Annotations, YAML or XML.

```php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Bcastellano\Symfony\Validator\Constraints\Conditional;

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
