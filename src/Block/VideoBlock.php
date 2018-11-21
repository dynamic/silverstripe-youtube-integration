<?php

namespace Dynamic\YouTubeIntegration\Block;

/*use Block;

use DropdownField;
use Dynamic\YouTubeIntegration\Model\SilverStripeYouTubeVideo;//*/

if (class_exists('Block')) {
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
        private static $has_one = [
            'Video' => SilverStripeYouTubeVideo::class,
        ];

        /**
         * @return FieldList
         */
        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $source = function () {
                return SilverStripeYouTubeVideo::get()->map()->toArray();
            };

            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create('VideoID')
                    ->setTitle('Video')
                    ->setSource($source())
                    ->setEmptyString('')
                    ->useAddNew(SilverStripeYouTubeVideo::class, $source)
            );

            return $fields;
        }
    }
}
