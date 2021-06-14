<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Services\Slugify;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAM = [
        'wild1',
        'wild2',
        'wild3',
        'wild4',
        'wild5',
    ];

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = new $slugify;
    }
    
    public function load(ObjectManager $manager)
    {
        $program = new Program();

        foreach(self::PROGRAM as $key => $programName){
            $program = new Program();
            $program ->setTitle($programName);
            $program ->setSummary("le summary");
            $program->setCategory($this->getReference('category_'.$key));
            $manager ->persist($program);
            $program->setSlug($this->slugify->generate($programName));
            $this->addReference('program_' . $key, $program);
        }
        
        //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire
        for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program->addActor($this->getReference('actor_' . $i));
        }
        $manager->persist($program);
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }


}
