<?php

namespace Schrattenholz\ContentObject;



use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TreeDropdownField;
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
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\ArrayList;	
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;
use SilverStripe\Forms\TreeMultiselectField;
class CO_TeaserSection extends ContentObject{
	private static $table_name="co_teasersection";
	private static $db=array(
		"LimitOfEntries"=>"Int",
		"Content"=>'HTMLText',
		"ButtonTitle"=>"Varchar(255)",
		"HasButton"=>"Boolean",
		"ButtonAnchor"=>"Varchar(255)",
		"UseAutoData"=>"Boolean",
		"ShowTitle"=>"Boolean"
	);
    private static $translate = [
        'Heading',
        'Description',
		'Title',
		'Content',
		'ButtonTitle'
    ];
	private static $defaults = array('ButtonTitle' => "Mehr lesen...");
	private static $has_one=array(
		'Category'=>SiteTree::class,
		'ButtonLink'=>SiteTree::class,
		'Layout'=>CO_TeaserSection_Layout::class,
		'MainImage'=>Image::class
	);
	private static $has_many=array(
		'CO_TeaserSection_Boxes'=>CO_TeaserSection_Box::class
	);
	private static $many_many=array(
		'Pages'=>SiteTree::class
	);
	private static $singular_name ="Teaser Element";
	private static $plural_name = "CO_TeaserSection Boxen"; 
	public function provideI18nEntities() {
 
        $entities = parent::provideI18nEntities();
 
        $namespace = $this->ClassName;
 
        // get the original Enum values as a simple array
        $colorArray = $this->dbObject('Layout')->getEnum();
 
        foreach($colorArray as $color) {
            $entities["{$namespace}.{$color}"] = array($color);
        }
		
        return $entities;
		
    }
	public function getContents(){
		return $this->Content;
	}
	public function  getCMSFields(){
		$fields=parent::getCMSFields();

		$fields->removeByName("CO_TeaserSection_Boxes");
		$layout=DropdownField::create('LayoutID',_t('CO_TeaserSection.Layout','Layout'),CO_TeaserSection_Layout::get()->map('ID', 'Title'));
		$layout->setEmptyString('(Bitte Layout wählen)');
		$fields->addFieldToTab('Root.Main',$layout);
		$fields->addFieldToTab('Root.Main',new CheckboxField('ShowTitle','Überschrift anzeigen'),'Content');
		$fields->addFieldToTab('Root.Main',new CheckboxField('HasButton','Button anzeigen'));
		$fields->addFieldToTab('Root.Main',new TreeDropdownField('ButtonLinkID','Button-Link',SiteTree::class));
		$fields->addFieldToTab('Root.Main',new TextField('ButtonTitle','Button-Beschriftung'),'ButtonLinkID');		
		$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content','Inhalt oberhalb der Teaserboxen'));
		$fields->addFieldToTab('Root.Main',new TextField('ButtonAnchor','Anker zu einem Abschnitt auf der ausgewählten Seite (Button-Link)'));	
		$fields->addFieldToTab('Root.Main',new UploadField('MainImage','Hauptbild (Nicht in allen Layouts verfügbar)'));	
		$fields->addFieldToTab('Root.Automatisierte Daten',new NumericField('LimitOfEntries','Anzahl anzuzeigende Beiträge'));
		$fields->addFieldToTab('Root.Automatisierte Daten',new TreeDropdownField('CategoryID','Teaser-Kategorie',SiteTree::class));
		$fields->addFieldToTab('Root.Automatisierte Daten',new CheckboxField('UseAutoData','Automatisierte Daten einbinden?'),"LimitOfEntries");
		$fields->addFieldToTab('Root.Automatisierte Daten', new TreeMultiselectField('Pages','Einzelne Seiten, die auch angezeigt werden sollen',SiteTree::class));

		/* Wenn Layoutauswahl möglich
		
		$fields->addFieldToTab('Root.Main',new LiteralField("LayoutInfo","<ul>
		<li><strong>RE_PropertiesSlider01:</strong> Anzeige von Immo-Objekten mit Bild und Infos am unteren Rand</li>
		<li><strong>RE_Features:</strong> Anzeige von Text und Icon + 'Mehr lesen'-Button</li>
		<li><strong>RE_PropertyGallery:</strong> Anzeige von Bild + Text bei Rollover</li>
		<li><strong>RE_Bg_Link:</strong> Anzeige von Bild + Text</li>
		</ul>"));
		*/
		// Content Onjects ----------------------------------------------------------//
		$gridFieldConfig = GridFieldConfig_RelationEditor::create();
		$dataColumns = $gridFieldConfig->getComponentByType(GridFieldDataColumns::class);

        $dataColumns->setDisplayFields([
            'Title' => 'Bezeichnung',
			'Image.CMSThumbnail'=>'Bild'
        ]);
		$contentObjects = new GridField("CO_TeaserSection_Boxes", "Inhaltsblöcke", $this->CO_TeaserSection_Boxes(), $gridFieldConfig);

		//$fields->removeFieldFromTab('Root.Main','ContentObject');
		if ($this->isInDB()) {    
			$fields->addFieldToTab('Root.Manuelle Daten', $contentObjects);
		}else{
			$fields->addFieldToTab('Root.Manuelle Daten', new LiteralField("md","Um manuelle Daten hinzuzufügen muss der Eintrag zuvor gespeichert werden"));
		}
		//$fields->addFieldToTab('Root.Main', $spacer,'Metadata');
		// END Content Onjects -------------------------------------------------------//
		return $fields;
	}
	public function LimitedEntries(){
		$list=new ArrayList();
		$sortID=0;
		

		if($this->UseAutoData){
			//alle Dokumente aus einer Kategorie holen
			if($this->CategoryID){
				foreach($this->Category()->AllChildren()->sort("Date","DESC")->limit($this->LimitOfEntries) as $c){
					$c->SortID=$sortID+1;
					$list->push($c);
				}
			}
			// einzelne Seite holen
			foreach($this->Pages()->sort("Date","DESC") as $c){
				$c->SortID=$sortID+1;
				$c->DeepLink=$c->Link();
				$list->push($c);
			}
		}
		//manuelle Daten hinzufuegen
		foreach($this->CO_TeaserSection_Boxes()->sort('SortID') as $c){
			$list->push($c);
			$sortID=$c->SortID;
		}
		// manuelle Daten Ende
		$updatedList=new ArrayList();
		$dur=250;
		$c=1;
		foreach($list as $item){
			$item->Duration=$dur*$c;
			if(!$item->DeepLink){
			$item->DeepLink=$item;
			}
			$updatedList->push($item);
			$c++;
		}
		return $list;
	}
		public function renderLayout(){
			return $this->getOwner()->renderWith(ThemeResourceLoader::inst()->findTemplate(
				$this->Layout()->Src,
				SSViewer::config()->uninherited('themes')
			));
			//return $this->renderWith($this->Layout->Src);
		}
}