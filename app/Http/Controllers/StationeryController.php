<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\DB;
use DB;

class StationeryController extends Controller
{
    public function create()
	{	
		$company = DB::table('departmentDDA')->select('comp')->distinct()->pluck('comp');
		//var_dump($company);
		//$company_list1 = DB::table('DepartmentDDA')->select('comp')->distinct()->get();
		//$company_list2 = json_encode($company_list1,JSON_PRETTY_PRINT);
		//return view('form')->with('company',json_decode($company_list2,JSON_PRETTY_PRINT));
		return view('StationeryForm',compact('company'));
	}
	
	public function store(Request $request)
	{
		$v = $request->validate([
			'comp' => 'required',
			'item_code[]' => 'required',
			
		]);
		if ($v->fails())
		{
			return redirect()->back()
			->withErrors($v)
			->withInput(Input::all());
		}	
		//print_r($validation);
		$comp = $request->input('comp');
		$input = Input::all();
		return $input;
	}
	
	public function fetch(Request $request)
	{
		if($request->get('dependent')== 'div' && $request->get('value') ){
			$comp = $request->get('value');
			$dependent = $request->get('dependent');
			$data = DB::table('departmentDDA')->where('comp', $comp)->select($dependent)->distinct()->get();
			//var_dump(json_decode($data,JSON_PRETTY_PRINT));
			$output ='<option value = ""></option>';
			foreach($data as $row)
			{
				$output .= '<option value="'.$row -> $dependent.'">'.$row -> $dependent.'</option>';				
			}
			echo $output;
		}
		
		//when division change
		if($request->get('dependent')== 'dept' && $request->get('value') ){
			$comp      = $request->get('comp');
			$div       = $request->get('value');
			$dependent = $request->get('dependent');
			$data = DB::table('departmentDDA')->where('comp',$comp)->where('div',$div)
				->select($dependent)
				->distinct()
				->get();
			$output ='<option value = ""></option>';
			 foreach($data as $row)
			 {
				 $output .= '<option value="'.$row -> $dependent.'">'.$row -> $dependent.'</option>';				
			 }
			echo $output;
		}
		if($request->get('dependent')== 'area' && $request->get('value') ){
			$comp      = $request->get('comp');
			$div       = $request->get('div');
			$dept      = $request->get('value');
			$dependent = $request->get('dependent');
			$data = DB::table('departmentDDA')->where('comp',$comp)->where('div',$div)->where('dept', $dept)
				->select($dependent)
				->distinct()
				->get();
			$output ='<option value = 0></option>';
			foreach($data as $row)
			{
				$output .= '<option value="'.$row -> $dependent.'">'.$row -> $dependent.'</option>';				
			}
			echo $output;
		}		

	}

	public function items(Request $request)
	{
		$data  = DB::table('items')->where('type',$request->type)->pluck('description','itemNo');
		$output ='<option value = 0>Select item</option>';
		foreach($data as $key => $value)
		{
			$output .= '<option value="'.$key.'">'.$value.'</option>';
		}
		echo $output;
	}
	
    public function unitOfMeasure(Request $request)
	{
		$data  = DB::table('items')
			->where('type',$request->item_type)->where('itemNo',$request->item_code)
			->pluck('unit');
		foreach($data as $key => $value)
		{
			$output = $value;
		}		
		echo $output;
		
	}
}
