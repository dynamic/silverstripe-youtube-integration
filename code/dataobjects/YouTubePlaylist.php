<?php

/**
 * Class YouTubePlaylist
 *
 * @property string $Title
 * @property string $YouTubeURL
 * @property string $PlaylistID
 */
class YouTubePlaylist extends YouTubeDataObject
{

    /**
     * @var string
     */
    private static $singular_name = 'YouTube Playlist';
    /**
     * @var string
     */
    private static $plural_name = 'YouTube Playlists';
    /**
     * @var string
     */
    private static $description = 'A playlist of videos hosted and managed on YouTube';

    /**
     * @var array
     */
    private static $db = [
        'PlaylistID' => 'Varchar(255)',
    ];

    /**
     * @var
     */
    private $playlist_data;

    /**
     * @var
     */
    private $videos;

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $value = ($this->PlaylistID) ? $this->PlaylistID : 'Playlist ID not avalaible at this time';
        $fields->replaceField('PlaylistID', ReadonlyField::create('PlaylistID')->setValue($value));

        return $fields;
    }

    /**
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->YouTubeURL) {
            $result->error('A Playlist URL is required');
        }

        if (!$this->extractPlaylistID($this->YouTubeURL)) {
            $result->error('The Playlist URL supplied doesn\'t seem to match the YouTube playlist url pattern.');
        }

        return $result;
    }

    /**
     *  Before writing the record, save the playlist ID for easier access later.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $this->PlaylistID = $this->extractPlaylistID($this->YouTubeURL);
    }

    /**
     * Return the playlist ID if the supplied url has a matching pattern {@link https://linuxpanda.wordpress.com/2013/07/24/ultimate-best-regex-pattern-to-get-grab-parse-youtube-video-id-from-any-youtube-link-url/}
     *
     * @param string $url
     * @return bool
     */
    protected function extractPlaylistID($url = '')
    {
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $variables);
        return isset($variables['list']) ? $variables['list'] : false;
    }

    /**
     * Return Playlist Embed code via a SilverStripe include
     *
     * @return HTMLText
     */
    public function getEmbedCode()
    {
        return $this->customise([
            'PlaylistID' => $this->PlaylistID,
        ])->renderWith('PlaylistEmbedCode');
    }

    /**
     * Return YouTube data for this playlist
     *
     * @return mixed
     */
    public function getPlaylistData()
    {
        if (!$this->playlist_data) {
            $this->setPlaylistData();
        }
        return $this->playlist_data;
    }

    /**
     * Set YouTube data for this playlist
     *
     * @return $this
     */
    public function setPlaylistData()
    {
        $youtubeClient = $this->getYouTubeClient();
        $this->playlist_data = $youtubeClient->getPlaylistById($this->PlaylistID);
        return $this;
    }

    /**
     * Get videos' data within this playlist
     *
     * @return
     */
    public function getVideos()
    {
        if (!$this->videos) {
            $this->setVideos();
        }
        return $this->videos;
    }

    /**
     * Set videos' data within this playlist
     *
     * @return $this
     */
    public function setVideos()
    {
        $this->videos = $this->getYouTubeClient()->getPlaylistItemsByPlaylistId($this->PlaylistID);
        return $this;
    }

}