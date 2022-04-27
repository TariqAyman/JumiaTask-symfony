<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CountryFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $countriesList = [
            ['code' => '237', 'name' => 'Cameroon', 'regex' => "#^\(237\)\ ?[2368]\d{7,8}$#"],
            ['code' => '251', 'name' => 'Ethiopia', 'regex' => "#^\(251\)\ ?[1-59]\d{8}$#"],
            ['code' => '212', 'name' => 'Morocco', 'regex' => "#^\(212\)\ ?[5-9]\d{8}$#"],
            ['code' => '258', 'name' => 'Mozambique', 'regex' => "#^\(258\)\ ?[28]\d{7,8}$#"],
            ['code' => '256', 'name' => 'Uganda', 'regex' => "#^\(256\)\ ?\d{9}$#"]
        ];

        foreach ($countriesList as $country) {
            $newCountry = new Country();

            $newCountry->setCode($country['code']);
            $newCountry->setName($country['name']);
            $newCountry->setRegex($country['regex']);

            $manager->persist($newCountry);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['countryFixture'];
    }
}
