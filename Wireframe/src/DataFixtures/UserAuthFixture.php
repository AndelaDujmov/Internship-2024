<?php

namespace App\DataFixtures;

use App\Entity\AuthenticatedUser;
use App\Enum\Type;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use PHPUnit\TextUI\Command;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserAuthFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $mocked = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $user = new AuthenticatedUser();
            $user->setName($mocked->userName . $i);
            $user->setPassword($this->passwordEncoder->hashPassword($user, $mocked->password));
            $user->setVerified(true);
            $user->setContractStartDate(new \DateTime());
            $user->setContractEndDate(Carbon::now()->endOfWeek());
            $user->setRoles(['USER_ROLE']);
            $user->setType($i % 2 == 0 ? Type::PREMIUM->value : Type::NORMAL->value);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
