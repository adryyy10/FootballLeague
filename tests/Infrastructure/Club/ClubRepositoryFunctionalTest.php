<?php

namespace App\Tests\Infrastructure\Club;

use App\Domain\Club\Club;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Infrastructure\Doctrine\Model\Club\ClubFixture;
use App\Infrastructure\Doctrine\Model\Club\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\EntityManager;

class ClubRepositoryFunctionalTest extends KernelTestCase
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ReferenceRepository
     */
    private $fixtures;

    /**
     * @var ClubRepository
     */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();
        $kernel = static::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        //$this->subject = new ClubRepository($this->entityManager);
        //$this->fixtures = $this->loadFixtures([ClubFixture::class])->getReferenceRepository();
    }


    /*public function testFind()
    {
        $firstClub = $this->fixtures->getReference(ClubFixture::FIRST_CLUB_REFERENCE);

        $result = $this->subject->find($firstClub->getId());

        $this->assertEquals($firstClub->getId(), $result->getId());
    }

    public function testFindNotExist()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->subject->find(999999);
    }

    public function testSave()
    {
        $coach = Coach::create(
            'coachName',
            1234
        );
        
        $club = Club::create(
            'test',
            12345,
            $coach
        );

        $result = $this->subject->save($club);
        $this->assertInstanceOf(Club::class, $result);
        $this->assertNotNull($result->getId());
        $this->assertGreaterThan(0, $result->getId());
    }*/
}
