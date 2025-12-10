<?php

namespace Antlion\ElementTab\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Antlion\ElementTab\Models\TabPanel;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * @property string $Content
 *
 * @method \SilverStripe\ORM\HasManyList Panels()
 */
class ElementTab extends BaseElement
{
    
    private static $icon = 'font-icon-block-tabs';

   
    private static $table_name = 'ElementTab';

    private static $db = [
        'Content' => 'HTMLText',
    ];

    private static $has_many = array(
        'Panels' => TabPanel::class,
    );

    private static $owns = [
        'Panels',
    ];

    private static $inline_editable = false;

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Content'] = _t(__CLASS__.'.ContentLabel', 'Intro');
        $labels['Panels'] = _t(__CLASS__ . '.PanelsLabel', 'Panels');

        return $labels;
    }

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            /* @var FieldList $fields */
            $fields->removeByName(array(
                'Sort',
            ));

            $fields->dataFieldByName('Content')
                ->setDescription(_t(
                    __CLASS__.'.ContentDescription',
                    'optional. Add introductory copy to your tabs element.'
                ))
                ->setRows(5);

            if ($this->ID) {
                /** @var GridField $panels */
                $panels = $fields->dataFieldByName('Panels');
                $panels->setTitle($this->fieldLabel('Panels'));

                $fields->removeByName('Panels');

                $config = $panels->getConfig();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                $config->removeComponentsByType(GridFieldDeleteAction::class);

                $fields->addFieldToTab('Root.Main', $panels);
            }
        });

        return parent::getCMSFields();
    }

    public function getSummary()
    {
        $count = $this->Panels()->count();
        $label = _t(
            TabPanel::class . '.PLURALS',
            '{count} tabs element Panel|{count} tabs element Panels',
            [ 'count' => $count ]
        );
        return DBField::create_field('HTMLText', $label)->Summary(20);
    }

    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'Tabs');
    }
}
