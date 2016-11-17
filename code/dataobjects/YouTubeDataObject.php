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
     * @var null
     */
    private $youtube_data_type = null;

    /**
     * @var null
     */
    private $youtube_data = null;

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

    /**
     * Log or trigger an error based on environment
     *
     * @param $message
     */
    protected function logError($message)
    {
        if (Director::isLive()) {
            SS_Log::log($message, SS_Log::ERR);
        } else {
            trigger_error($message, E_USER_ERROR);
        }
    }

    /**
     * Attempt to get the YouTube data based on api key/val pairs.
     *
     * @param $key
     * @return null|bool
     */
    public function DataValue($key = null)
    {
        if ($key === null) {
            $this->logError("Video {$this->Title} is fetching null data. You must pass a string for a variable.");
            return null;
        }
        $dataArray = static::data_to_array($this->getYouTubeData());
        $keys = explode('.', $key);
        for ($i = 0; $i < count($keys); $i++) {
            if (isset($data)) {
                if (isset($data[$keys[$i]])) {
                    $data = $data[$keys[$i]];
                }
            } else {
                if (isset($dataArray[$keys[$i]])) {
                    $data = $dataArray[$keys[$i]];
                }
            }
        }

        if (!isset($data)) {
            $this->logError("Video {$this->Title} can't fetch data from YouTube");
            $data = false;
        }

        return $this->formatData($data);
    }

    /**
     * Format data passed in. Attempts to format whole numbers.
     *
     * @param $data
     * @return null|string
     */
    protected function formatData($data)
    {
        $isInt = ($data == preg_replace('/[^0-9]/', '', $data)) ? $data : false;
        if ((array)$data === $data) {
            return null;
        } elseif ($isInt) {
            return number_format($data);
        } elseif ((bool)$data === $data) {
            return $data;
        } else {
            return $data;
        }
    }

    /**
     * Return YouTube data array
     *
     * @return array
     */
    public function getYouTubeData()
    {
        return [];
    }

    /**
     * Convert stdClass data structure to an associative array.
     *
     * @param $data
     * @return array
     */
    protected static function data_to_array($data)
    {
        return json_decode(json_encode($data), true);
    }

}