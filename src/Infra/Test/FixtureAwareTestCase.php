<?php

namespace App\Infra\Test;

use App\Infra\Test\ORM\FixturesLoader;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

abstract class FixtureAwareTestCase extends WebTestCase
{
    use AssertionsTrait;

    private ?ORMExecutor $fixtureExecutor;

    private ?FixturesLoader $fixtureLoader;

    private static string $testCaseResourcePath;

    /**
     * Ensures typed properties are set to null before being instantiated
     */
    public function __construct()
    {
        parent::__construct(null, [], '');
        $this->fixtureExecutor = null;
        $this->fixtureLoader = null;
    }

    /**
     * Sets the directory for test files
     */
    public static function setUpBeforeClass(): void
    {
        $filename = (new \ReflectionClass(static::class))->getFileName();
        self::$testCaseResourcePath = $filename ? substr($filename, 0, -4) : '';
    }

    /**
     * Loads the fixtures in parameter and populates the database with it
     */
    protected function loadFixtures(array $fixtures): void
    {
        $fixtureLoader = $this->getFixtureLoader();

        foreach ($fixtures as $filePath) {
            $fixtureLoader->addFixtureFile($filePath);
        }

        $this->executeFixtures($fixtureLoader);
    }

    /**
     * Executes all the fixtures that have been loaded.
     */
    private function executeFixtures(FixtureInterface $fixtureLoader): void
    {
        $doctrineLoader = new Loader();
        $doctrineLoader->addFixture($fixtureLoader);

        $this->getFixtureExecutor()->execute($doctrineLoader->getFixtures());
    }

    /**
     * Get the class responsible for loading the data fixtures.
     * This will also load in the ORM Purger which purges the database before loading in the data fixtures
     */
    private function getFixtureExecutor(): ORMExecutor
    {
        if (!$this->fixtureExecutor) {
            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
            $this->fixtureExecutor = new ORMExecutor($entityManager, new ORMPurger($entityManager));
        }

        return $this->fixtureExecutor;
    }

    /**
     * Get the custom Fixtures Loader that uses Alice file loader
     */
    private function getFixtureLoader(): FixturesLoader
    {
        if (!$this->fixtureLoader) {
            $this->fixtureLoader =  new FixturesLoader($this->getFixturesDir());
            $this->fixtureLoader->setContainer(static::$kernel->getContainer());
        }

        return $this->fixtureLoader;
    }

    /**
     * Get the fixtures directory for this test case
     */
    protected function getFixturesDir(): string
    {
        return "{$this->getTestCaseResourcePath()}/fixtures";
    }

    protected function getTestCaseResourcePath(): string
    {
        return self::$testCaseResourcePath;
    }
}
