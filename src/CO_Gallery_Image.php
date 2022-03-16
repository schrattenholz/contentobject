<?php


namespace Schrattenholz\ContentObject;

use Silverstripe\ORM\DataObject;
use Silverstripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\Textfield;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
class CO_Gallery_Image extends DataObject{
	private static $table_name="CO_Gallery_Image";
	private static $db=[
		'Title'=>'Varchar(255)',
		'SortID'=>'Int',
		'Adult'=>'Boolean',
		'DeepLinkHash'=>'Boolean'
	];
	private static $has_one=[
		"Image"=>Image::class,
		"Gallery"=>CO_Gallery::class,
		'DeepLink'=>SiteTree::class
	];
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if($this->Title==""){
			$this->Title=$this->Image()->Title;
		}
		
	}
	public function getCMSFields(){
		$fields=parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',new Textfield('Title','Titel'));
		$fields->addFieldToTab("Root.Main",new TreeDropdownField("DeepLink","Zu verlinkende Seite","Page"));
		$fields->addFieldToTab('Root.Main',new TextareaField('Description','2te Zeile'));
		$fields->addFieldToTab('Root.Main',new CheckboxField('DeepLinkHash','Ausgewähltes Dokument wird in der übergeordneten Liste angezeigt (Kreationen)'));
		//$fields->addFieldToTab('Root.Main',new Textfield('LineThree','3te Zeile'));
		$fields->addFieldToTab('Root.Main',new UploadField('Image','Bild'));
		$fields->removeFieldFromTab('Root.Main','SortID');
		return $fields;	
	}
	public function onAfterWrite(){
	   parent::onAfterWrite();
		if ($this->Image()->exists() && !$this->Image()->isPublished()){
		  $this->Image()->doPublish();
		}
	 }
	 	public function PageDeepLinkHash(){
		$page=DataList::create(SiteTree::class)->where('ID='.$this->PageLinkID)->First;
		if($this->DeepLinkHash){
			return '#'.$this->DeepLink()->URLSegment;
		}else{
			return false;
		}
	}
	public function PageLinkURL(){
		$page=DataList::create(SiteTree::class)->where('ID='.$this->PageLinkID)->First;
		if($this->DeepLinkHash){
			//$page=DataList::create('SiteTree')->where('ID='.$this->DeepLink()->ParentID)->First();
			return $this->DeepLink()->Parent()->Link();
		}else{
			return $this->DeepLink()->Link();
		}
	}
	public function getThumbnail(){
		return $this->Image()->CMSThumbnail();
	}
	private static $owner=[
		'Image'
	];
}