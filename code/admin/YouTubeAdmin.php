<?php

namespace Dynamic\YouTubeIntegration\Admin;

/**
 * Class YouTubeAdmin
 * @package Dynamic\YouTubeIntegration\Admin
 */
class YouTubeAdmin extends \ModelAdmin
{

    /**
     * Models managed by this ModelAdmin
     *
     * @var array
     */
    private static $managed_models = [
        'Dynamic\YouTubeIntegration\DataObject\YouTubeVideo' => [
            'title' => 'YouTube Videos',
        ],
        'Dynamic\YouTubeIntegration\DataObject\YouTubePlaylist' => [
            'title' => 'YouTube Playlists',
        ],
        'Dynamic\YouTubeIntegration\DataObject\YouTubeVideoPlaylist' => [
            'title' => 'Custom YouTube Video Playlists',
        ]
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