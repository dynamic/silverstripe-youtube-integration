<?php

/**
 * Class YouTubeAdmin
 */
class YouTubeAdmin extends ModelAdmin
{

    /**
     * Models managed by this ModelAdmin
     *
     * @var array
     */
    private static $managed_models = [
        'YouTubeVideo' => [
            'title' => 'YouTube Videos',
        ],
        'YouTubePlaylist' => [
            'title' => 'YouTube Playlists',
        ],
        'YouTubeVideoPlaylist' => [
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