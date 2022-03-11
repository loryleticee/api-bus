<?php

namespace App\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload        = $event->getData();
        $user           = $event->getUser();
        $user_Roles     = $user->getRoles();

        if (in_array("ROLE_CHILD", $user_Roles)) {
            $parent_phone = $user->getParent()->getPhone();
            $payload["phone"] = $parent_phone;
            $event->setData($payload);
        }
    }
}
