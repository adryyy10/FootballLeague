<?php

namespace App\Infrastructure\Doctrine\Model\Club;

use App\Domain\Club\Club;
use App\Domain\Coach\Coach;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ClubFixture extends Fixture
{
    public const FIRST_CLUB_REFERENCE  = 'firstClub';
    public const SECOND_CLUB_REFERENCE = 'secondClub';

    public function load(ObjectManager $manager)
    {

        $firstCoach = Coach::create(
            'firstCoachName',
            456
        );

        $firstClub = Club::create(
            'firstClubName',
            12345,
            $firstCoach
        );

        $secondCoach = Coach::create(
            'secondCoachName',
            768
        );

        $secondClub = Club::create(
            'secondClubName',
            12345,
            $secondCoach
        );


        $this->setReference(self::FIRST_CLUB_REFERENCE, $firstClub);
        $this->setReference(self::SECOND_CLUB_REFERENCE, $secondClub);

        $functionalTestBookings = [$firstClub, $secondClub];

        foreach ($functionalTestBookings as $booking) {
            $manager->persist($booking);
        }

        $manager->flush();
    }
}
