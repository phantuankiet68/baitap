<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Remind;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class RemindController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'start'=> 'required',
            'user_id'=> 'required',
       ]);
       if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }
        else{
            $remind = Remind::create([
                'title' => $request->title,
                'start' => $request->start,
                'user_id' => $request->user_id,
            ]);
            if($remind ){
                return response()->json([
                    'status' => 200,
                    'message' => 'Reminds create sucessfully',
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                ], 500);
            }
        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'start' => 'required',
       ]);
       if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
        else{
            $remind = Remind::find($id);
            if($remind){
                $remind->title = $request->title;
                $remind->start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
                $remind->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Update sucessfully',
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Something Went Wrong',
                ], 404);
            }
        }
    }
    public function delete($id){
        $remind = Remind::find($id);
        $remind->delete();
        return response()->json([
            'message' => 'delete success',
        ]); 
    }
}
