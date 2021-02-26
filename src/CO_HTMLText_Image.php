<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use Silverstripe\Assets\Image;

class CO_HTMLText_Image extends CO_HTMLText{
	private static $table_name="co_htmltextimage";
	private static $db=array(
		'Content'=>'HTMLText',
		'OuterBlock'=>'Boolean',
		"SubHead"=>"Varchar(255)"
	);
	private static $has_one=[
		'Image'=>Image::class
	];
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',new UploadField('Image','Bild'));
		return $fields;
	}
	private static $owns = [
		'Image'
	];
	private static $singular_name ="HTML und Bild";
	private static $plural_name = "HTML-Textelemente"; 
	
}

?>