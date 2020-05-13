<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * Returns the full details for a single job.
 * The response includes all of the fields from the job summary.
 *
 * @author jmleroux <jmleroux.pro@gmail.com>
 * @link https://circleci.com/docs/api/#single-job
 * @deprecated use Jmleroux\CircleCi\Api\Job\SingleBuild
 */
class SingleBuild
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v1.1']);
        $this->client = $client;
    }

    public function execute(string $vcsType, string $username, string $reponame, int $buildNum): ?\stdClass
    {
        $uri = sprintf(
            'project/%s/%s/%s/%s',
            $vcsType,
            $username,
            $reponame,
            $buildNum
        );

        $response = $this->client->get($uri);

        return json_decode((string)$response->getBody());
    }
}
