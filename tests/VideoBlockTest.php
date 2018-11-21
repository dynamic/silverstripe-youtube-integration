<?php

namespace Dynamic\YouTubeIntegration\Tests;

use SilverStripe\Dev\SapphireTest;

/**
 *
 */
if (class_exists('Block')) {
    /**
     * Class VideoBlockTest
     * @package Dynamic\YouTubeIntegration
     */
    class VideoBlockTest extends SapphireTest
    {
        /**
         *
         */
        public function testGetCMSFields()
        {
            $object = singleton('VideoBlock');
            $fields = $object->getCMSFields();
            $this->assertInstanceOf('FieldList', $fields);
            $this->assertNotNull($fields->dataFieldByName('VideoID'));
        }
    }
}
