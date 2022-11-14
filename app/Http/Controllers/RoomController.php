<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RoomController extends Controller
{
    /**
     * create and check room.
     *
     * @param Request $request
     * @return Illuminate\Http\jsonResponse
     */
    public function create(Request $request){

        $me = auth()->user()->id;
        $friend = $request->friend_id;

        // $me = 1;
        // $friend = 2;

        $room = Room::where("users", $me.":".$friend)
            //->orWhere("users", $friend.":".$me)
            ->first();
        if($room){
            $dataRoom = $room;
        }
        else{
            $dataRoom = Room::create([
                "users" => $me.":".$friend
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Message success create and check room",
            "data" => $dataRoom,
        ]);
    }


    /**
     *
     * @return Illuminate\Http\jsonResponse
     */
    public function me(){


        //$me = 1;
        $me = auth()->user()->id;

        return response()->json([
            "success" => true,
            "message" => "success me",
            "data" => $me,
        ]);
    }
}
