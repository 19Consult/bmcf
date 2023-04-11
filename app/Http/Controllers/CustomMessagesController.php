<?php

namespace App\Http\Controllers;

//use Chatify\Facades\ChatifyMessenger as Chatify;
use Chatify\Facades\ChatifyMessenger as Chatify;
//use Illuminate\Foundation\Auth\User;
use App\Models\User;
use App\Models\NdaProjects;

use App\Models\ChMessage;

use Illuminate\Http\Request;
use Chatify\Http\Controllers\MessagesController as ChatifyMessagesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class CustomMessagesController extends ChatifyMessagesController
{

    public function search(Request $request)
    {
        $getRecords = null;
        $input = trim(filter_var($request['input']));
        $records = User::where('id','!=',Auth::user()->id)
            ->where('name', 'LIKE', "%{$input}%")
            ->with('detail')
            ->paginate($request->per_page ?? $this->perPage);
        foreach ($records->items() as $record) {

            $condition1 = NdaProjects::where('user_id', $record->id)
                ->where('owner_pr_id', Auth::id())
                ->where('status', 'signed')
                ->exists();
            $condition2 = NdaProjects::where('user_id', Auth::id())
                ->where('owner_pr_id', $record->id)
                ->where('status', 'signed')
                ->exists();
            $result = ($condition1 || $condition2);
            if(!$result){
                continue;
            }

            $getRecords .= view('Chatify::layouts.listItem', [
                'get' => 'search_item',
                'user' => Chatify::getUserWithAvatar($record),
            ])->render();
        }
        if($records->total() < 1){
            $getRecords = '<p class="message-hint center-el"><span>Nothing to show.</span></p>';
        }
        // send the response
        return Response::json([
            'records' => $getRecords,
            'total' => $records->total(),
            'last_page' => $records->lastPage(),
            'test' => 'test3339999',
        ], 200);
    }


    public static function getNotSeeMessage(){
        // Получаем ID текущего пользователя
        $user_id = auth()->id();

        // Проверяем наличие непрочитанных сообщений
        $unread_count = ChMessage::where('to_id', $user_id)->where('seen', 0)->count();

        // Получаем список отправителей непрочитанных сообщений
        $unseen_senders = User::select('users.id', 'users.name')
            ->join('ch_messages', 'users.id', '=', 'ch_messages.from_id')
            ->where('ch_messages.to_id', $user_id)
            ->where('ch_messages.seen', 0)
            ->groupBy('users.id')
            ->get();

        // Возвращаем результаты
        //return ['unread_count' => $unread_count, 'unseen_senders' => $unseen_senders];

        return [
            'unread_count' => $unread_count,
            'unseen_senders' => $unseen_senders,
        ];

    }

}
