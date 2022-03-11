<?php

namespace App\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessFilterListener
{
    public function toto(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        try {
            if (!in_array("ROLE_MEMBER", $user->getRoles()) && !in_array("ROLE_CHILD", $user->getRoles())) {
                throw new \Exception("Vous n'êtes paas autorisé à vous conneté");
            }
        } catch (\Throwable $erreur) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: *");
            print(json_encode(["message" => $erreur->getMessage()]));
            die;
        }
    }
}
