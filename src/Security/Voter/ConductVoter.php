<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Conduct;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ConductVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['SHOW', 'DELETE'])
            && $subject instanceof \App\Entity\Conduct;
    }

    protected function voteOnAttribute($attribute, $conduct, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'SHOW':
                return $this->canShow($conduct, $user);
                break;
            case 'DELETE':
                return $this->canDelete($conduct, $user);
                break;
        }

        return false;
    }

    private function canShow(Conduct $conduct, User $user)
    {
        return $user === $conduct->getUser();
    }

    private function canDelete(Conduct $conduct, User $user)
    {
        return $user === $conduct->getUser();
    }
}
