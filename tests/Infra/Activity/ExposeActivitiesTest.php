<?php

namespace Tests\Infra\Activity;

class ExposeActivitiesTest extends ActivityTestModule
{
    public function testExposeUser()
    {
        $this->client->request('GET', self::URI_EXPOSE_ACTIVITIES);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertJsonResponseMatchesExpectations(
            $this->client->getResponse(),
            __DIR__ . '/expected/expose_user.json'
        );
    }
}
