<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Api;

use Jmleroux\CircleCi\Client;
use Jmleroux\CircleCi\ValidateClientVersionTrait;

/**
 * @author jmleroux <jmleroux.pro@gmail.com>
 * https://circleci.com/docs/api/#recent-builds-for-a-single-project
 * @deprecated use Jmleroux\CircleCi\Api\Project\BuildSummaryForBranch and extract the first result
 */
class BranchLastBuild
{
    use ValidateClientVersionTrait;

    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->validateClientVersion($client, ['v1.1']);
        $this->client = $client;
    }

    public function execute(string $vcsType, string $username, string $reponame, string $branch): ?\stdClass
    {
        $uri = sprintf(
            'project/%s/%s/%s/tree/%s',
            $vcsType,
            $username,
            $reponame,
            $branch
        );

        $response = $this->client->get($uri);

        $builds = json_decode((string) $response->getBody());

        return !empty($builds) ? $builds[0] : null;
    }
}
