<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TemplateVoters extends Voter
{
    const VIEW = 'view';
    const ROLE_TEAMLEADER = \App\Enum\Role::TEAMLEADER->value;
    const ROLE_PROJECTLEADER = \App\Enum\Role::PROJECTLEADER->value;

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::VIEW && $subject === null;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if (in_array(self::ROLE_TEAMLEADER, $user->getRoles()) || in_array(self::ROLE_PROJECTLEADER, $user->getRoles())) {
            return true;
        }

        return false;
    }
}
