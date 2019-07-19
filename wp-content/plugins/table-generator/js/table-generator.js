jQuery(document).ready(function ($) {
	var field_name_prefix = 'table_values';

	function get_effective(curr, index) {
		if(!index)
			return curr;

		if(curr == index[0])
			return index[1];
		else if(curr == index[1])
			return index[0];
		else
			return curr;
	}

	function get_curr_row_count(){
		return parseInt($('.wptg-rows').val());
	}

	function get_curr_col_count(){
		return parseInt($('.wptg-cols').val());
	}

	function is_valid_num(x){
		if(parseInt(x) == x && x > 0)
			return true;
		return false;
	}

	function is_valid_row(x){
		if(is_valid_num(x) && parseInt(x) <= get_curr_row_count())
			return true;
		return false;
	}
	
	function is_valid_col(x){
		if(is_valid_num(x) && parseInt(x) <= get_curr_col_count())
			return true;
		return false;
	}

	function rebuildTable(switch_rows, switch_cols){
		switch_rows 	= (typeof switch_rows !== 'undefined') ? switch_rows : false;
		switch_cols 	= (typeof switch_cols !== 'undefined') ? switch_cols : false;
		var row_count 	= $('.wptg-rows').val();
		var col_count 	= $('.wptg-cols').val();
		var table 		= $('.wptg-table');
		var effective_row, effective_col;

		var table_html = '<thead><tr><th class="wptg-placeholder"></th>';
		for(var i = 1; i <= col_count; i++){
			effective_col = get_effective(i, switch_cols);
			var selector = 'input[name="'+field_name_prefix+'[0]['+effective_col+']"]';
			var curr_val = ( $(selector).val() ) ? $(selector).val() : '';
			table_html += '<th><input name="'+field_name_prefix+'[0]['+i+']" value="'+curr_val+'" placeholder="'+wptg_js_strings.placeholder+'" /></th>';
		}
		table_html += '</tr></thead><tbody>';

		for(var i = 1; i <= row_count; i++){
			table_html += '<tr>';
			for(var j = 0; j <= col_count; j++){

				effective_row = get_effective(i, switch_rows);
				effective_col = get_effective(j, switch_cols);

				var selector = 'input[name="'+field_name_prefix+'['+effective_row+']['+effective_col+']"]';
				var curr_val = ( $(selector).val() ) ? $(selector).val() : '';
				table_html += '<td><input name="'+field_name_prefix+'['+i+']['+j+']" value="'+curr_val+'" placeholder="'+wptg_js_strings.placeholder+'" /></td>';
			}
			table_html += '</tr>';
		}
		table_html += '</tbody>';
		table.html(table_html);
	}

	//Table resize dialog

	$('#wptg-table-resize-btn').click(function(e) {
		$( "#wptg-table-resize-dialog" ).dialog({
			modal:true,
			draggable: false,
			open: function(e, ui) {
				$(this).children('.wptg-row-count').val(get_curr_row_count());
				$(this).children('.wptg-col-count').val(get_curr_col_count());
				$(this).children('.wptg-dialog-error').hide();
			}
		});
	});

	$('#wptg-table-resize-dialog button').click(function(e) {
		var row_count 	= $(this).siblings('.wptg-row-count').val();
		var col_count 	= $(this).siblings('.wptg-col-count').val();
		var error_cont 	= $(this).siblings('.wptg-dialog-error').first();
		if(is_valid_num(row_count) && is_valid_num(col_count)){
			error_cont.hide();
			$('.wptg-rows').val(row_count);
			$('.wptg-cols').val(col_count);
			rebuildTable();
			$('#wptg-table-resize-dialog').dialog("close");
		}
		else{
			error_cont.html(wptg_js_strings.resize_error).show().effect( "bounce" );
		}
	});

	//Switch Rows Dialog

	$('#wptg-row-switcher-btn').click(function(e) {
		$( "#wptg-row-switcher-dialog" ).dialog({
			modal:true,
			draggable: false,
			open: function(e, ui) {
				$(this).children('input[type="text"]').val('');
				$(this).children('.wptg-dialog-error').hide();
			}
		});
	});

	$( "#wptg-row-switcher-dialog button" ).click(function(e) {
		var row_1 		= $(this).siblings('.wptg-row1').val();
		var row_2 		= $(this).siblings('.wptg-row2').val();
		var error_cont 	= $(this).siblings('.wptg-dialog-error').first();
		if(is_valid_row(row_1) && is_valid_row(row_2)){
			error_cont.hide();
			rebuildTable([row_1, row_2], false);
			$( "#wptg-row-switcher-dialog" ).dialog("close");
		}
		else{
			error_cont.html(wptg_js_strings.switch_error + ' ' + get_curr_row_count()).show().effect( "bounce" );
		}
	});

	//Switch Cols Dialog

	$('#wptg-col-switcher-btn').click(function(e) {
		$( "#wptg-col-switcher-dialog" ).dialog({
			modal:true,
			draggable: false,
			open: function(e, ui) {
				$(this).children('input[type="text"]').val('');
				$(this).children('.wptg-dialog-error').hide();
			}
		});
	});

	$( "#wptg-col-switcher-dialog button" ).click(function(e) {
		var col_1 		= $(this).siblings('.wptg-col1').val();
		var col_2 		= $(this).siblings('.wptg-col2').val();
		var error_cont 	= $(this).siblings('.wptg-dialog-error').first();
		if(is_valid_col(col_1) && is_valid_col(col_2)){
			error_cont.hide();
			rebuildTable(false, [col_1, col_2]);
			$( "#wptg-col-switcher-dialog" ).dialog("close");
		}
		else{
			error_cont.html(wptg_js_strings.switch_error + ' ' + get_curr_col_count()).show().effect( "bounce" );
		}
	});
});