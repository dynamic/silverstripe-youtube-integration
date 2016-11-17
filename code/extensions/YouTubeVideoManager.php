<?php

class YouTubeVideoManager extends DataExtension
{

    /**
     * @var array
     */
    private static $many_many = [
        'Videos' => 'SilverStripeYouTubeVideo',
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
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
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