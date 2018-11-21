<?php

namespace Dynamic\YouTubeIntegration;

use SilverStripe\Dev\SapphireTest;


if (class_exists('Block')) {

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
