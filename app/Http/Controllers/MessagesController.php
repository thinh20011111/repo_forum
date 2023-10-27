<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use App\Services\Message\MessageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessagesController extends Controller
{
    private $messageService;

    public function __construct(MessageServiceInterface $messageService)
    {
        $this->messageService =  $messageService;
    }

    public function index()
    {
        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();


        $userId = auth()->user()->id;

        $conventions = Message::where('sender', $userId)
            ->orWhere('receiver', $userId)
            ->get();

        $userIds = $conventions->pluck('sender')->concat($conventions->pluck('receiver'))->unique();

        $users = User::whereIn('id', $userIds)->get();

        $mergedData = [];
        foreach ($conventions as $message) {
            $displayUserId = ($message->sender == $userId) ? $message->receiver : $message->sender;

            $existingUser = collect($mergedData)->first(function ($item) use ($displayUserId) {
                return $item['displayUser']->id == $displayUserId;
            });

            if (!$existingUser) {
                $displayUser = $users->firstWhere('id', $displayUserId);
                $mergedData[] = [
                    'message' => $message,
                    'displayUser' => $displayUser,
                    'id' => $displayUser->id,
                    'avatar' => $displayUser->avatar,
                    'name' => $displayUser->name,
                ];
            }
        }

        return view('front.messages.index', compact('notifications', 'notificationsCount', 'mergedData'));
    }

    public function conventions(Request $request, $id)
    {
        //thay đổi trạng thái của thông báo
        $data = $request->all();

        $notifications = Notification::where('owner_id', Auth::user()->id)
            ->where('user_id', $id)->where('type', 'message')
            ->get();

        foreach ($notifications as $notification) {
            $notification->status = 'read';
            $notification->save();
        }

        $notifications = Notification::getNotificationsForCurrentUser();
        $notificationsCount = $notifications->where('status', 'new')->count();

        $userId = auth()->user()->id;

        $conventions = Message::where('sender', $userId)
            ->orWhere('receiver', $userId)
            ->get();

        $userIds = $conventions->pluck('sender')->concat($conventions->pluck('receiver'))->unique();

        $users = User::whereIn('id', $userIds)->get();

        $mergedData = [];
        foreach ($conventions as $message) {
            $displayUserId = ($message->sender == $userId) ? $message->receiver : $message->sender;

            $existingUser = collect($mergedData)->first(function ($item) use ($displayUserId) {
                return $item['displayUser']->id == $displayUserId;
            });

            if (!$existingUser) {
                $displayUser = $users->firstWhere('id', $displayUserId);
                $mergedData[] = [
                    'message' => $message,
                    'displayUser' => $displayUser,
                    'id' => $displayUser->id,
                    'avatar' => $displayUser->avatar,
                    'name' => $displayUser->name,
                ];
            }
        }

        $messages = Message::where(function ($query) use ($id) {
            $query->where('sender', Auth::user()->id)
                ->where('receiver', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender', $id)
                ->where('receiver', Auth::user()->id);
        })->orderBy('created_at', 'asc')->get();

        $receiver = User::find($id);

        return view('front.messages.convention', compact('notifications', 'notificationsCount', 'messages', 'receiver', 'mergedData'));
    }

    public function send(Request $request)
    {
        $messages = [
            'content.required' => 'Bạn chưa nhập nội dung bình luận.',
        ];

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], $messages);

        $receiver_id = $request->receiver_id;

        if ($validator->passes()) {
            $data = [
                'sender' => Auth::user()->id,
                'receiver' => $receiver_id,
                'content' => $request->content,
            ];

            if ($message = Message::create($data)) {
                $messages = Message::where(function ($query) use ($receiver_id) {
                    $query->where('sender', Auth::user()->id)
                        ->where('receiver', $receiver_id);
                })->orWhere(function ($query) use ($receiver_id) {
                    $query->where('sender', $receiver_id)
                        ->where('receiver', Auth::user()->id);
                })->orderBy('created_at', 'asc')->get();

                // Tạo thông báo
                $notification = new Notification();
                $notification->owner_id = $message->receiver; // id của người gửi bài viết
                $notification->user_id = Auth::user()->id;
                $notification->message_id = $message->id;
                $notification->content = 'Đã gửi cho bạn một tin nhắn.';
                $notification->status = 'new';
                $notification->type = 'message';
                $notification->save();

                //Lấy số lượng thông báo
                $notificationsCount = Notification::where('user_id', '!=', $message->receiver)->where('owner_id', $message->receiver)->where('status', 'new')->count();

                $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true
                ]);

                $pusher->trigger('messages-channel', 'send-event', [
                    'receiver_id' => $message->receiver,
                    'content' => $message->content,
                    'sender_id' => $message->sender,
                    'receiver_name' => $message->infor_receiver->name,
                    'receiver_avatar' => $message->infor_receiver->avatar,
                    'sender_name' => $message->infor_sender->name,
                    'sender_avatar' => $message->infor_sender->avatar,
                    'time' => formatTime($message->created_at),
                    'notification_id' => $notification->id,
                    'notification_count' => $notificationsCount
                ]);

                return view('front.messages.get-messages', compact('messages'));
            }
        }

        return response()->json(['error' => $validator->errors()->first()]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        // Tìm kiếm người dùng dựa trên tên chứa ký tự được nhập vào
        $users = User::where('name', 'like', '%' . $searchTerm . '%')->get();

        return response()->json($users);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
