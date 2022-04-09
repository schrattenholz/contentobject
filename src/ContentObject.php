<?php

namespace Schrattenholz\ContentObject;

use Page;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;
use Schrattenholz\TemplateConfig\ColorSet;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\View\ArrayData;
class ContentObject extends DataObject{
	private static $table_name="contentobject";
	private static $db=array(
		'Title'=>'Text',
		'SubTitle'=>'Text',
		'SortID'=>'Int',
		'Spacer'=>'Enum("small,medium,big,none","medium")',
		'ObjectWidth'=>'Enum("small,big,full","full")',
		"HTMLTag"=>"Enum('article,section,aside,none','article')",
		'Background'=>'Boolean',
		'ShowTitle'=>'Boolean(1)',
		'Slot'=>'Text',
		'AnchorID'=>'Varchar(255)'
	);
	private static $extensions = [
        Versioned::class,
    ];
	private static $has_one=array(
		'Page'=>SiteTree::class,
		'ColorSet'=>ColorSet::class,
		'SeveralCols'=>SeveralCols::class
	);
	public function getContents(){
		return false;
	}
	private static $defaults = array('Live' => 1);
	/*static $extensions = array(
		"Versioned('Stage', 'Live')"
	);*/
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		//$fields->addFieldToTab('Root.Main',new DropdownField('Spacer','Abstand zum n&auml;chsten Content-Objekt',singleton('ContentObject')->dbObject('Spacer')->enumValues()));
		$fields->addFieldToTab('Root.Main',new TextField('Title','Überschrift'),'ShowTitle');
		$fields->addFieldToTab('Root.Main',new TextField('SubTitle','Unterüberschrift'),'ShowTitle');
		$fields->addFieldToTab('Root.Main',new TextField('AnchorID','Anker (klein und zusammengeschrieben)'),'ShowTitle');
		$fields->addFieldToTab('Root.Main',new CheckboxField('ShowTitle','Überschrift anzeigen'));
		$fields->addFieldToTab('Root.Main', new CheckboxField('Background','Hintergrund anzeigen'));
		$fields->addFieldToTab('Root.Main',new DropdownField('ColorSetID','Farbschema wählen',ColorSet::get()->map("ID", "Title", "Bitte auswählen")));
		$fields->addFieldToTab('Root.Main',new DropdownField('ObjectWidth','Breite der Komponente',$this->dbObject('ObjectWidth')->enumValues()));
		$fields->removeFieldFromTab('Root.Main','SortID');
		$fields->addFieldToTab('Root.Main',new DropdownField('HTMLTag','Umschließendes HTML-Tag',$this->dbObject('HTMLTag')->enumValues()));


		$fields->removeByName("SeveralCols");
		$fields->removeFieldFromTab('Root.Main','Spacer');
		$fields->removeFieldFromTab('Root.Main','Background');
		$fields->removeFieldFromTab('Root.Main','SeveralColsID');
		$fields->removeFieldFromTab('Root.Main','Slot');
		$fields->removeFieldFromTab('Root.Main','HTMLTag');
		$fields->removeFieldFromTab('Root.Main','PageID');
		$fields->removeFieldFromTab('Root.Main','Live');
		$fields->removeFieldFromTab('Root.Main','ObjectWidth');
		return $fields;
		
	}
	public function getColWidth(){
		if($this->ObjectWidth=="small"){
			
		}else if($this->ObjectWidth=="big"){
			
		}else{
			
		}
		
	}
	public function getCustomTitle(){
		return $this->Title;
	}
	public function renderIt($Pos=1,$ParentID=0){
		$data=new ArrayData();
		$data->Pos=$Pos;
		$data->ParentID=$ParentID;
		return $this->customise($data)->renderWith($this->ClassName);	
	}
	public function FirstLetter(){
		$ar=str_split($this->Title);
		return utf8_encode($ar[0]);		
	}
	public function onBeforeDelete(){
		parent::onBeforeDelete();
	}
	protected function onBeforeWrite() {
		if (!$this->SortID && $this->PageID) {
			$this->SortID = ContentObject::get()->where('PageID='.$this->PageID)->max('SortID') + 1;
		}else if (!$this->SortID && $this->SeveralColsID) {
			$this->SortID = ContentObject::get()->where('SeveralColsID='.$this->SeveralColsID)->max('SortID') + 1;
		}
		parent::onBeforeWrite();
	}

	public function isInDB(){
		if($this->ID!=0){
			return true;
		}else{
			return false;
		}
	}
		public function formattedNumber($val){
		return number_format($val, 2, ',', '.');
	}
}