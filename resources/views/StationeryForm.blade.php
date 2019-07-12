@extends('master')
@section('title', 'Stationery form ')
@section('content')	
<div class = container>
	<h2> Stationery form </h2>
	<form method="post" action="/StationeryForm" enctype="multipart/form-data">
        {{ csrf_field() }}
		<div class = "row">
			<div class = "form-group col-md-6" >
				{!!Form::label('formID','Form id:','System auto-generated id')!!}
				{!!Form::text('formID',null,['class' =>'form-control'])!!}
			</div>			
			<div class = "form-group col-md-6" >
				{!!Form::label('ApplicationNum','Application reference number:')!!}
				{!!Form::text('ApplicationNum',null,['class' =>'form-control'])!!}
			</div>
		</div>
		<div class = "row" >
			<div class = 'form-group col-md-3'  >
				<label for="comp">Company</label>
				<select name="comp" id="comp" class="form-control" data-dependent="div">
					 <option value=""></option>
					 @foreach($company as $key => $value)
					 <option value="{{$value}}">{{ $value}}</option>
					 @endforeach
				</select>				
			</div>			
			<div class = 'form-group col-md-3' >
				<label for="div">Division</label>
				<select name="div" id="div" class="form-control"  data-dependent="dept">
                </select>
			</div>			
			<div class = 'form-group col-md-3' >
				<label for="dept">Department</label>
				<select name="dept" id="dept" class="form-control" data-dependent="area">
				</select>
			</div>			
			<div class = 'form-group col-md-3' >
				<label for="area">Area/Proj</label>
				<select name="area" id="area" class="form-control">
				</select>
			</div>
		</div>
		
		<div class = "row">
			<div class = 'form-group col-md-3' >
				<label for="applier">Name of application </label>
				<input type = "text" id="applier" readonly class = "form-control", value ="{{Auth::user()->name}}">
			</div>		
			<div class = 'form-group col-md-3' >
				<label for ="phone" >Phone number</label>
				<input type = "text" id="phone" class = "form-control">
			</div>	
			<div class = 'form-group col-md-3' >
				<label > Next approver </label>
				<select class="form-control" name="approver">
					<option value = 0>Select approver</option>
				 </select>
			</div>	
		</div>
		<br>
		
		<div class = "table-responsive-sm">
			<table class="table" id="item_table">
			<caption> List of items </caption>
			<thead>
			  <tr>
			   <th class =col-md-3>Catelog</th>
			   <th class =col-md-3>Item</th>
			   <th class =col-md-3>Description</th>
			   <th class =col-md-1>UOM</th>
			   <th class =col-md-1>Quantity</th>
			   <th class =col-md-1><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
			  </tr
			  <thead>
			  <tbody>
			  <tr>
			  	<td>
					<select class="form-control item_type" name="item_type[]">
					<?php echo fill_unit_select_type(); ?>
					</select>
				</td>
				<td>
					<select class="form-control item_code" name="item_code[]">
					</select>
				</td>
			    <td ><input type = "text" readonly name = "item_name[]" class = "form-control iten_name"></td>
			    <td><input type = "text" readonly  name = "item_unit[]" class = "form-control item_unit"></td>
			    <td><input type = "text" name ="item_quantity[]" class = "form-control"></td>
			    <td></td>
			  </tr>
			  </tbody>
			</table>
		</div>
		
		<br/>
		<div class = "from-group col-md-2 row">
			<button type="submit" name="submit" id="submit" class="btn btn-info btn-lg">Submit</button>
		</div>
	</form>
	<br><br>
	@if($errors -> any())
	<div>
		<ul>
			@foreach($errors->all() as $error)
			<li>{{$error}}</li>
			@endforeach
		</ul>
		
	</div>
	@endif
<script >
$(document).ready(function(){
	$("#comp").change(function(){
		$('#div').val('');
		$('#dept').val('');
		$('#area').val('');
		if($(this).val() != '')
		{
			var value     = $(this).val();
			var dependent = $(this).data('dependent');
			var _token    = $('input[name = _token]').val();
 			$.ajax({
				url:"{{url('/form/fetch')}}",
				method:"POST",
				data:{value:value,_token :_token, dependent:dependent},
				success:function(result)
				{
					$('#'+dependent).html(result);
				}
			}); 
		}
	 });
	$("#div").change(function(){
		$('#dept').val('');
		$('#area').val('');
		if($(this).val() != '')
		{
			var comp      = $("#comp").val();
			var value     = $(this).val(); //div
			var dependent = $(this).data('dependent');
			var _token    = $('input[name = _token]').val();
 			$.ajax({
				url:"{{url('/form/fetch')}}",
				method:"POST",
				data:{comp:comp, value:value,_token :_token, dependent:dependent},
				success:function(result)
				{
					$('#'+dependent).html(result);
				}
			}); 
		}
	 });
	$("#dept").change(function(){
		$('#area').val('');
		if($(this).val() != '')
		{
			var comp      = $('#comp').val();
			var div       = $('#div').val();
			var value     = $(this).val();
			var dependent = $(this).data('dependent');
			var _token    = $('input[name = _token]').val();
 			$.ajax({
				url:"{{url('/form/fetch')}}",
				method:"POST",
				data:{comp:comp, div:div,value:value,_token :_token, dependent:dependent},
				success:function(result)
				{
					$('#'+dependent).html(result);
				}
			}); 
		}
	 });
	$('.Add').click(function(){
		 var html = '';
		  html += '<tr>';
		  html += '<td><select name="item_type[]" class="form-control item_type"><option value="">Select Type</option><?php echo fill_unit_select_type(); ?></select></td>';
		  html += '<td><select name="item_code[]" class="form-control item_code"></select></td>';	  
		  html += '<td><input type="text" readonly name="item_name[]" class="form-control item_name" /></td>';
		  html += '<td><input type="text" readonly name="item_unit[]" class="form-control item_unit" /></td>';		  
		  html += '<td><input type="text" name="item_quantity[]" class="form-control item_quantity" /></td>';
		  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
		  $('#item_table').append(html);
		 });
	$(document).on('click','.remove',function(){
		$(this).closest('tr').remove();
	});
	
	
	$('.table tbody').on('change','.item_type',function() {
		var tr = $(this).closest('tr');
		var type = $(this).val();
		var _token = $('input[name = _token]').val();
		tr.find('td:eq(1) select').empty();
		tr.find('td:eq(2) input').val("");
		tr.find('td:eq(3) input').val("");
		var html = "";
		html += '<option value="">select 1</option>';
		$.ajax({
			url:"{{url('/form/getItems')}}",
			method:"post",
			data:{type:type,_token : _token},
			success:function(result)
			{
				tr.find('td:eq(1) select').append(result);
			}
		}); 
		
	});	 
	
	$('.table tbody').on('change','.item_code',function() {
		var tr = $(this).closest('tr');
		var item_code = $(this).val();
		var item_type = tr.find('td:eq(0) option:selected').text();
		var item_name = tr.find('td:eq(1) option:selected').text();
		var _token = $('input[name = _token]').val();
		tr.find('td:eq(2) input').val("");
		tr.find('td:eq(3) input').val("");
		tr.find('td:eq(2) input').val(item_name); // input description
		
		$.ajax({
			url:"{{url('/form/getUnit')}}",
			method:"post",
			data:{item_type:item_type, item_code:item_code, _token : _token},
			success:function(result)
			{
				//console.log(result);
				tr.find('td:eq(3) input').val(result);//get unit of measure
			},
			error:function(){
				console.log('error');
			}
		});		
		
	});	 

	
});

<?php 

	function fill_unit_select_type()
	{ 
		$catalog = DB::table('items')->select('type')->distinct()->pluck('type');
		$output = '';
		$output .= '<option value=0>Select Type</option>';
		foreach($catalog as $key => $value)
		{
			$output .='<option value="'.$value.'">'.$value.'</option>';
		}
		return $output;
	}

/* 	function fill_unit_select_item()
	{ 
		$items  = DB::table('items')->where('type','OTHER')->pluck('description','itemNo');
		$output = '';
		$output .= '<option value=""></option>';
		foreach($items as $key => $value)
		{
			$output .='<option value="'.$key.'">'.$value.'</option>';
		}
		return $output;
	} */

?>

</script>

@endsection



