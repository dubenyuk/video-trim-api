<?php

namespace Tests\Unit;

use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    /**
     * @var string
     */
    protected $login = 'admin@admin.com';
    /**
     * @var string
     */
    protected $password = '123456';

    /**
     * @param $type
     * @param $uri
     * @param array $body
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function send($type, $uri, $body = [])
    {
        return $this->call($type, $uri, $body, [], [],
            ['PHP_AUTH_USER' => $this->login, 'PHP_AUTH_PW' => $this->password]);
    }

    /**
     *
     */
    public function testMyVideoListTest()
    {
        $model = Video::create([
            'user_id' => 1,
            'status_id' => 1,
            'path' => 'path'
        ]);

        $response = $this->send('GET','api/v1/video');
        $response->assertStatus(200);
        $obj = json_decode($response->content());
        $this->assertObjectHasAttribute('data',$obj);

        $lastIndex = count($obj->data)-1;
        $lastModel =$obj->data[$lastIndex];

        $this->assertObjectHasAttribute('id',$lastModel);
        $this->assertEquals($model->status->status, $lastModel->status);
        $this->assertEquals($model->path, $lastModel->link);
    }
}
