<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Bus;
use App\Entity\Child;
use App\Entity\Driver;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserData implements QueryCollectionExtensionInterface, QueryItemExtensionInterface {
    private Security $security;
    const FILTERED_ENTITY = [
        Bus::class,
        // Child::class,
        // Driver::class,
    ];

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        // if ($resourceClass == Bus::class) {   
        //     $aliasTable = $queryBuilder->getRootAliases()[0];
        //     $queryBuilder->andWhere("$aliasTable.driver = :driver")->setParameter("driver", $this->security->getUser()->getId());
        // }
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {
        // if (in_array($resourceClass, self::FILTERED_ENTITY) ) {   
        //     $this->andWhere($queryBuilder);
        // }
    }

    // private function andWhere($queryBuilder) {
    //         $aliasTable = $queryBuilder->getRootAliases()[0];
    //         $queryBuilder->andWhere("$aliasTable.driver = :driver")->setParameter("driver", $this->security->getUser()->getId());
    // }
}