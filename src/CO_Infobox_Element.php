<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLTextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverWare\FontIcons\ORM\FieldType\DBFontIcon;
use SilverWare\FontIcons\Forms\FontIconField;
use Schrattenholz\TemplateConfig\ColorSet;
class CO_Infobox_Element extends DataObject{
	private static $table_name="CO_Infobox_Element";
	private static $db=array(
		"Content"=>"HTMLText",
		"Title"=>"Text",
		"SortID"=>"Int",
		"AfterStaticElements"=>"Boolean"
	);
	private static $has_one=[
		"Infobox"=>CO_Infobox::class,
		'ColorSet'=>ColorSet::class
	];
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',TextField::create('Title', "Titel"));
		$fields->addFieldToTab('Root.Main',CheckboxField::create('AfterStaticElements', "Nach den automatischen Elementen anzeigen"));
		$fields->addFieldToTab('Root.Main',new DropdownField('ColorSetID','Farbschema wählen',ColorSet::get()->map("ID", "Title", "Bitte auswählen")));
		$fields->addFieldToTab('Root.Main',HTMLEditorField::create('Content', "Inhalt"));
		return $fields;
	}
	public function onBeforeWrite(){
		//HTML-List Icons in <i> umwandeln
		$this->SetField('Content',$this->setAddIconToList($this->getField('Content')));
		parent::onBeforeWrite();
	}
	// Get content for internal search and searchengines
	public function getContents(){
		return $this->Content;
	}
	public function setAddIconToList($text){
		//HTML-List Icons in <i> umwandeln
		$needle='~<i class=\"fa-li fa fa-square\"></i>~';
		$yoursuffix="";
		$newtext=preg_replace($needle,"\${1}".$yoursuffix,$text);
		
		
		$needle="#(<li[^>]*>)#s";
		$yoursuffix='<i class="fa-li fa fa-square"></i>';
		$newtext=preg_replace($needle,"\${1}".$yoursuffix,$newtext);
		return $newtext;
	}
	private static $singular_name ="Infobox Element";
	private static $plural_name = "Infobox Elemente"; 
}