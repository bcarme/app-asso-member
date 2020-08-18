<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Registration;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TimeSlotVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['SHOW', 'DELETE'])
            && $subject instanceof \App\Entity\Registration;
    }

    protected function voteOnAttribute($attribute, $registration, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case 'SHOW':
                return $this->canShow($registration, $user);
                break;
            case 'DELETE':
                return $this->canDelete($registration, $user);
                break;
        }

        return false;
    }

    private function canShow(Registration $registration, User $user)
    {
        return $user === $registration->getUser();
    }

    private function canDelete(Registration $registration, User $user)
    {
        return $user === $registration->getUser();
    }
}
