<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $PasswordEncoder,
        private SluggerInterface $slugger    
    )
    {
        // En PHP 8 pas besoin de setter
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail('admin@symfony.com')
            ->setLastname('Aglaë')
            ->setFirstname('Sidonie')
            ->setAddress('12 rue du boulevard')
            ->setZipcode('34000')
            ->setCity('Montpellier')
            ->setPassword($this->PasswordEncoder->hashPassword($admin, 'root'))
            ->setRoles(['ROLE_ADMIN'])
        ;
        
        $manager->persist($admin);


        $faker = \Faker\Factory::create('fr_FR');

        for ($usr = 1; $usr <= 5; $usr++) {
            $user = new Users();
            $user->setEmail($faker->freeEmail)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setAddress($faker->address)
                ->setZipcode(str_replace(' ', '', $faker->postcode))
                ->setCity($faker->city)
                ->setPassword($this->PasswordEncoder->hashPassword($admin, 'password'))
                ->setRoles(['ROLE_USER'])
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
