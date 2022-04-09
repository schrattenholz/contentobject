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
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use SilverStripe\Security\Permission;
use SilverStripe\Versioned\Versioned;
use Schrattenholz\TemplateConfig\ColorSet;

class SeveralCols extends ContentObject{
	private static $table_name="CO_SeveralCols";
	private static $db=array(
	);
	private static $singular_name ="2-Spaltig";
	private static $plural_name = "2-Spaltig"; 
	private static $extensions = [
        Versioned::class,
    ];
	private static $has_many=[
		'ContentObjects'=>ContentObject::class
	
	];
	private static $has_one=array(
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
		$fields->addFieldToTab('Root.Main',new TextField('Title','Titel'),'ShowTitle');
		$fields->addFieldToTab('Root.Main',new CheckboxField('ShowTitle','Überschrift anzeigen'));
		$fields->addFieldToTab('Root.Main', new CheckboxField('Background','Hintergrund anzeigen'));
		$fields->addFieldToTab('Root.Main',new DropdownField('ColorSetID','Farbschema wählen',ColorSet::get()->map("ID", "Title", "Bitte auswählen")));

		$fields->removeFieldFromTab('Root.Main','SortID');


		$gridFieldConfig=GridFieldConfig::create()
			->addComponent(new GridFieldButtonRow('before'))
			->addComponent(new GridFieldDataColumns)
			//->addComponent(new GridFieldDeleteAction())
			->addComponent(new GridFieldEditButton())
			->addComponent(new GridFieldDetailForm())
			->addComponent(new GridFieldSortableHeader())
			->addComponent(new GridFieldFilterHeader())
			->addComponent(new GridFieldPaginator())
			->addComponent(new GridFieldOrderableRows('SortID'))
		;
		 $multiClassConfig = new GridFieldAddNewMultiClass();
        $multiClassConfig->setClasses(
            array(
                'Schrattenholz\ContentObject\CO_HTMLText',
				'Schrattenholz\ContentObject\CO_Infobox',
				'Schrattenholz\ContentObject\CO_Gallery'
				
            )
        );
		$gridFieldConfig->addComponent($multiClassConfig);
		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		$fields->addFieldToTab('Root.Main', GridField::create(
			'ContentObjects',
			'Inhalte',
			$this->owner->ContentObjects(),
			$gridFieldConfig
		));
		
		$fields->removeFieldFromTab('Root.Main','Spacer');
		$fields->removeFieldFromTab('Root.Main','PageID');
		$fields->removeFieldFromTab('Root.Main','Live');
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
		if (!$this->SortID) {
			$this->SortID = SeveralCols::get()->where('PageID='.$this->PageID)->max('SortID') + 1;
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