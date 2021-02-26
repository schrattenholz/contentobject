<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\Image;
use Page;
use SilverStripe\CMS\Model\SiteTree;

use Schrattenholz\TemplateConfig\ColorSet;

class QuadElement extends DataObject{
	private static $table_name="quadelement";
	private static $db=array(
		'Col01'=>'Varchar(25)',
		'Col02'=>'Varchar(40)',
		'SortID'=>'Int',
		'Background'=>'Enum("anthrazit,blau,hell-lila,gruen","anthrazit")'
	);
	private static $has_one=array(
		'DeepLink'=>SiteTree::class,
		'Page'=>'Page',
		'BackgroundImage'=>Image::class,
		'ColorSet'=>ColorSet::class
	);
	public function getCMSFields(){
		$col01=		new TextField("Col01","Zeile #1");
		$col02=		new TextField("Col02","Zeile #2");
		$deeplink= new TreeDropdownField('DeepLinkID','Link',SiteTree::class);
		$bg=new DropdownField('ColorSetID','Farbe', ColorSet::get()->map("ID", "Title", "Bitte auswählen"));
		$bgimage=new UploadField('BackgroundImage','Hintergrundbild');
		return new FieldList(
			array(
				$col01,
				$col02,
				$deeplink,
				$bg,
				$bgimage
			)
		);
		
	}
	public function Title(){
		return $this->Col01;
	}
	public function onBeforeWrite(){
		$pos=$this->strposX($this->Col01," ",2);
		if($pos){
		$this->Title=strip_tags(substr($this->Col01,0,$pos));
		}else{
			$this->Title=strip_tags($this->Col01);
		}
		parent::onBeforeWrite();
	}
	public function getThumbnail(){
		return $this->BackgroundImage()->CMSThumbnail();
	}
	public function strposX($haystack, $needle, $number) {
		preg_match_all("/($needle)/", utf8_decode($haystack), $matches, PREG_OFFSET_CAPTURE);
			return $matches[0][$number-1][1];

	}
	private static $owns = [
		'BackgroundImage'
	];
}