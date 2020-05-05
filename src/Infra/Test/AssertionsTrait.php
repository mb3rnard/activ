<?php

namespace App\Infra\Test;

use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait AssertionsTrait
{
    protected function assertJsonResponseMatchesExpectations(Response $response, string $filePath)
    {
        $json = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $this->jsonEncode(json_decode($response->getContent())));

        if (UPDATE_EXPECTATIONS) {
            $this->updateExpectations($filePath, $json);
        }

        $this->assertJsonStringMatchesJsonString(
            rtrim(file_get_contents($filePath)),
            rtrim($json),
            "Failed asserting that string matches format description in \"$filePath\""
        );
    }

    protected function assertJsonStringMatchesJsonString(
        string $expectedJson,
        string $actualJson,
        string $message = ''
    ) {
        Assert::assertJson($expectedJson);
        Assert::assertJson($actualJson);

        Assert::assertStringMatchesFormat(
        // We need to workaround the fact format placeholders are always in a json string:
            strtr($this->jsonEncode(json_decode($expectedJson)), ['"%d"' => '%d', '"%a"' => '%a', '"%A"' => '%A']),
            $this->jsonEncode((json_decode($actualJson, true))),
            $message
        );
    }

    /**
     * Encodes to the expected format for output fixtures
     */
    private function jsonEncode($content): string
    {
        return json_encode($content, JSON_PRETTY_PRINT) . PHP_EOL;
    }

    /**
     * Updates given file with content if UPDATE_EXPECTATIONS is true.
     */
    private function updateExpectations(string $filePath, string $content): void
    {
        if (
            file_exists($filePath) &&
            1 === preg_match('/\%e|\%s|\%S|\%a|\%A|\%w|\%i|\%d|\%x|\%f|\%c/', file_get_contents($filePath))
        ) {
            self::$updateExpectationsWarning = <<<TXT

⚠️  Updating expectations in file "$filePath" containing one or more format strings.
🙏  Please double-check the diff before commit!
TXT;
        }

        file_put_contents($filePath, rtrim($content) . "\n");
    }
}
