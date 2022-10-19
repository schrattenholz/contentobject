<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use Silverstripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
class CO_HTMLText_Image extends CO_HTMLText{
	private static $table_name="co_htmltextimage";
	private static $db=array(
		'Content'=>'HTMLText',
		'Content2'=>'HTMLText',
		"SubHead"=>"Varchar(255)",
		"ImageLeft"=>"Boolean"
	);
	private static $has_one=[
		'Image'=>Image::class
	];
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',new CheckboxField('ImageLeft','Bild auf der linken Seite'),'Content');
		$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content2','Zweite Textspalte anstatt Bild'),'Content');
		$fields->addFieldToTab('Root.Main',new UploadField('Image','Bild'));
		return $fields;
	}
	private static $owns = [
		'Image'
	];
	private static $singular_name ="Text und Bild";
	private static $plural_name = "HTML-Textelemente"; 
	
}

?>