<?php

namespace Dynamic\YouTubeIntegration\Admin;

use Dynamic\YouTubeIntegration\Model\YouTubePlaylist;
use Dynamic\YouTubeIntegration\Model\YouTubeVideo;
use Dynamic\YouTubeIntegration\Model\YouTubeVideoPlaylist;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class YouTubeAdmin
 * @package Dynamic\YouTubeIntegration\Admin
 */
class YouTubeAdmin extends ModelAdmin
{
    /**
     * Models managed by this ModelAdmin
     *
     * @var array
     */
    private static $managed_models = [
        YouTubeVideo::class => [
            'title' => 'YouTube Videos',
        ],
        YouTubePlaylist::class => [
            'title' => 'YouTube Playlists',
        ],
        YouTubeVideoPlaylist::class => [
            'title' => 'Custom YouTube Video Playlists',
        ],
    ];

    /**
     * @var string
     */
    private static $url_segment = 'youtube-admin';

    /**
     * @var string
     */
    private static $menu_title = 'YouTube Admin';
}
