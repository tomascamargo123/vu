<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Datatables Helper
 *
 * @package    CodeIgniter
 * @subpackage helpers
 * @category   helper
 * @version    1.1.4
 * @author     ZettaSys <info@zettasys.com.ar>
 *
 */
if (!function_exists('buildJS'))
{

	function buildJS($tableData)
	{
		$CI = & get_instance();

		$columns = 'columns: [';
		$columnDefs = 'columnDefs: [';
		$columnCount = 0;
		$filters = '';
		if (isset($tableData['columns']))
		{
			foreach ($tableData['columns'] as $Property)
			{
				$className = isset($Property['class']) ? ', "className": "' . $Property['class'] . '"' : '';
				$render = isset($Property['render']) ? ', "render": ' . $Property['render'] : '';
				$visible = isset($Property['visible']) ? ', "visible": ' . $Property['visible'] : '';
				$searchable = isset($Property['searchable']) ? ', "searchable": ' . $Property['searchable'] : '';
				$sortable = isset($Property['sortable']) ? ', "sortable": ' . $Property['sortable'] : '';
				$orderData = isset($Property['orderData']) ? ', "orderData": ' . json_encode($Property['orderData']) : '';
				$columns .= '{"data": "' . $Property['data'] . '"},';
				$columnDefs .= '{'
					. '"targets": ' . $columnCount . ', '
					. '"width": "' . $Property['width'] . '%"'
					. $className . $render . $visible . $searchable . $sortable . $orderData
					. '}, ';
				$filters .= isset($Property['filter_name']) ? '$("#' . $Property['filter_name'] . '").change(function() {var key = $(this).find(\'option:selected\').val(); var val = this.options[this.selectedIndex].text; ' . $tableData['table_id'] . '.column(' . $columnCount . ').search(key !== "Todos" ? val : "").draw(); });' . "\n" : '';
				$columnCount++;
			}
		}
		$columns .= '],';
		$columnDefs .= '],';

		$tableJS = '<script type="text/javascript">';

		$tableJS .= '
					
		';

		$tableJS .= 'var post = "";
					var after = localStorage.getItem("'.$tableData['table_id'].'");
					if(after !== null){
						after = JSON.parse(after);
						var values = [];
						if(after.length > 0){
							$.each(after, function(i, val){
								var temp = (val.id).split("_");
								var name = temp[0];
								var query = temp[1];
								var value = val.data;
								values.push({"name":name, "value":value, "query":query});
							});
							post = JSON.stringify(values);
						}
					}
		';
		$tableJS .= '$(document).ready(renderizarTabla_'.$tableData['table_id'].' = function() {' . "\n";
		$tableJS .= '$.fn.dataTable.moment("DD/MM/YYYY");';
		$tableJS .= (isset($tableData['reuse_var']) && $tableData['reuse_var']) ? '' : 'var ';
		$tableJS .= $tableData['table_id'] . ' = $("#' . $tableData['table_id'] . '").DataTable({';
		if (isset($tableData['paging']))
		{
			$tableJS .= 'paging: ' . $tableData['paging'] . ', ';
		}
		if (isset($tableData['order']))
		{
			$tableJS .= 'order: ' . json_encode($tableData['order']) . ', ';
		}
		if (isset($tableData['fnHeaderCallback']))
		{
			$tableJS .= 'fnHeaderCallback: ' . str_replace('"', '', json_encode($tableData['fnHeaderCallback'], JSON_UNESCAPED_SLASHES)) . ',';
		}
		if (isset($tableData['fnRowCallback']))
		{
			$tableJS .= 'fnRowCallback: ' . str_replace('"', '', json_encode($tableData['fnRowCallback'], JSON_UNESCAPED_SLASHES)) . ',';
		}
		if (isset($tableData['initComplete']))
		{
			$tableJS .= 'initComplete: ' . str_replace('"', '', json_encode($tableData['initComplete'], JSON_UNESCAPED_SLASHES)) . ',';
		}
		if (isset($tableData['disableLengthChange']) && $tableData['disableLengthChange'])
		{
			$tableJS .= 'lengthChange: false,';
		}
		if (isset($tableData['disableSearching']) && $tableData['disableSearching'])
		{
			$tableJS .= 'searching: false,';
		}
		if (isset($tableData['disableOrdering']) && $tableData['disableOrdering'])
		{
			$tableJS .= 'ordering: false,';
		}
		if (isset($tableData['dom']))
		{
			$tableJS .= 'dom: \'' . $tableData['dom'] . '\', ';
		}
		$tableJS .= 'processing: true, '
			. 'serverSide: true, '
			. 'autoWidth: false, '
			. 'info: false, '
			. 'deferRender: true, '
			. 'language: {"url": "plugins/datatables/spanish.json"}, ';
		$tableJS .= 'ajax: {'
			. 'url: "' . $tableData['source_url'] . '", '
			. 'type: "POST", '
			. 'data: {' . $CI->security->get_csrf_token_name() . ':"' . $CI->security->get_csrf_hash() . '", data: post}}, ';

		$tableJS .= $columns;
		$tableJS .= $columnDefs;
		$tableJS .= 'colReorder: true,'
			. 'drawCallback: function(setting){
				if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
					$("#'.$tableData['table_id'].'_paginate").css("display", "block");     
				} else {                
					$("#'.$tableData['table_id'].'_paginate").css("display", "none");
				}
				
			}, ';
		$tableJS .= '});' . "\n";
		
		$tableJS .= $filters;
		$tableJS .= '});';
                $tableJS .= "\n";
		$tableJS .= '</script>';
		$data = "[";
		foreach($tableData['columns'] as $Column){
			$data .= "'".$Column['sort']."_".$Column['query']."',";
		}
		
		$pos = strrpos($data, ',');
		if($pos !== false){
			$data = substr_replace($data, ']', $pos, strlen(','));
		}
		
		if (isset($tableData['footer']) && $tableData['footer'])
		{
			$tableJS .= "<script type='text/javascript'>
					var {$tableData['table_id']}_data = $data;
					
					$(document).ready(function() {
						var n = 0;
						$('#{$tableData['table_id']} tfoot th').each(function() {
							var title = $(this).text();
							var id = {$tableData['table_id']}_data[n];
							if(title!=='')
								$(this).html('<input style=\"width: 100%;\" type=\"text\" placeholder=\"'+title+'\" id= '+id+' />');

							n++;
						}).promise().done( function(){ 
							completarFiltros(); 
						});

						{$tableData['table_id']}.columns().every(function() {
							var that = this;
							$('input', {$tableData['table_id']}.table().footer().children[0].children[this[0][0]])
							.on('change', function() {
								//console.log('asasd');
							})
							.on('keypress', function(e) {
								var charCode = e.which || e.keyCode;
								if (charCode == 13) {
									var values = [];
									var filters_data = [];
									var cod_barra = false;
									$('#{$tableData['table_id']}').find('input').each(function(){
										if(cod_barra === true){
											$(this).val('');
										}
										if($(this).val() !== ''){
											var temp = ($(this).attr('id')).split('_');
											var name = temp[0];
											var query = temp[1];
											var value = $(this).val();
											values.push({'name':name, 'value':value, 'query':query});
											if(name !== 'expediente.id'){
												filters_data.push({'id':$(this).attr('id') ,'data': value});
											}
											if(name === 'expediente.id'){
												cod_barra = true;
											}
										}
									});
									saveFiltersData('{$tableData['table_id']}', filters_data);
									$('#". $tableData['table_id'] . "').DataTable().clear().destroy();
									var r = $('#". $tableData['table_id'] ."_filters');
									r.find('th').each(function(){\$(this).css('padding', 8);});
									$('#{$tableData['table_id']} tfoot').append(r);
									$('#search_0').css('text-align', 'center');
									if(values.length > 0){
										post = JSON.stringify(values);
									} else {
										post = '';
									}
									renderizarTabla_".$tableData['table_id']."();
									$('#expediente.ano_where').focus();
								}
							});
						});
					});

					function completarFiltros(){
						var recovery = JSON.parse(localStorage.getItem('{$tableData['table_id']}'));
						if(recovery !== null){
							var c = 0;
							$.each(recovery, function(i, val){
								document.getElementById(val.id).value = val.data;
								c++;
							});
						}
					}

					function saveFiltersData(table, data){
						//localStorage.setItem(table, JSON.stringify(data));
					}
				</script>";
		}
		return $tableJS;
	}
}

if (!function_exists('buildHTML'))
{

	function buildHTML($tableData)
	{
		$tableHTML = '<table id="' . $tableData['table_id'] . '" class="table table-hover table-striped table-bordered table-condensed dt-responsive">'; // nowrap
		$tableHTML .= '<thead>';
		$tableHTML .= '<tr>';
		if (isset($tableData['columns']))
		{
			foreach ($tableData['columns'] as $Column)
			{
				$class = empty($Column['responsive_class']) ? '' : ' class="' . $Column['responsive_class'] . '"';
				$priority = empty($Column['priority']) ? '' : ' data-priority="' . $Column['priority'] . '"';
				$tableHTML .= "<th$class$priority>";
				$tableHTML .= $Column['label'];
				$tableHTML .= "</th>";
			}
		}
		$tableHTML .= '</tr>';
		$tableHTML .= '</thead>';
		if (isset($tableData['footer']) && $tableData['footer'])
		{
			$tableHTML .= '<tfoot>';
			$tableHTML .= '<tr id="'. $tableData['table_id'] .'_filters">';
			if (isset($tableData['columns']))
			{
				foreach ($tableData['columns'] as $Column)
				{
					$tableHTML .= "<th>";
					$tableHTML .= $Column['label'];
					$tableHTML .= "</th>";
				}
			}
			$tableHTML .= '</tr>';
			$tableHTML .= '</tfoot>';
		}
		$tableHTML .= '</table>';

		return $tableHTML;
	}
}