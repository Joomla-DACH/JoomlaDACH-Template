<?php

namespace Kicktemp\Plugin\System\Kickvlog\Field;

// Check to ensure this file is included in Joomla!
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die('Restricted access');

class YoutubejsonField extends FormField {

    protected $type = 'YoutubeJSON';

    public function getInput() {

        $doc = Factory::getDocument();
        $js = array();

        $js[] = 'jQuery(function () {';
        $js[] = "jQuery('#youtubejson').click(function(){";
        $js[] = "jQuery.ajax({";
        $js[] = "type: 'POST',";
        $js[] = "url: '".Uri::root(false)."index.php?option=com_ajax&plugin=YoutubeJSON&format=raw',";
        $js[] = "data: {";
        $js[] = "youtube_id: encodeURIComponent(jQuery('#jform_attribs_youtube_id').val())";
        $js[] = "},";
        $js[] = "dataType: 'json',";
        $js[] = "success: function (data) {";
        $js[] = "jQuery('#jform_title,#jform_attribs_youtube_title').val(data.title);";
        $js[] = "jQuery('#jform_attribs_youtube_desc').val(data.description);";
        $js[] = "jQuery('#jform_articletext').val('<p>' + data.description.replace(/(?:\\r\\n|\\r|\\n)/g, '<br />') + '</p>');";
        $js[] = "}";
        $js[] = "});";
        $js[] = "});";
        $js[] = '});';

        $js =  implode("\n",$js);
        $doc->addScriptDeclaration($js);

        $html = array();
        $html[] = '<input type="button" class="btn btn-success" value="'.Text::_('PLG_KICKVLOG_YOUTUBEJSON') .'" id="youtubejson">';

        return implode("\n",$html);
    }
}