<?php

namespace App\Infra\Test\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class FixturesLoader implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var string */
    private $basePath;

    /** @var array */
    private $fixtureFiles;

    public function __construct(string $basePath = null, array $fixtureFiles = [])
    {
        $this->basePath = $basePath;
        $this->fixtureFiles = $fixtureFiles;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $loader = $this->container->get('nelmio_alice.file_loader');

        foreach ($this->fixtureFiles as $file) {
            $objectSet = $loader->loadFile($file);

            foreach ($objectSet->getObjects() as $object) {
                $manager->persist($object);
            }

            $manager->flush();
            $manager->clear();
        }
    }

    /**
     * @param string $fixturePath The fixture file to additionally load
     */
    public function addFixtureFile(string $fixturePath)
    {
        // If not an absolute path, prepend the base path
        if (0 !== strpos($fixturePath, '/')) {
            $fixturePath = $this->basePath . '/' . $fixturePath;
        }

        $this->fixtureFiles[] = $fixturePath;
    }
}
