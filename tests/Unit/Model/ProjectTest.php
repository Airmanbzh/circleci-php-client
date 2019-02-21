<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Model;

use Jmleroux\CircleCi\Model\Project;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    public function testCreateFromJson()
    {
        $json = file_get_contents(__DIR__ . '/../resources/project.json');
        $project = Project::createFromNormalized(json_decode($json, true));
        $this->assertInstanceOf(Project::class, $project);
    }

    public function testNormalize()
    {
        $json = file_get_contents(__DIR__ . '/../resources/project.json');
        $project = Project::createFromNormalized(json_decode($json, true));

        $expected = [
            'vcs_url' => 'https://github.com/circleci/mongofinil',
            'followed' => true,
            'username' => 'circleci',
            'reponame' => 'mongofinil',
            'branches' => [
                'master' => ['name' => 'master', 'running_builds' => []],
                'develop' => ['name' => 'develop', 'running_builds' => []],
            ],
        ];

        $this->assertSame($expected, $project->normalize());
    }
}
