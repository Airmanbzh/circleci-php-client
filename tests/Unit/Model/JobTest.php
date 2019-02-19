<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi\Tests\Unit\Model;

use Jmleroux\CircleCi\Model\Job;
use PHPUnit\Framework\TestCase;

class JobTest extends TestCase
{
    public function testCreateFromJson()
    {
        $json = file_get_contents(__DIR__ . '/../resources/job-with-steps.json');
        $job = Job::createFromNormalized(json_decode($json, true));
        $this->assertInstanceOf(Job::class, $job);
    }

    public function testNormalize()
    {
        $json = file_get_contents(__DIR__ . '/../resources/job-with-steps.json');
        $job = Job::createFromNormalized(json_decode($json, true));

        $expected = [
            'vcsUrl' => 'https://github.com/circleci/mongofinil',
            'buildUrl' => 'https://circleci.com/gh/circleci/mongofinil/22',
            'buildNum' => 22,
            'branch' => 'master',
            'startTime' => '2013-02-12 21:33:38',
            'stopTime' => '2013-02-12 21:34:01',
            'buildTimeMillis' => 23505,
            'username' => 'circleci',
            'reponame' => 'mongofinil',
            'outcome' => 'success',
            'status' => 'success',
            'steps' => [
                'configure the build' => [
                    'name' => 'configure the build',
//                    'actions' => [
//                        [
//                            'name' => 'named_action',
//                            'status' => 'success',
//                            'run_time_millis' => 1646,
//                            'start_time' => '2013-02-12T21:33:38Z',
//                            'end_time' => '2013-02-12T21:33:39Z',
//                        ],
//                    ],
                ],
                'lein2 deps' => [
                    'name' => 'lein2 deps',
//                    'actions' => [
//                        [
//                            'name' => '',
//                            'status' => 'success',
//                            'run_time_millis' => 7555,
//                            'start_time' => '2013-02-12T21:33:47Z',
//                            'end_time' => '2013-02-12T21:33:54Z',
//                        ],
                ],
            ],
            'workflows' => null,
        ];

        $this->assertEquals($expected, $job->normalize());

        $json = file_get_contents(__DIR__ . '/../resources/job-with-workflows.json');
        $job = Job::createFromNormalized(json_decode($json, true));

        $expected = [
            'vcsUrl' => 'https://github.com/circleci/mongofinil',
            'buildUrl' => 'https://circleci.com/gh/circleci/mongofinil/22',
            'buildNum' => 22,
            'branch' => 'master',
            'startTime' => '2013-02-12 21:33:38',
            'stopTime' => '2013-02-12 21:34:01',
            'username' => 'circleci',
            'reponame' => 'mongofinil',
            'buildTimeMillis' => 23505,
            'outcome' => 'success',
            'status' => 'success',
            'steps' => [],
            'workflows' => [
                'workflow_id' => 'my_workflow_id',
                'workflow_name' => 'my_workflow_name',
                'job_id' => 'my_job_id',
                'job_name' => 'my_job_name',
            ],
        ];

        $this->assertEquals($expected, $job->normalize());
    }
}
