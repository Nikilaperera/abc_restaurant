<?php
	/*$this->set_css($this->default_theme_path.'/datatables/css/demo_table_jui.css');
	$this->set_css($this->default_theme_path.'/datatables/css/datatables.css');
	$this->set_css($this->default_theme_path.'/datatables/css/jquery.dataTables.css');*/
	//$this->set_css($this->default_theme_path.'/datatables/extras/TableTools/media/css/TableTools.css');
    //$this->set_css($this->default_css_path.'/ui/simple/'.grocery_CRUD::JQUERY_UI_CSS);
	//$this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);

    if ($dialog_forms) {
        $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
        $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
        $this->set_js_lib($this->default_javascript_path.'/common/lazyload-min.js');
    }

    $this->set_js_lib($this->default_javascript_path.'/common/list.js');

	//$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS);
	$this->set_js_lib($this->default_theme_path.'/datatables/js/jquery.dataTables.min.js');
	$this->set_js($this->default_theme_path.'/datatables/js/datatables-extras.js');
	$this->set_js($this->default_theme_path.'/datatables/js/datatables.js');
	$this->set_js($this->default_theme_path.'/datatables/extras/TableTools/media/js/ZeroClipboard.js');
	$this->set_js($this->default_theme_path.'/datatables/extras/TableTools/media/js/TableTools.min.js');
?>
<script type='text/javascript'>
	var base_url = '<?php echo base_url();?>';
	var subject = '<?php echo addslashes($subject); ?>';

	var unique_hash = '<?php echo $unique_hash; ?>';

	var displaying_paging_string = "<?php echo str_replace( array('{start}','{end}','{results}'),
		array('_START_', '_END_', '_TOTAL_'),
		$this->l('list_displaying')
	   ); ?>";
	var filtered_from_string 	= "<?php echo str_replace('{total_results}','_MAX_',$this->l('list_filtered_from') ); ?>";
	var show_entries_string 	= "<?php echo str_replace('{paging}','_MENU_',$this->l('list_show_entries') ); ?>";
	var search_string 			= "<?php echo $this->l('list_search'); ?>";
	var list_no_items 			= "<?php echo $this->l('list_no_items'); ?>";
	var list_zero_entries 			= "<?php echo $this->l('list_zero_entries'); ?>";

	var list_loading 			= "<?php echo $this->l('list_loading'); ?>";

	var paging_first 	= "<?php echo $this->l('list_paging_first'); ?>";
	var paging_previous = "<?php echo $this->l('list_paging_previous'); ?>";
	var paging_next 	= "<?php echo $this->l('list_paging_next'); ?>";
	var paging_last 	= "<?php echo $this->l('list_paging_last'); ?>";

	var message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";

	var default_per_page = <?php echo $default_per_page;?>;

	var unset_export = <?php echo ($unset_export ? 'true' : 'false'); ?>;
	var unset_print = <?php echo ($unset_print ? 'true' : 'false'); ?>;

	var export_text = '<?php echo $this->l('list_export');?>';
	var print_text = '<?php echo $this->l('list_print');?>';
	var export_url = '<?php echo $export_url; ?>'

	<?php
	//A work around for method order_by that doesn't work correctly on datatables theme
	//@todo remove PHP logic from the view to the basic library
	$ordering = 0;
	$sorting = 'asc';
	if(!empty($order_by))
	{
		foreach($columns as $num => $column) {
			if($column->field_name == $order_by[0]) {
				$ordering = $num;
				$sorting = isset($order_by[1]) && $order_by[1] == 'asc' || $order_by[1] == 'desc' ? $order_by[1] : $sorting ;
			}
		}
	}
	?>

	var datatables_aaSorting = [[ <?php echo $ordering; ?>, "<?php echo $sorting;?>" ]];

</script>
<?php
	if(!empty($actions)){
?>
	<style type="text/css">
		<?php foreach($actions as $action_unique_id => $action){?>
			<?php if(!empty($action->image_url)){ ?>
				.<?php echo $action_unique_id; ?>{
					background: url('<?php echo $action->image_url; ?>') !important;
				}
			<?php }?>
		<?php }?>
	</style>
<?php
	}
?>
<?php if($unset_export && $unset_print){?>
<style type="text/css">
	.datatables-add-button
	{
		position: static !important;
	}
</style>
<?php }?>

<div class="grocerycrud-container">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor"></h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $this->l('list_add'); ?> <?php echo $subject?></li>
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
                    <h4 class="page-head-title card-title  text-white" style="display: inline-block"> <?php echo $subject?></h4>
                    <?php if(!$unset_add){?><a class="btn btn-success pull-right" style="color:#fff;" href="<?php echo $add_url?>" ><i class="fa fa-plus-circle"></i> <?php echo $this->l('list_add'); ?> <?php echo $subject?></a><?php }?>
                </div>
                <div class="element-box">
                    <div id='list-report-error' class='report-div error report-list'></div>
                    <div id='list-report-success' class='report-div success report-list' <?php if($success_message !== null){?>style="display:block"<?php }?>><?php
                        if($success_message !== null){?>
                            <p><?php echo $success_message; ?></p>
                        <?php }
                        ?></div>
                    <?php echo $list_view?>
                </div>
            </div>
        </div>
    </div>
</div>