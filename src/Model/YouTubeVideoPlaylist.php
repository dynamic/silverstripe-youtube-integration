<?php

namespace Dynamic\YouTubeIntegration\Model;

use SilverStripe\ORM\DataObject;

/**
 * Class YouTubeVideoPlaylist
 *
 * @property string $Title
 * @method ManyManyList $Videos
 */
class YouTubeVideoPlaylist extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'YouTube Video Playlist';

    /**
     * @var string
     */
    private static $plural_name = 'YouTube Video Playlists';

    /**
     * @var string
     */
    private static $description = 'Playlist built in SilverStripe comprised of individual YouTube videos. 
        (Not a YouTube Playlist)';

    /**
     * @var string
     */
    private static $table_name = 'YouTubeVideoPlaylist';

    /**
     * @var array
     */
    private static $db = [
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Title' => 'Title',
    ];

    /**
     * Validate that all requirements are met before writing to the database
     *
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->error('A Title is required');
        }

        return $result;
    }
}
