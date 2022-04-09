<?php
namespace Schrattenholz\ContentObject;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditorField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Security\Permission;
use Silverstripe\Assets\Image;
use Silverstripe\Assets\File;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Versioned\Versioned;
use Schrattenholz\TemplateConfig\ColorSet;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Core\Injector\Injector;
use Psr\Log\LoggerInterface;
class CO_TeaserSection_Box extends DataObject{
	private static $table_name="co_teasersection_box";
	private static $db=array(
		'Title'=>'Text',
		'SortID'=>'Int',
		'ReadMore'=>'Varchar(100)',
		'Content'=>'HTMLText'
		
	);
    private static $translate = [
        'Title',
		'ReadMore'
    ];
	private static $defaults = array('ReadMore' => "Mehr lesen...");
	private static $has_one=array(
		'CO_TeaserSection'=>CO_TeaserSection::class,
		'DeepLink'=>SiteTree::class,
		'Image'=>Image::class,
		'Video'=>File::class,
		'ColorSet'=>ColorSet::class
	);
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',new TextField("Title","Bezeichnung"));
		$fields->addFieldToTab('Root.Main',new TextField('ReadMore','Beschriftung'));
		$fields->addFieldToTab('Root.Main',new HTMLEditorField('Content','Inhalt (wird nicht in jedem Layout unterstützt.'));
		if(ColorSet::get()){
			$fields->addFieldToTab('Root.Main',new DropdownField('ColorSetID','Farbschema wählen',ColorSet::get()->map("ID", "Title", "Bitte auswählen")));
		}
		$fields->addFieldToTab('Root.Main',new UploadField('Image','Bild'));
		$fields->addFieldToTab('Root.Main',new UploadField('Video','Video (Bild wird das Startbild des Video)'));
		$fields->removeFieldFromTab('Root.Main','CO_TeaserSectionID');
		$fields->removeFieldFromTab('Root.Main','SortID');
		return $fields;
	}

	public function DefaultImage(){
		if($this->ImageID==0 && $this->DeepLink()){
			return $this->DeepLink()->DefaultImage();
		}else{
			return $this->Image();
		}
	}
	public function TeaserText(){
		if(isset($this->TeaserText)){
			return $this->TeaserText;
		}else{
			return $this->ReadMore;
		}
	}
	public function onBeforeWrite(){
		if(!$this->Title && $this->DeepLink()){
			$this->Title=$this->DeepLink()->Title;
		}
		parent::onBeforeWrite();
	}
	private static $owns=[
		'Image',
	];
	public function Content(){
		return false;
	}
	public function renderIt(){
		return $this->renderWith($this->ClassName);	
	}
		public function MenuTitle(){			return $this->Title;		}
		

}