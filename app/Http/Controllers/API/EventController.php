<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Remind;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Event as EventResources;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{
    public function index(Request $request,Event $event){    
        try{
            $user = $request->user();
            $reminds = Remind::all();
            $events = Event::where('user_id',$user->id)->get();
    
            return response()->json([
                'events' => $events,
                'reminds' => $reminds,
                'user' => $user,
            ]);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:150',
            'start'=> 'required',
            'end'=> 'required',
            'color'=> 'required',
            'desc'=> 'required|max:250',
            'user_id'=> 'required',
       ]);
       if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
        else{
            $event = Event::create([
                'title' => $request->title,
                'start' => Carbon::parse($request->start)->format('Y-m-d H:i:s'),
                'end' => Carbon::parse($request->end)->format('Y-m-d H:i:s'),
                'color' => $request->color,
                'desc' => $request->desc,
                'user_id' => $request->user_id,

            ]);
            if($event){
                return response()->json([
                    'status' => 200,
                    'message' => 'Events create sucessfully',
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
            'title' => 'required|max:150',
            'start'=> 'required',
            'end'=> 'required',
            'color'=> 'required',
            'desc'=> 'required|max:250',
       ]);
       if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
        else{
            $event = Event::find($id);
            if($event){
                $event->title = $request->title;
                $event->start = Carbon::parse($request->start)->format('Y-m-d H:i:s');
                $event->end = Carbon::parse($request->end)->format('Y-m-d H:i:s');
                $event->desc = $request->desc;
                $event->color = $request->color;
                $event->update();
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
        $event = Event::find($id);
        $event->delete();
        return response()->json([
            'message' => 'delete success',
        ]); 
    }
}
