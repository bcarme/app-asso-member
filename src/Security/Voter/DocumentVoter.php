<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Document;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DocumentVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['SHOW', 'DELETE'])
            && $subject instanceof \App\Entity\Document;
    }

    protected function voteOnAttribute($attribute, $document, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        switch ($attribute) {
            case 'SHOW':
                return $this->canShow($document, $user);
                break;
            case 'DELETE':
                return $this->canDelete($document, $user);
                break;
        }

        return false;
    }

    private function canShow(Document $document, User $user)
    {
        return $user === $document->getUser();
    }

    private function canDelete(Document $document, User $user)
    {
        return $user === $document->getUser();
    }
}
