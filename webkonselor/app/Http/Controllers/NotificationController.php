<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Client as MongoClient;
use App\Events\NewUrgentStudentNotification;

class NotificationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'mahasiswa_id' => 'required',
            'nama' => 'required',
            'label' => 'required',
        ]);

        $client = new MongoClient(env('MONGODB_URI'));
        $db = $client->{env('MONGODB_DATABASE', 'monitoring')};
        $collection = $db->notifications;

        $notification = [
            'mahasiswa_id' => $data['mahasiswa_id'],
            'nama' => $data['nama'],
            'label' => $data['label'],
            'status' => 'unread',
            'created_at' => now(),
        ];
        $collection->insertOne($notification);

        // Broadcast event
        broadcast(new NewUrgentStudentNotification($notification))->toOthers();

        return response()->json(['success' => true, 'notification' => $notification]);
    }

    public function fetch()
    {
        $client = new MongoClient(env('MONGODB_URI'));
        $db = $client->{env('MONGODB_DATABASE', 'monitoring')};
        $collection = $db->notifications;
        $notifications = $collection->find(['status' => 'unread'], [
            'sort' => ['created_at' => -1],
            'limit' => 10
        ]);
        $result = [];
        foreach ($notifications as $notif) {
            $result[] = [
                'mahasiswa_id' => $notif['mahasiswa_id'],
                'nama' => $notif['nama'],
                'label' => $notif['label'],
                'created_at' => $notif['created_at'],
            ];
        }
        return response()->json(['notifications' => $result]);
    }
}
