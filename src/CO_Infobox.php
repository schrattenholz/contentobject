<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class CO_Infobox extends ContentObject{
	private static $table_name="CO_Infobox";
	private static $db=array(
		"ShowOpeningHours"=>"Boolean",
		"ShowAddress"=>"Boolean"
	);
	private static $has_many=[
		"Elements"=>CO_Infobox_Element::class,
	];
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->removeByName('Elements');
		// Content Onjects ----------------------------------------------------------//
		$gridFieldConfig = GridFieldConfig_RelationEditor::create();
		$gridFieldConfig->addComponent(new GridFieldOrderableRows('SortID'));
		$dataColumns = $gridFieldConfig->getComponentByType(GridFieldDataColumns::class);

        $dataColumns->setDisplayFields([
            'Title' => 'Bezeichnung'
        ]);
		$elements = new GridField("Elements", "Inhaltsblöcke", $this->Elements(), $gridFieldConfig);

		//$fields->removeFieldFromTab('Root.Main','ContentObject');
		$fields->addFieldToTab('Root.Elemente', new CheckboxField("ShowOpeningHours",utf8_encode("Öffnungszeiten anzeigen")));
		$fields->addFieldToTab('Root.Elemente', new CheckboxField("ShowAddress","Adresszeile anzeigen"));    
		$fields->addFieldToTab('Root.Elemente', $elements);
		
		//$fields->addFieldToTab('Root.Main', $spacer,'Metadata');
		// END Content Onjects -------------------------------------------------------//
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
	private static $singular_name ="Infobox";
	private static $plural_name = "Infoboxen"; 
}