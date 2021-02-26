<?php

namespace Schrattenholz\ContentObject;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TabSet;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\Image;
use Page;
class RevoLayer extends DataObject{
	private static $table_name="revolayer";
	private static $db=array(
		'SortID'=>'Int',
		'Title'=>'Text',
		'Col01'=>'Varchar(40)',
		'Col01_2'=>'Varchar(40)',
		'Col02'=>'HTMLText'	
	);
	private static $has_one=array(
		'BackgroundImage'=>Image::class,
		'Page'=>'Page'
	);
	public function getCMSFields(){
		$col01=		new TextField("Col01","Zeile #1",1);
		$col01_2=	new TextField("Col01_2","Zeile #1-2",1);
		$col02=		new HTMLEditorField("Col02","Zeile #2",1);
		

		$col02->setRows(1);
		return new FieldList(
			array(
				new UploadField("BackgroundImage","Hintergrundbild"),
				$col01,
				$col01_2,
				$col02
				
			)
		);
		
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