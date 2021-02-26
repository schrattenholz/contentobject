<?php


namespace Schrattenholz\ContentObject;

use Silverstripe\ORM\DataObject;
use Silverstripe\Assets\Image;

class CO_Gallery_Image extends DataObject{
	private static $table_name="CO_Gallery_Image";
	private static $db=[
		'Title'=>'Varchar(255)',
		'SortID'=>'Int',
		'Adult'=>'Boolean'
	];
	private static $has_one=[
		"Image"=>Image::class,
		"Gallery"=>CO_Gallery::class
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
	public function getThumbnail(){
		return $this->Image()->CMSThumbnail();
	}
	private static $owner=[
		'Image'
	];
}