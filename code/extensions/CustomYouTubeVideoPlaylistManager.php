<?php

namespace Dynamic\YouTubeIntegration\DataExtension;

/**
 * Class CustomYouTubeVideoPlaylistManager
 * @package Dynamic\YouTubeIntegration\DataExtension
 *
 * @method CustomPlaylists[]|ManyManyList $CustomPlaylists
 */
class CustomYouTubeVideoPlaylistManager extends \DataExtension
{

    /**
     * @var array
     */
    private static $many_many = [
        'CustomPlaylists' => 'YouTubeVideoPlaylist',
    ];

    /**
     * @var array
     */
    private static $many_many_extraFields = [
        'CustomPlaylists' => [
            'Sort' => 'Int',
        ],
    ];

    /**
     * @var
     */
    private $playlists;

    /**
     * @param \FieldList $fields
     */
    public function updateCMSFields(\FieldList $fields)
    {

        if (!$this->owner->ID) {
            $fields->removeByName('CustomPlaylists');
        } else {
            $config = \GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->addComponent(new \GridFieldAddExistingSearchButton());
            $config->addComponent(new \GridFieldOrderableRows());

            $grid = \GridField::create('CustomPlaylists', 'Custom Playlists', $this->owner->CustomPlaylists()->sort('Sort'), $config);

            if ($fields->dataFieldByName('CustomPlaylists')) {
                $fields->replaceField('CustomPlaylists', $grid);
            } else {
                $fields->addFieldToTab('Root.CustomPlaylists', $grid);
            }
        }

    }

    /**
     * @return mixed
     */
    public function getCustomPlaylistSet()
    {
        if (!$this->playlists) {
            $this->setCustomPlaylistSet();
        }
        return $this->playlists;
    }

    /**
     * @return $this
     */
    public function setCustomPlaylistSet()
    {
        $this->playlists = $this->owner->CustomPlaylists()->sort('Sort');
        return $this;
    }

}