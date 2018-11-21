<?php

namespace Dynamic\YouTubeIntegration\Model;

use SilverStripe\Forms\ReadonlyField;
use Dynamic\YouTubeIntegration\Page\VideosPage;

/**
 * Class YouTubeVideo
 *
 * @property string $Title
 * @property string $YouTubeURL
 * @property string $VideoID
 */
class YouTubeVideo extends YouTubeDataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'YouTube Video';

    /**
     * @var string
     */
    private static $plural_name = 'YouTube Videos';

    /**
     * @var string
     */
    private static $description = 'A video from YouTube. The video can be a single video, or a video from a playlist.';

    /**
     * @var string
     */
    private static $table_name = 'YouTubeVideo';

    /**
     * @var array
     */
    private static $db = [
        'VideoID' => 'Varchar(11)',
    ];

    /**
     * @var array
     */
    private static $belongs_many_many = [
        'Playlists' => YouTubeVideoPlaylist::class,
        'VideoPages' => VideosPage::class,
    ];

    /**
     * @var array
     */
    private static $casting = [
        'Likes' => 'Int',
    ];

    /**
     * @var int
     */
    private $likes;

    /**
     * @var
     */
    private $video_data;

    /**
     * @var int|bool
     */
    private $views;

    /**
     * @var array
     */
    private static $indexes = [
        'youtube-integration-video' => [
            'type' => 'unique',
            'columns' => ['VideoID'],
        ],
    ];

    /**
     * @var array
     */
    public static $allowed_actions = [
        'VideoDataValue',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $value = $this->VideoID ? $this->VideoID : 'Video ID not available';
        $fields->replaceField('VideoID', ReadonlyField::create('VideoID')->setValue($value));

        $fields->removeByName([
            'Playlists',
            'VideoPages',
        ]);

        $this->extend('updateCMSFields', $fields);

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->YouTubeURL) {
            $result->addFieldMessage('YouTubeURL', 'A Video URL is required');
        }

        if (!$id = $this->extractVideoID($this->YouTubeURL)) {
            $result->addFieldMessage(
                'YouTubeURL',
                'The Video URL supplied doesn\'t seem to match the YouTube video url pattern.'
            );
        }

        if ($video = YouTubeVideo::get()->filter('VideoID', $id)->exclude('ID', $this->ID)->first()) {
            $videoLink = "/admin/youtube-admin/SilverStripeYouTubeVideo/EditForm/field/SilverStripeYouTubeVideo/item/{$video->ID}/edit";

            $result->addFieldMessage(
                'YouTubeURL',
                "A video with that YouTube ID already exists. <a href='{$videoLink}'>{$video->Title}</a>"
            );
        }

        if (!$this->getYouTubeClient()->getVideoInfo($id)) {
            $result->addError('The video cannot be processed from YouTube');
        }

        return $result;
    }

    /**
     *  Before writing the record, save the video ID for easier access later.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $this->VideoID = $this->extractVideoID($this->YouTubeURL);
    }

    /**
     * Check provided url for known YouTube url pattern. {@link https://ctrlq.org/code/19797-regex-youtube-id}
     *
     * @param string $url
     * @return string|bool
     */
    protected function extractVideoID($url = '')
    {
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $variables);

        return isset($variables['v']) ? $variables['v'] : false;
    }

    /**
     * Return total like count for this video from YouTube
     *
     * @return int
     */
    public function getLikes()
    {
        if (!$this->likes) {
            $this->setLikes();
        }

        return $this->likes;
    }

    /**
     * Set total like count for this video from YouTube
     *
     * @return $this
     */
    public function setLikes()
    {
        $this->likes = $this->DataValue('statistics.likeCount');

        return $this;
    }

    /**
     * Return Video Embed code via a SilverStripe include
     *
     * @return HTMLText
     */
    public function getEmbedCode()
    {
        return $this->customise([
            'VideoID' => $this->VideoID,
        ])->renderWith('EmbedCode');
    }

    /**
     * Video preview, the base embed provided by the YouTube API
     *
     * @return mixed
     */
    public function getVideoCMSPreview()
    {
        return $this->DataValue('player.embedHtml');
    }

    /**
     * Set YouTube video data
     *
     * @return $this
     */
    public function setYouTubeData()
    {
        $data = parent::getYouTubeData();
        
        $this->video_data = array_merge(
            static::data_to_array($this->getYouTubeClient()->getVideoInfo($this->VideoID)),
            $data
        );

        return $this;
    }

    /**
     * Return this video's YouTube data
     *
     * @return mixed
     */
    public function getYouTubeData()
    {
        if (!$this->video_data) {
            $this->setYouTubeData();
        }

        return $this->video_data;
    }

    /**
     * Return this video's View count
     *
     * @return bool|int
     */
    public function getViews()
    {
        if (!$this->views) {
            $this->setViews();
        }

        return $this->views;
    }

    /**
     * Set this video's View count
     *
     * @return $this
     */
    public function setViews()
    {
        $this->views = $this->DataValue('statistics.viewCount');

        return $this;
    }
}
