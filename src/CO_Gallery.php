<?php

namespace Schrattenholz\ContentObject;

use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;

use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ValidationException;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;
use Colymba\BulkUpload\BulkUploader;
use SilverStripe\Core\Injector\Injector;
use Psr\Log\LoggerInterface;
class CO_Gallery extends ContentObject{
	private static $table_name="CO_Gallery";
	private static $singular_name ="Galerie";
	private static $plural_name = "Galerien"; 
	private static $db=[
	"Content"=>"HTMLText"
	];
	private static $has_many=[
		"Images"=>CO_Gallery_Image::class
	];
	private static $has_one=array(
		'Category'=>SiteTree::class,
		'Layout'=>CO_Gallery_Layout::class
	);
	/* 
	Funktion für das ContentObjcect Modul CO_Carousel das AllChildren abfragt. Aber vorher prueft ob Alternative Childdkumente ausgegeben werden sollen.
	Hier sollen die hinterlegten Bilder zurueckgegeben werden 
	*/
	public function hasAllChildernAlternative(){
		return $this->Images();
	}
	public function getCMSFields(){
		
		$fields=parent::getCMSFields();
		$fields->removeByName("Images");
				$layout=DropdownField::create('LayoutID',_t('CO_TeaserSection.Layout','Layout'),CO_Gallery_Layout::get()->map('ID', 'Title'));
		$layout->setEmptyString('(Bitte Layout wählen)');
		$fields->addFieldToTab('Root.Main',new HTMLEditorField("Content","Inhalt vor der Galerie"));
		$fields->addFieldToTab('Root.Main',$layout);
		//GridField
			$gridFieldConfig=GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent($dataColumn=new GridFieldDataColumns())
				->addComponent(new GridFieldToolbarHeader())
				->addComponent(new GridFieldTitleHeader("Bild","Titel","Adult"))
				->addComponent(new GridFieldDetailForm())
				->addComponent($editableColumns=new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldEditButton())
				->addComponent(new GridFieldOrderableRows('SortID'))
				
				//->addComponent(new GridFieldAddNewInlineButton())
				->addComponent($bulkUploader=new \Colymba\BulkUpload\BulkUploader('Image'))
			;
			$editableColumns->setDisplayFields(array(
					'Title' => array(
					'title' => 'Titel',
					'callback' => function($record, $column, $grid) {
						return TextField::create($column);
					})
			));
			$bulkUploader->setAutoPublishDataObject(true);
			$bulkUploader->setUFSetup('setFolderName', 'Uploads/gallery/');
			//$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
			
			//$gridFieldConfig->setFolderName($this->Link());
			//$gridFieldConfig->getComponentByType('GridFieldBulkImageUpload')->setConfig('fieldsClassBlacklist', array('TreeDropdownField'));
			 $dataColumn->setDisplayFields(array(
				   'Thumbnail'=>'Thumbnail'
			));
			$sliderImages = new GridField("Images", "Bilder", $this->Images()->sort('SortID'), $gridFieldConfig);
				$fields->addFieldToTab('Root.Gallerie', $sliderImages);

			
		// END GridField
		return $fields;
	}
	public function renderLayout(){
		return $this->getOwner()->renderWith(ThemeResourceLoader::inst()->findTemplate(
			$this->Layout()->Src,
			SSViewer::config()->uninherited('themes')
		));
		//return $this->renderWith($this->Layout->Src);
	}
}