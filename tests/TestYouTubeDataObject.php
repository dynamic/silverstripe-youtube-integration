<?php

namespace Dynamic\YouTubeIntegration\Tests;

use Dynamic\YouTubeIntegration\Model\YouTubeDataObject;

/**
 * Class TestYouTubeDataObject
 */
class TestYouTubeDataObject extends YouTubeDataObject implements TestOnly
{
    /**
     * @var array
     */
    private static $db = [
        'test' => 'Boolean',
    ];

    /**
     * @var string
     */
    private static $table_name = "Test_TestYouTubeDataObject";
}
