<?php

/**
 * Class YouTubeDataObjectTest
 */
class YouTubeDataObjectTest extends SapphireTest
{

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        Config::inst()->update('YouTubeDataObject', 'youtube_api_key', 'AIzaSyB2rFhOGD-k52MYJpLe4MogVQGgopZw0GU');
    }

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'TestYouTubeDataObject',
    ];

    /**
     * Test that the youtube client is retrievable
     */
    public function testGetYouTubeClient()
    {

        $object = TestYouTubeDataObject::create();
        $object->write();
        $this->assertNotNull($object->getYouTubeClient());
        $this->assertInstanceOf('\Madcoda\Youtube\Youtube', $object->getYouTubeClient());

    }

}

/**
 * Class TestYouTubeDataObject
 */
class TestYouTubeDataObject extends YouTubeDataObject
{
    /**
     * @var array
     */
    private static $db = [
        'test' => 'Boolean',
    ];
}