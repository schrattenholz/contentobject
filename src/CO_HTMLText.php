<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class CO_HTMLText extends ContentObject{
	private static $table_name="co_htmltext";
	private static $db=array(
		'Content'=>'HTMLText'
	);
	public function getCMSFields(){
		$fields=parent::getCMSFields();
				$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content','Inhalt'));
		return $fields;
	}
	// Get content for internal search and searchengines
	public function getContents(){
		return $this->Content;
	}
	public function renderIt(){
		return false;
	}
	private static $singular_name ="Textelement";
	private static $plural_name = "Textelemente"; 
}