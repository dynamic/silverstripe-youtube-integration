<?php

namespace Dynamic\YouTubeIntegration\DataObject;

use \Block;
use Dynamic\YouTubeIntegration\Page\YouTubeIntegrationVideosPage;
use Dynamic\YouTubeIntegration\DataObject\YouTubeVideo;

if (class_exists('Block')) {

    /**
     * Class RecentVideosBlock
     * @package Dynamic\YouTubeIntegration\DataObject
     *
     * @property int $Limit
     * @property int $VideoPageID
     * @method YouTubeIntegrationVideosPage $VideoPage
     */
    class RecentVideosBlock extends Block
    {
        /**
         * @var string
         */
        private static $singular_name = 'Recent Videos Block';

        /**
         * @var string
         */
        private static $plural_name = 'Recent Videos Blocks';

        /**
         * @var array
         */
        private static $db = array(
            'Limit' => 'Int',
        );

        /**
         * @var array
         */
        private static $has_one = array(
            'VideoPage' => 'YouTubeIntegrationVideosPage',
        );

        /**
         * @var array
         */
        private static $defaults = array(
            'Limit' => 3,
        );

        /**
         * @var
         */
        private $recent_videos;

        /**
         * @return FieldList
         */
        public function getCMSFields()
        {
            $fields = singleton('Block')->getCMSFields();

            $fields->addFieldsToTab('Root.Main', array(
                \NumericField::create('Limit'),
            ));

            $fields->addFieldToTab(
                'Root.Main',
                \DropdownField::create('VideoPageID', 'Featured Video Page', YouTubeIntegrationVideosPage::get()->map())
                    ->setEmptyString('')
            );

            return $fields;
        }

        /**
         * @return mixed
         */
        public function getRecentVideos()
        {
            if (!$this->recent_videos) {
                $this->setRecentVideos();
            }
            return $this->recent_videos;
        }

        /**
         * @return $this
         */
        public function setRecentVideos()
        {
            $this->recent_videos = ($this->VideoPageID != 0)
                ? $this->VideoPage()->getVideosList()->limit($this->Limit)
                : YouTubeVideo::get()->limit($this->Limit);
            return $this;
        }
    }
}