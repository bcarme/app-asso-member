<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Member;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MemberVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['EDIT', 'SHOW', 'DELETE'])
            && $subject instanceof \App\Entity\Member;
    }

    protected function voteOnAttribute($attribute, $member, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case 'EDIT':
                return $this->canEdit($member, $user);
                break;
            case 'SHOW':
                return $this->canShow($member, $user);
                break;
            case 'DELETE':
                return $this->canDelete($member, $user);
                break;
        }
        return false;
    }

    private function canEdit(Member $member, User $user)
    {
        return $user === $member->getUser();
    }

    private function canShow(Member $member, User $user)
    {
        return $user === $member->getUser();
    }

    private function canDelete(Member $member, User $user)
    {
        return $user === $member->getUser();
    }
}
