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
use Bcastellano\Symfony\Component\Validator\Constraints\Conditional;

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