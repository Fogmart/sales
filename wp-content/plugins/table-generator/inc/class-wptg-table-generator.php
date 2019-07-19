<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class WPTG_Table_Generator
{
	private $version;

	private $page_slug;

	private $page_hook;

	private $base_url;

	private $db;

	function __construct($_version, $_base_url = false ) {
		$this->load_dependencies();

		$this->version 		= $_version;
		$this->page_slug 	= 'wptg_table_generator';

		$this->db 			= WPTG_DB_Table::get_instance();

		add_action( 'admin_menu', array($this, 'add_menu_items') );
		add_action( 'admin_enqueue_scripts', array($this, 'backend_enqueue') );
		add_action( 'admin_init', array($this, 'handle_requests') );
		add_action( 'admin_notices', array($this, 'admin_notices') );
		add_shortcode( 'wptg_comparison_table', array($this, 'comparison_table_callback') );
		add_action( 'wp_enqueue_scripts', array($this, 'frontend_enqueue') );

		if(!$_base_url)
			$this->base_url = plugins_url( '', dirname(__FILE__) );
		else
			$this->base_url = $_base_url;
	}

	private function load_dependencies(){
		require_once 'class-wptg-list-table.php';
		require_once 'class-wptg-db-table.php';
	}

	public function add_menu_items() {
		$this->page_hook = add_menu_page( __('Table Generator', 'wptg-plugin'), __('Table Generator', 'wptg-plugin'), 'manage_options', $this->page_slug, array($this, 'print_page'), $this->base_url . "/img/icon.png" );
	}

	public function frontend_enqueue() {
		wp_enqueue_style( "wptg-styles", plugins_url( "css/style.css" , dirname(__FILE__) ), null, $this->version, "all" );
	}

	public function backend_enqueue($hook) {
		if( $this->page_hook != $hook )
			return;

		wp_enqueue_style( 'wptg-jquery-ui-structure', $this->base_url . '/css/jquery-ui.structure.css', false, '1.0', 'all' );
		wp_enqueue_style( 'wptg-stylesheet', $this->base_url . '/css/table-generator.css', false, '1.0', 'all' );
		wp_enqueue_script( 'wptg-script', $this->base_url . '/js/table-generator.js', array('jquery'), '1.0' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script('jquery-effects-bounce');

		$wptg_js_strings = array(
			'placeholder' 	=> __('Click to edit', 'wptg-plugin'),
			'resize_error' 	=> __('Please enter valid numbers', 'wptg-plugin'),
			'switch_error' 	=> __('Please enter valid numbers between 1 and', 'wptg-plugin')
		);
		wp_localize_script( 'wptg-script', 'wptg_js_strings', $wptg_js_strings );
	}

	public function print_page() {
	?>
		<div class="wrap">
			<?php
				if(isset($_GET['action']) && $_GET['action'] == 'add'){
					echo sprintf( '<h2>%s <a class="add-new-h2" href="%s">%s</a></h2>', __('Add Table', 'wptg-plugin'), admin_url('admin.php?page='.$this->page_slug), __('View All', 'wptg-plugin') );
					$this->create_ui();
				}
				elseif(isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['table']) && is_numeric($_GET['table'])){
					echo sprintf( '<h2>%s <a class="add-new-h2" href="%s">%s</a></h2>', __('Edit Table', 'wptg-plugin'), admin_url('admin.php?page='.$this->page_slug), __('View All', 'wptg-plugin') );
					$table = $this->db->get($_GET['table']);
					if($table)
						$this->create_ui($table);
				}
				else{
					echo sprintf( '<h2>%s <a class="add-new-h2" href="%s">%s</a></h2>', __('Tables', 'wptg-plugin'), admin_url('admin.php?page='.$this->page_slug.'&action=add'), __('Add New', 'wptg-plugin') );
					$list_table = new WPTG_List_Table();
					$list_table->show();
				}
			?>
		</div>
	<?php
	}

	private function create_ui($table = false){
		$table_id 		= $table ? $table['id'] : '';
		$name 			= $table ? $table['name'] : '';
		$rows 			= $table ? $table['rows'] : 3;
		$cols 			= $table ? $table['cols'] : 3;
		$curr_values 	= $table ? $table['tvalues'] : '';
		?>
			<form autocomplete="off" method="POST" class="wptg-form">
				<input type="text" class="wptg-title" placeholder="<?php _e('Table Name', 'wptg-plugin'); ?>" name="table_name" value="<?php echo esc_attr($name); ?>"  required="required" />
				<input type="hidden" class="wptg-rows" value="<?php echo esc_attr($rows); ?>" name="table_rows" />
				<input type="hidden" class="wptg-cols" value="<?php echo esc_attr($cols); ?>" name="table_cols" />
				<div class="wptg-controls">
					<button id="wptg-table-resize-btn" type="button" class="button"><?php _e('Resize Table', 'wptg-plugin') ?></button>
					<button id="wptg-row-switcher-btn" type="button" class="button"><?php _e('Switch Rows', 'wptg-plugin') ?></button>
					<button id="wptg-col-switcher-btn" type="button" class="button"><?php _e('Switch Cols', 'wptg-plugin') ?></button>
				</div>
				<table class="wptg-table">
					<thead class="wptg-thead">
						<tr>
							<th class="wptg-placeholder"></th>
							<?php for ($j=1; $j <= $cols; $j++): ?>
								<th><input placeholder="<?php _e('Click to edit', 'wptg-plugin') ?>" type="text" name="table_values[0][<?php echo $j; ?>]" value="<?php echo isset($curr_values[0][$j]) ? esc_attr($curr_values[0][$j]) : ''; ?>" /></th>
							<?php endfor; ?>
						</tr>
					</thead>
					<tbody class="wptg-tbody">
					<?php for ($i=1; $i <= $rows; $i++): ?>
						<tr>
						<?php for ($j=0; $j <= $cols; $j++): ?>
							<td>
								<input placeholder="<?php _e('Click to edit', 'wptg-plugin') ?>" type="text" name="table_values[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo isset($curr_values[$i][$j]) ? esc_attr($curr_values[$i][$j]) : ''; ?>" />
							</td>
						<?php endfor; ?>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
				<?php
					if($table)
						submit_button( __('Save Changes', 'wptg-plugin'), 'primary', 'wptg-save-changes', true );
					else
						submit_button( __('Create Table', 'wptg-plugin'), 'primary', 'wptg-create-table', true );
				?>
			</form>
			<p class="description">
				<?php _e('Shortcode', 'wptg-plugin'); echo ": "; ?><code>[wptg_comparison_table id="<?php echo $table_id; ?>"]</code><br/><br/>
				<?php $placeholders = array('tick', 'cross', 'info', 'warning', 'heart', 'lock', 'star', 'star-empty'); ?>
				<?php _e('To add icons you can use these placeholders: ', 'wptg-plugin'); foreach($placeholders as $p){ echo "%".strtoupper($p)."%  "; } ?>
			</p>

			<div id="wptg-table-resize-dialog" class="wptg-dialog" title="<?php _e('Change Table Size', 'wptg-plugin') ?>">
				<div class="wptg-dialog-error"></div>
				<?php _e('Rows', 'wptg-plugin') ?>: <input type="text" class="wptg-row-count" />
				<?php _e('Cols', 'wptg-plugin') ?>: <input type="text" class="wptg-col-count" />
				<button class="button button-primary"><?php _e('Apply', 'wptg-plugin') ?></button>
			</div>

			<div id="wptg-row-switcher-dialog" class="wptg-dialog" title="Switch Rows">
				<div class="wptg-dialog-error"></div>
				<?php _e('Row 1', 'wptg-plugin') ?>: <input type="text" class="wptg-row1" />
				<?php _e('Row 2', 'wptg-plugin') ?>: <input type="text" class="wptg-row2" />
				<button class="button button-primary"><?php _e('Switch', 'wptg-plugin') ?></button>
			</div>

			<div id="wptg-col-switcher-dialog" class="wptg-dialog" title="Switch Columns">
				<div class="wptg-dialog-error"></div>
				<?php _e('Col 1', 'wptg-plugin') ?>: <input type="text" class="wptg-col1" />
				<?php _e('Col 2', 'wptg-plugin') ?>: <input type="text" class="wptg-col2" />
				<button class="button button-primary"><?php _e('Switch', 'wptg-plugin') ?></button>
			</div>

		<?php
	}

	private function is_plugin_page(){
		if( !is_admin() || !isset($_GET['page']) || $this->page_slug != $_GET['page'] || (!isset($_GET['action']) && !isset($_GET['action2'])) )
			return false;
		return true;
	}

	public function handle_requests(){
		if( !$this->is_plugin_page() )
			return;

		if(isset($_GET['action2']) && $_GET['action2'] != -1 && $_GET['action'] == -1)
			$_GET['action'] = $_GET['action2'];

		if($_GET['action'] == 'add' && isset($_POST['wptg-create-table'])){
			$result = $this->db->add( $_POST['table_name'], $_POST['table_rows'], $_POST['table_cols'], $_POST['table_values'] );
			if($result){
				$sendback = add_query_arg( array( 'page' => $_GET['page'], 'action' => 'edit', 'table' => $result, 'added' => true ), '' );
				wp_redirect($sendback);
			}
		}

		if($_GET['action'] == 'edit' && isset($_POST['wptg-save-changes']) && isset($_GET['table'])){
			$result = $this->db->update( $_GET['table'], $_POST['table_name'], $_POST['table_rows'], $_POST['table_cols'], $_POST['table_values'] );
			$sendback = add_query_arg( array( 'page' => $_GET['page'], 'action' => 'edit', 'table' => $_GET['table'], 'updated' => $result ), '' );
			wp_redirect($sendback);
		}

		if($_GET['action'] == 'delete' && isset($_GET['table']) && is_array($_GET['table']) ){
			$result = $this->db->delete( $_GET['table'] );
			$sendback = add_query_arg( array( 'page' => $_GET['page'], 'deleted' => $result ), '' );
			wp_redirect($sendback);
		}
	}

	public function admin_notices(){
		if( !$this->is_plugin_page() )
			return;

		$format = '<div class="updated"><p>%s</p></div>';

		if(isset($_GET['added']) && $_GET['added']):
			echo sprintf($format, __('The table has been created successfully!', 'wptg-plugin') );
		elseif(isset($_GET['updated']) && $_GET['updated']):
			echo sprintf($format, __('The table has been updated successfully!', 'wptg-plugin') );
		elseif(isset($_GET['deleted']) && $_GET['deleted']):
			echo sprintf($format, __('The table has been deleted successfully!', 'wptg-plugin') );
		endif;
	}

	function comparison_table_callback( $atts ){
		$atts = shortcode_atts( array( 'id' => false, 'class' => 'wptg-comparison-table' ), $atts );

		if(!$atts['id']){
			_e("Please specify the table ID", 'wptg-plugin');
			return;
		}

		$table = $this->db->get($atts['id']);
		if(!$table)
			return;

		ob_start();
		?>
			<table class="wptg-table <?php echo $atts['class'] ?>">
				<thead class="wptg-thead">
					<tr>
						<th class="placeholder wptg-placeholder"></th>
						<?php for ($j=1; $j <= $table['cols']; $j++): ?>
							<th><?php echo $this->replace_placeholders($table['tvalues'][0][$j]); ?></th>
						<?php endfor; ?>
					</tr>
				</thead>
				<tbody class="wptg-tbody">
				<?php for($i=1; $i <= $table['rows']; $i++): ?>
					<tr>
						<?php for ($j=0; $j <= $table['cols']; $j++): ?>
							<td><?php echo $this->replace_placeholders($table['tvalues'][$i][$j]); ?></td>
						<?php endfor; ?>
					</tr>
				<?php endfor; ?>
				</tbody>
			</table>
		<?php
		return ob_get_clean();
	}

	public function replace_placeholders($str){
		$values 			= array();
		$values['tick'] 	= '<i class="wptg-icon-tick"></i>';
		$values['cross'] 	= '<i class="wptg-icon-cross"></i>';
		$values['info'] 	= '<i class="wptg-icon-info"></i>';
		$values['warning'] 	= '<i class="wptg-icon-warning"></i>';
		$values['heart'] 	= '<i class="wptg-icon-heart"></i>';
		$values['lock'] 	= '<i class="wptg-icon-lock"></i>';
		$values['star'] 	= '<i class="wptg-icon-star"></i>';
		$values['star-empty'] = '<i class="wptg-icon-star-empty"></i>';

		foreach ($values as $key => $value) {
			$str = str_replace('%'.strtoupper($key).'%', $value, $str);
		}
		return $str;
	}

	public function initialize()
	{
		$this->db->create_table();
	}

	public function rollback()
	{
		$table = WPTG_DB_Table::get_instance();
		$table->drop_table();
	}
}