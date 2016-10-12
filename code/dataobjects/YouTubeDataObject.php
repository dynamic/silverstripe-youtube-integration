<?php

use Madcoda\Youtube;

/**
 * Class YouTubeDataObject
 */
class YouTubeDataObject extends DataObject
{

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'YouTubeURL' => 'Varchar(255)',
    ];

    /**
     * @var
     */
    private $youtube_client;

    /**
     * Get reusable YouTube API Client
     *
     * @return mixed
     */
    public function getYouTubeClient()
    {
        if (!$this->youtube_client) {
            $this->setYouTubeClient();
        }
        return $this->youtube_client;
    }

    /**
     * Set reusable YouTube API Client
     *
     * @return $this
     */
    public function setYouTubeClient()
    {
        $this->youtube_client = new YouTube(['key' => Config::inst()->get('YouTubeDataObject', 'youtube_api_key')]);
        return $this;
    }


}