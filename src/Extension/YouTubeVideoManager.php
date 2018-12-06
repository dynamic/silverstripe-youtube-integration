<?php

namespace Dynamic\YouTubeIntegration\Extension;

use Dynamic\YouTubeIntegration\Model\YouTubeVideo;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class YouTubeVideoManager
 *
 * @method Videos[]|ManyManyList $Videos
 */
class YouTubeVideoManager extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = [
        'Videos' => YouTubeVideo::class,
    ];

    /**
     * @var array
     */
    private static $many_many_extraFields = [
        'Videos' => [
            'Sort' => 'Int',
        ],
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Videos.Count' => 'Videos in playlist',
    ];

    /**
     * @var
     */
    private $videos;

    /**
     * Update cms fields for the owner object to include video management fields
     *
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if (!$this->owner->ID) {
            $fields->removeByName('Videos');
        } else {
            $config = GridFieldConfig_RelationEditor::create();
            $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
            $config->addComponent(new GridFieldAddExistingSearchButton());
            $config->addComponent(new GridFieldOrderableRows());

            $grid = GridField::create('Videos', 'Videos', $this->owner->Videos()->sort('Sort'), $config);

            if ($fields->dataFieldByName('Videos')) {
                $fields->replaceField('Videos', $grid);
            } else {
                $fields->addFieldToTab('Root.Videos', $grid);
            }
        }
    }

    /**
     * @return $this
     */
    public function setVideosList()
    {
        $this->videos = $this->owner->Videos()->sort('Sort');

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVideosList()
    {
        if (!$this->videos) {
            $this->setVideosList();
        }

        return $this->videos;
    }
}
