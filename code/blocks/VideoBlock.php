<?php

namespace Dynamic\YouTubeIntegration\Block;

use \Block;
use Dynamic\YouTubeIntegration\DataObject\YouTubeVideo;

if (class_exists('Block')) {

    /**
     * Class VideoBlock
     * @package Dynamic\YouTubeIntegration\Block
     *
     * @property int $VideoID
     */
    class VideoBlock extends Block
    {
        /**
         * @var string
         */
        private static $singular_name = 'Video Block';

        /**
         * @var string
         */
        private static $plural_name = 'Video Blocks';

        /**
         * @var array
         */
        private static $has_one = array(
            'Video' => 'SilverStripeYouTubeVideo',
        );

        /**
         * @return \FieldList
         */
        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $source = function(){
                return YouTubeVideo::get()->map()->toArray();
            };


            $fields->addFieldToTab(
                'Root.Main',
                \DropdownField::create('VideoID')
                    ->setTitle('Video')
                    ->setSource($source())
                    ->setEmptyString('')
                    ->useAddNew('YouTubeVideo', $source)
            );

            return $fields;
        }
    }
}