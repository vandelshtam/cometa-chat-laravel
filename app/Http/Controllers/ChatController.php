<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\URL;

class ChatController extends Controller
{
    public $roomId, $userId, $message;

    public function index()
    {
        $data["friends"] = User::whereNot("id", auth()->user()->id)->get();

        return view("chat", $data);
    }

    /**
     * save chat message.
     *
     * @param Request $request
     * @return Illuminate\Http\jsonResponse
     */
    public function saveMessage(Request $request){

         $roomId = $request->roomId;
         $userId = auth()->user()->id;
         $message = $request->message;

//        $roomId = 'pi7ygj2k56s';
//  llllll
      $userId = '2e5lbocz8ys';
//        $message = 'test test test';


        //broadcast(new \App\Events\HelloEvent($message));
        broadcast(new \App\Events\SendMessage($roomId, $userId, $message ));

         Message::create([
             "room_id"=>$roomId,
             "user_id"=>$userId,
             "message"=>$message,
         ]);

        return response()->json([
            "success" => true,
            "message" => "Message success stored",
            "data" => $message,
        ]);
    }

    /**
     * load message.
     *
     * @param $roomId
     * @return Illuminate\Http\jsonResponse
     */

    public function LoadMessage(){
        $message = Message::where("room_id", 1)->orderBy("id", "asc")->get();
        return response()->json([
            "success" => true,
            "data" => $message,
            "message" => "Message success loaded",

        ]);
    }

}
