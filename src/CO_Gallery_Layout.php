<?php


namespace Schrattenholz\ContentObject;


use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\Image;

use TractorCow\Colorpicker\Color;
use TractorCow\Colorpicker\Forms\ColorField;

class CO_Gallery_Layout extends DataObject{
	private static $table_name="CO_Gallery_Layout";
	private static $db=[
		'Title'=>'Varchar(255)',
		'Description'=>'Text',
		'Src'=>'Text'
	];
	public function getCMSFields(){
		$title=new TextField('Title','Bezeichnung');
		$description=new TextareaField('Description','Beschreibung');
		$layoutPath=new TextField('Src','Pfad zum Template');
		return new FieldList(
			array(
				$title,
				$description,
				$layoutPath
			)
		);
	}
}