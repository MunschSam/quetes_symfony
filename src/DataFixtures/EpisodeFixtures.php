<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Services\Slugify;

class EpisodeFixtures extends Fixture

{
    public const EPISODE = [
        'ep1',
        'ep2',
        'ep3',
        'ep4',
        'ep5',
    ];

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = new $slugify;
    }
    
    public function load(ObjectManager $manager)
    {
        $episode = new Episode();

        foreach(self::EPISODE as $key => $episodeName){
            $episode = new Episode();
            $episode ->setNumber(1);
            $episode ->setTitle("les titres");
            $episode ->setSynopsis($episodeName);
            $manager ->persist($episode);
            $episode->setSlug($this->slugify->generate($episodeName));
            $this->addReference('episode_' . $key, $episode);
            $manager->flush();
        }
    }
    public function getDependencies()
    {
        return array(
            SeasonFixtures::class
        );
    }
}