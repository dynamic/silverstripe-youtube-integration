<?php

if (class_exists('Block')) {

    class VideoBlockTest extends SapphireTest
    {
        /**
         *
         */
        public function testGetCMSFields()
        {
            $object = singleton('Dynamic\YouTubeIntegrations\Block\VideoBlock');
            $fields = $object->getCMSFields();
            $this->assertInstanceOf('FieldList', $fields);
            $this->assertNotNull($fields->dataFieldByName('VideoID'));
        }
    }
}