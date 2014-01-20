<?php
# Copyright (c) 2014 Kenson Man (kenson.idv.hk@gmail.com)
#
# License: Please refer to the LICENSE file

/*
 * Replace the default date-selection-control with jQueryUI's datepicker 
 */
class jQueryUIDatepickerPlugin extends MantisPlugin{
	function register(){
		$this->name=plugin_lang_get("title");
		$this->description=plugin_lang_get("description");
		$this->version="1.0.0";
		$this->requires=array('MantisCore'=>'1.2.0', 'jQuery'=>'1.3', 'jQueryUI'=>'1.2.0');
		$this->author="Kenson Man";
		$this->contact="kenson.idv.hk@gmail.com";
		$this->url="https://github.com/kensonman/mantisbt-plugin-datepicker";
	}

	/**
	 * Bindings
	 */
	function hooks(){
		return array(
			'EVENT_REPORT_BUG_FORM'=> 'resources'
			, 'EVENT_UPDATE_BUG_FORM'=> 'resources'
			, 'EVENT_UPDATE_BUG_STATUS_FORM'=> 'resources'
		);
	}

	/**
	 * Create the configuration for the plugin.
	 * DATE_FORMAT (string): The date-format when creating datepicker; Refer to http://api.jqueryui.com/datepicker/#option-dateFormat
	 * BTN_IMG (string):     The path for the button-image;
	 */
	function config(){
		return array(
			'OPTIONS' => '{dateFormat:"yy-mm-dd"}',
		);
	}

	function resources( $p_evt, $p_param ){
		$result ="<!-- ----- ----- jQueryUI Datepicker (start) ----- ----- -->\n";
		$result.="<script type=\"text/javascript\"><!--\n";
		$result.="  jQuery(document).ready(function(){\n";
		$result.="    jQuery('select[name $= \"_year\"]').each(function(){\n";
		$result.="       var name=jQuery(this).attr('name');\n";
		$result.="       name=name.substring(0, name.length-5);\n";
		$result.="       jQuery(this).parents(':first')\n";
		$result.="          .empty()\n";
                $result.="          .append('<input type=\"hidden\" name=\"'+name+'_year\"/>')\n";
                $result.="          .append('<input type=\"hidden\" name=\"'+name+'_month\"/>')\n";
                $result.="          .append('<input type=\"hidden\" name=\"'+name+'_day\"/>')\n";
		$result.="          .append('<input type=\"text\" name=\"'+name+'\" class=\"dateFld\" size=\"10\"/>')\n";
		$result.="          .find('.dateFld').datepicker(".plugin_config_get('OPTIONS').").change(function(){\n";
		$result.="            var val=jQuery(this).datepicker('getDate');\n";
		$result.="            jQuery(this).parents(':first')\n";
		$result.="               .find('input[name$=\"_year\"]').val(val.getFullYear()).end()\n";
		$result.="               .find('input[name$=\"_month\"]').val(val.getMonth()+1).end()\n";
		$result.="               .find('input[name$=\"_day\"]').val(val.getDate()).end()\n";
		$result.="            ;\n";
		$result.="          })\n";
		$result.="       ;\n";
		$result.="    });\n";
		$result.="  });\n";
		$result.="//--></script>\n";
		$result.="<!-- ----- ----- jQueryUI Datepicker (end) ----- ----- -->\n";
		echo $result;
		return $result;
	}
}
