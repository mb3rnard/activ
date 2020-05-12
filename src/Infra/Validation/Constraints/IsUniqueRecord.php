<?php

namespace App\Infra\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

class IsUniqueRecord extends Constraint
{
    public $message = 'activity has already been registered for the date day.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
