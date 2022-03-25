<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Bus;
use App\Entity\Child;
use App\Entity\Driver;
use App\Entity\Parents;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder ) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $parent = (new Parents())->setEmail("parent@parent.fr")->setUsername("parent@parent.fr")->setRoles(["ROLE_PARENT"])->setPhone("+33873984324");
        $hashPwd = $this->encoder->hashPassword($parent , "toto");
        $parent->setPassword($hashPwd);
        $manager->persist($parent);

        $child_1 = (new Child())->setEmail("child@child.fr")->setUsername("child@child.fr")->setParent($parent)->setRoles(["ROLE_CHILD"]);
        $hashPwd = $this->encoder->hashPassword($child_1 , "tutu");
        $child_1->setPassword($hashPwd);
        $manager->persist($child_1);

        $child_2 = (new Child())->setEmail("pupils@pupils.fr")->setUsername("pupils@pupils.fr")->setParent($parent)->setRoles(["ROLE_CHILD"]);
        $hashPwd = $this->encoder->hashPassword($child_2 , "pupils");
        $child_2->setPassword($hashPwd);
        $manager->persist($child_2);

        $user = (new User())->setEmail("admin@admin.fr")->setUsername("admin@admin.fr")->setRoles(["ROLE_ADMIN", "ROLE_MEMBER"]);
        $hashPwd = $this->encoder->hashPassword($user , "adminadmin");
        $user->setPassword($hashPwd);
        $manager->persist($user);

        $driver = (new Driver())->setEmail("driver@driver.fr")->setUsername("driver@driver.fr")->setRoles(["ROLE_MEMBER", "ROLE_DRIVER"])->setDrivingLicence("32874267894");
        $hashPwd = $this->encoder->hashPassword($driver , "driver");
        $driver->setPassword($hashPwd);
        $manager->persist($driver);

        $driver_1 = (new Driver())->setEmail("uber@uber.fr")->setUsername("uber@uber.fr")->setRoles(["ROLE_MEMBER", "ROLE_DRIVER"])->setDrivingLicence("2R072423");
        $hashPwd = $this->encoder->hashPassword($driver_1 , "uber");
        $driver_1->setPassword($hashPwd);
        $manager->persist($driver_1);

        $bus = (new Bus())->setDriver($driver)->addChild($child_1)->addChild($child_2)->setImmat("UDZB83");
        $manager->persist($bus);

        $bus_1 = (new Bus())->setDriver($driver_1)->setImmat("ZLCZ234");
        $manager->persist($bus_1);

        $manager->flush();
    }
}
