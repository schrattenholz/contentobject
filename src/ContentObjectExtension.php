<?php 	

namespace Schrattenholz\ContentObject;

use SilverStripe\Core\Extension; 
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TabSet;
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
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\ORM\ArrayList;

use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;


//Debugging
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use Psr\Log\LoggerInterface;

class ContentObjectExtension extends Extension{
	private static $has_many=array(
		'ContentObjects'=>ContentObject::class,
		'SeveralCols'=>SeveralCols::class
	);
	private static $belongs_many_many=array(
		'CO_TeaserSections'=>CO_TeaserSection::class
	);
	public function DeepLink(){
		return $this->owner;
	}
	public function updateCMSFields(FieldList $fields) {
		
		
		
		$gridFieldConfig=GridFieldConfig::create()
			->addComponent(new GridFieldButtonRow('before'))
			->addComponent(new GridFieldDataColumns)
			//->addComponent(new GridFieldDeleteAction())
			->addComponent(new GridFieldEditButton())
			->addComponent(new GridFieldDetailForm())
			->addComponent(new GridFieldSortableHeader())
			->addComponent(new GridFieldFilterHeader())
			->addComponent(new GridFieldPaginator())
			->addComponent(new GridFieldAddExistingAutocompleter())
			->addComponent(new GridFieldOrderableRows('SortID'))
		;
		$multiClassConfig = new GridFieldAddNewMultiClass();
        $multiClassConfig->setClasses(
            array(
                'Schrattenholz\ContentObject\CO_TeaserSection',
				'Schrattenholz\ContentObject\CO_Infobox',
				'Schrattenholz\ContentObject\CO_Gallery',
				'Schrattenholz\ContentObject\CO_HTMLText',
				'Schrattenholz\ContentObject\CO_HTMLText_Image',
				//'Schrattenholz\ContentObject\SeveralCols',
				
            )
        );
		$gridFieldConfig->addComponent($multiClassConfig);
		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');
		$fields->addFieldToTab('Root.Weitere Inhalte', GridField::create(
			'ContentObjects',
			'Weitere Inhalte',
			$this->owner->ContentObjects(),
			$gridFieldConfig
		));
		
		// Schnellbearbeitungsliste
		
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

		$gridFieldConfig->removeComponentsByType('GridFieldAddNewButton');

		
		$contentObjects=$this->owner->ContentObjects()->filter(["ClassName"=>["Schrattenholz\ContentObject\CO_Infobox","Schrattenholz\ContentObject\CO_TeaserSection"]]);
		if(count($contentObjects)>0){
			$co_IDs=array();
			foreach($contentObjects as $cO){
				array_push($co_IDs,$cO->ID);
				
			}
		
			$infoBoxes=CO_Infobox_Element::get()->filter(["InfoboxID"=>$co_IDs])->where("ShowInQuickEditList",1);
			$teaserSectionBoxes=CO_TeaserSection_Box::get()->filter(["CO_TeaserSectionID"=>$co_IDs])->where("ShowInQuickEditList",1);
			$data=new ArrayList();
			$data->merge($infoBoxes);
			$data->merge($teaserSectionBoxes);

			if($data->count()>0){
					$fields->addFieldToTab('Root.Schnellbearbeitung', GridField::create(
							'FastEdit',
							'Schnellbearbeitung',
							$data,
							$gridFieldConfig
						)
					);
				}
			}    
		}
		private static $owns = [
			'ContentObjects'
		];
}