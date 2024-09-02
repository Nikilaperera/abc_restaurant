<?php

	//$this->set_css($this->default_theme_path.'/datatables/css/datatables.css');
    $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.form.min.js');
	$this->set_js_config($this->default_theme_path.'/datatables/js/datatables-edit.js');
	//$this->set_css($this->default_css_path.'/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS);
	//$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS);

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $subject?></li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="element-wrapper">
            <div class="element-actions">
            </div>
            <!--<h6 class="element-header">

            </h6>-->
            <div class="card-header bg-info page-head-title-wrap">
                <h4 class="page-head-title card-title  text-white" style="display: inline-block"> <?php echo $this->l('form_edit'); ?> <?php echo $subject?></h4>
                <div class='clear'></div>
            </div>
            <div class="element-box">
                <div class='form-content form-div'>
                    <?php echo form_open( $update_url, 'method="post" id="crudForm" enctype="multipart/form-data"'); ?>
                    <div>
                        <?php
                        $counter = 0;
                        foreach($fields as $field)
                        {
                            $even_odd = $counter % 2 == 0 ? 'odd' : 'even';
                            $counter++;
                            ?>
                            <div class='form-field-box <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box">
                                <div class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box">
                                    <?php echo $input_fields[$field->field_name]->display_as?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""?> :
                                </div>
                                <div class='form-input-box' id="<?php echo $field->field_name; ?>_input_box">
                                    <?php echo $input_fields[$field->field_name]->input?>
                                </div>
                                <div class='clear'></div>
                            </div>
                        <?php }?>
                        <!-- Start of hidden inputs -->
                        <?php
                        foreach($hidden_fields as $hidden_field){
                            echo $hidden_field->input;
                        }
                        ?>
                        <!-- End of hidden inputs -->
                        <?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
                        <div class='line-1px'></div>
                        <div id='report-error' class='report-div error'></div>
                        <div id='report-success' class='report-div success'></div>
                    </div>
                    <div class='buttons-box'>
                        <div class='form-button-box'>
                            <input  id="form-button-save" type='submit' value='<?php echo $this->l('form_update_changes'); ?>' class='btn btn-warning' />
                        </div>
                        <?php 	if(!$this->unset_back_to_list) { ?>
                            <div class='form-button-box'>
                                <input type='button' value='<?php echo $this->l('form_update_and_go_back'); ?>' class='btn btn-primary' id="save-and-go-back-button"/>
                            </div>
                            <div class='form-button-box'>
                                <input type='button' value='<?php echo $this->l('form_cancel'); ?>' class='btn btn-danger' id="cancel-button" />
                            </div>
                        <?php }?>
                        <div class='form-button-box loading-box'>
                            <div class='small-loading' id='FormLoading'><?php echo $this->l('form_update_loading'); ?></div>
                        </div>
                        <div class='clear'></div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!--<div class='ui-widget-content ui-corner-all datatables'>
	<h3 class="ui-accordion-header ui-helper-reset ui-state-default form-title">
		<div class='floatL form-title-left'>
			<a href="#"><?php /*echo $this->l('form_edit'); */?> <?php /*echo $subject*/?></a>
		</div>
		<div class='clear'></div>
	</h3>

</div>-->
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
	var message_update_error = "<?php echo $this->l('update_error')?>";
</script>