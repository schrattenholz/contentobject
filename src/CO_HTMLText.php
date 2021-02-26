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
		'Content'=>'HTMLText',
		'OuterBlock'=>'Boolean'
	);
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',new CheckboxField('OuterBlock','Bis zum Browserrand farbig anzeigen'),'Background');
		$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content','Inhalt'));
		return $fields;
	}
	public function onBeforeWrite(){
		$this->SetField('Content',$this->setAddIconToList($this->getField('Content')));
		parent::onBeforeWrite();
	}
	// Get content for internal search and searchengines
	public function getContents(){
		return $this->Content;
	}
	public function setAddIconToList($text){
		//Remove <i>
		$needle='~<i class=\"fa-li fa fa-square\"></i>~';
		$yoursuffix="";
		$newtext=preg_replace($needle,"\${1}".$yoursuffix,$text);
		
		
		$needle="#(<li[^>]*>)#s";
		$yoursuffix='<i class="fa-li fa fa-square"></i>';
		$newtext=preg_replace($needle,"\${1}".$yoursuffix,$newtext);
		return $newtext;
	}
	private static $singular_name ="HTML-Textelement";
	private static $plural_name = "HTML-Textelemente"; 
}