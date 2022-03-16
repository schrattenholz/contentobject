<?php


namespace Schrattenholz\ContentObject;

use Silverstripe\ORM\DataObject;
use Silverstripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;
class CO_Gallery_Image extends DataObject{
	private static $table_name="CO_Gallery_Image";
	private static $db=[
		'Title'=>'Varchar(255)',
		'SortID'=>'Int',
		'Adult'=>'Boolean'
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