<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRoleVoters extends Voter {

    const ROLE_WORKER = \App\Enum\Role::WORKER->value;
    const ROLE_TEAMLEADER = \App\Enum\Role::TEAMLEADER->value;
    const ROLE_PROJECTLEADER = \App\Enum\Role::PROJECTLEADER->value;
    const ROLE_ADMIN = \App\Enum\Role::ADMIN->value;
    const IS_AUTHENTICATED = 'ROLE_USER';

    protected function supports(string $attribute,  mixed $subject) : bool {
        return in_array($attribute, [self::ROLE_WORKER, self::IS_AUTHENTICATED]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token) : bool {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) 
            return false;

        switch ($attribute) {
            case self::IS_AUTHENTICATED:
                return in_array(self::IS_AUTHENTICATED, $user->getRoles());
            case self::ROLE_WORKER:
                return in_array(self::ROLE_WORKER, $user->getRoles());
        }

        return false;
    }

}