<?php

namespace Dynamic\YouTubeIntegration\Tests;

use SilverStripe\Dev\SapphireTest;
use Dynamic\YouTubeIntegration\Model\YouTubeDataObject;
use Madcoda\Youtube\Youtube;
use SilverStripe\Dev\TestOnly;

/**
 * Class YouTubeDataObjectTest
 * @package Dynamic\YouTubeIntegration
 */
class YouTubeDataObjectTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $extra_dataobjects = [
        TestYouTubeDataObject::class,
    ];

    /**
     * Test that the youtube client is retrievable
     */
    public function testGetYouTubeClient()
    {
        $this->markTestIncomplete('Re-implement YouTubeDataObjectTest::testGetYouTubeClient()');
        /*$object = TestYouTubeDataObject::create();
        $object->write();
        $this->assertNotNull($object->getYouTubeClient());
        $this->assertInstanceOf(Youtube::class, $object->getYouTubeClient());
        //*/
    }
}
