<?php

namespace Antlion\ElementTab\Models;

use SilverStripe\ORM\DataObject;
use Antlion\ElementTab\Elements\ElementTab;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;

/**
 * Class TabPanel
 * @package App\Models
 *
 * @property int $Sort
 *
 * @property int TabID
 * @method ElementTab Tab()
 */
class TabPanel extends DataObject
{
    private static $singular_name = 'tab panel';
    private static $plural_name = 'tab panels';
    private static $description = 'A panel for a tab element';
    private static $table_name = 'TabPanel';

    private static $db = [
        'Sort' => 'Int',
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
    ];


    private static $has_one = [
        'Tab' => ElementTab::class,
        'Image' => Image::class,
    ];
    
    private static $has_many = [
        'Links' => Link::class . '.Owner',
    ];
    // Own assets/links so they publish with the element
    private static $owns = [
        'Image',
        'Links',
    ];
   
    private static $defaults = [
        'ShowTitle' => true,
    ];

    private static $default_sort = 'Sort';

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        // We’ll re-add these in our preferred order
        $fields->removeByName(['TabID','Sort','Title','Content','Image','Links']);

        $fields->addFieldsToTab('Root.Main', [
           TextField::create('Title', 'Title')->setMaxLength(255),
           HTMLEditorField::create('Content', 'Content')->setRows(8),
            UploadField::create('Image', 'Image')
                    ->setFolderName('Uploads/Elements/Tabs')
                    ->setAllowedFileCategories('image/supported'),
            MultiLinkField::create('Links', 'Button Links'),
        ]);

        return $fields;
    }
}
