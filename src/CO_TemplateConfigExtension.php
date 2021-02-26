<?php
namespace Schrattenholz\ContentObject;

use Schrattenholz\TemplateConfig\TemplateConfigAdmin;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Core\Extension;

class CO_TemplateConfigExtension extends Extension
{
    private static $managed_models = [
        CO_TeaserSection_Layout::class,
		CO_Gallery_Layout::class
    ];
}