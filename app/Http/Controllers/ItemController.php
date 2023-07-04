<?php

//controller
namespace App\Http\Controllers;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemView()
    { //CHANGE TO USE COLUMN NAMES OF TASKS TABLE
    	$panddingItem = Item::where('status',0)
		                    ->orderBy('order')
							->get();
    	$completeItem = Item::where('status',1)
		                    ->orderBy('order')
							->get();
    	return view('test',compact('panddingItem','completeItem'));
    }
    public function updateItems(Request $request)
    { 
	  //MODIFY TASK TABLE TO INCLUDE 'STATUS' AND 'ORDER' COLUMNS.
	  //consider using strings for status such as 'pending' and 'complete'
    	$input = $request->all();
        
		if(!empty($input['pending']))
    	{
			foreach ($input['pending'] as $key => $value) {
				$key = $key + 1;
				Item::where('id',$value)
						->update([
							'status'=> 0,
							'order'=>$key
						]);
			}
		}
        
		if(!empty($input['accept']))
    	{
			foreach ($input['accept'] as $key => $value) {
				$key = $key + 1;
				Item::where('id',$value)
						->update([
							'status'=> 1,
							'order'=>$key
						]);
			}
		}
    	return response()->json(['status'=>'success']);
    }
}