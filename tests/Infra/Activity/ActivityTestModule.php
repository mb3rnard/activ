<?php

namespace Tests\Infra\Activity;

use App\Infra\Test\FixtureAwareTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;

class ActivityTestModule extends FixtureAwareTestCase
{
    const URI_EXPOSE_ACTIVITIES = '/activities';

    protected KernelBrowser $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->loadFixtures($this->getFixtureFiles());
    }

    protected static function getKernel(): KernelInterface
    {
        return static::$kernel;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtureFiles(): array
    {
        return [FIXTURES_DIR . '/activities.php'];
    }
}
