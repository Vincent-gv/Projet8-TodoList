<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Task;

class TaskVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['DELETE', 'DELETE_ANONYME'])
            && $subject instanceof Task;
    }

    protected function voteOnAttribute($attribute, $task, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'DELETE':
                return $user === $task->getUser();

            case 'DELETE_ANONYME':

                if ($task->getUser()->getUsername() === 'Anonyme' && in_array("ROLE_ADMIN", $user->getRoles())) {
                    return true;
                } else {
                    return false;
                }
        }

        return false;
    }
}
