<?php


namespace Schrattenholz\ContentObject;

use Silverstripe\ORM\DataObject;
use Silverstripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\Textfield;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\DataList;
use SilverStripe\Core\Injector\Injector;
use Psr\Log\LoggerInterface;
class CO_Gallery_Image extends DataObject{
	private static $table_name="CO_Gallery_Image";
	private static $db=[
		'Title'=>'Varchar(255)',
		'SortID'=>'Int',
		'Adult'=>'Boolean',
		'Video'=>'Text',
		'Video_Autoplay'=>'Boolean',
		'Video_Format'=>'Enum("16-9,4-3","16-9")'
		//'DeepLinkHash'=>'Boolean'
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
		$fields->addFieldToTab("Root.Main",new TreeDropdownField("DeepLinkID","Zu verlinkende Seite",SiteTree::class));
		$fields->addFieldToTab('Root.Main',new TextareaField('Description','2te Zeile'));
		$fields->addFieldToTab('Root.Main',new UploadField('Image','Bild'));
		$fields->addFieldToTab('Root.Video',new TextField("Video","Youtube-Video"));
		$fields->addFieldToTab('Root.Video',new CheckboxField("Video_Autoplay","Autoplay aktivieren"));
		$fields->addFieldToTab('Root.Video',new DropdownField("Video_Format","Format des Video auswählen",singleton(CO_Gallery_Image::class)->dbObject("Video_Format")->enumValues()));

		$fields->addFieldToTab('Root.Video',new LiteralField("YoutubeInfo",'Youtube-Video einfügen <ul><li>Auf Youtube das entpsprechende Video öffnen</li><li>Kopieren Sie aus der Browserzeile den Video-Code (https://www.youtube.com/watch?v=<strong>ODlMfKMBzy4</strong>)</li><li>Fügen Sie den Video-Code im Feld Youtube-Video ein.</li></ul>'));
		
		$fields->removeFieldFromTab('Root.Main','SortID');
		$fields->removeFieldFromTab('Root.Main','GalleryID');
		return $fields;	
	}
	/*public function onAfterWrite(){
	   parent::onAfterWrite();
		if ($this->Image()->exists() && !$this->Image()->isPublished()){
			Injector::inst()->get(LoggerInterface::class)->error($this->owner->MenuTitle.'   BlogExtension.php BasicExtension_MainImage MainImage()->ID='.$this->owner->MainImage()->Filename);
		  $this->Image()->doPublish();
		}
	 }*/
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
	private static $owns=[
		'Image'
	];
}