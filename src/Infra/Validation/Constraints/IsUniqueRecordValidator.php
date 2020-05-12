<?php

namespace App\Infra\Validation\Constraints;

use App\Domain\Activity\ActivityRecordedRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsUniqueRecordValidator extends ConstraintValidator
{
    private ActivityRecordedRepositoryInterface $activityRecordedRepository;

    public function __construct(ActivityRecordedRepositoryInterface $activityRecordedRepository)
    {
        $this->activityRecordedRepository = $activityRecordedRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsUniqueRecord) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\IsUniqueRecord');
        }

        $record = $this->activityRecordedRepository->searchByActivityAndDate(
            $value->getActivity()->getId(),
            $value->getCompletedAt()->getDate()
        );

        if ($record !== null) {
            $this->context->addViolation(
                $constraint->message,
                [
                    'activity' =>  $value->getActivity()->getName(),
                    'day' => $value->getCompletedAt()->getDate()->format('d/m/Y')
                ]
            );
        }
    }
}
