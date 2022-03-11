<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Bus;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserData implements QueryCollectionExtensionInterface, QueryItemExtensionInterface {
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if ($resourceClass == Bus::class) {   
            $aliasTable = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere("$aliasTable.driver = :driver")->setParameter("driver", $this->security->getUser()->getId());
        }
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        if ($resourceClass == Bus::class) {   
            $aliasTable = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere("$aliasTable.driver = :driver")->setParameter("driver", $this->security->getUser()->getId());
        }
    }
}