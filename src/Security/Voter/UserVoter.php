<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['DELETE', 'EDIT'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute($attribute, $user, TokenInterface $token)
    {
        $ConnectedUser = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$ConnectedUser instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'DELETE':
                break;
            case 'EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                break;
        }

        return false;
    }
}
