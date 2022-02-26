<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
        // En PHP 8 pas besoin de setter
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($prod = 1; $prod <= 10; $prod++) {

            $category = $this->getReference('cat-' . rand(1, 8));

            $product = new Products();
            $product->setName($faker->text(5))
                ->setDescription($faker->text())
                ->setPrice($faker->numberBetween(900, 150000))
                ->setStock($faker->numberBetween(0, 10))
                ->setCategories($category)
                ->setSlug($this->slugger->slug($product->getName())->lower())
            ;

            $this->addReference('prod-' . $prod, $product);

            $manager->persist($product);
        }
        $manager->flush();
    }
}
