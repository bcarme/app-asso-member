<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\OnlineForm;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class OnlineFormVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['SHOW', 'DELETE'])
            && $subject instanceof \App\Entity\OnlineForm;
    }

    protected function voteOnAttribute($attribute, $onlineForm, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'SHOW':
                return $this->canShow($onlineForm, $user);
                break;
            case 'DELETE':
                return $this->canDelete($onlineForm, $user);
                break;
        }

        return false;
    }

    private function canShow(OnlineForm $onlineForm, User $user)
    {
        return $user === $onlineForm->getUser();
    }

    private function canDelete(OnlineForm $onlineForm, User $user)
    {
        return $user === $onlineForm->getUser();
    }
}
