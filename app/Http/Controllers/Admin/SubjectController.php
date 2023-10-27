<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification_admin;
use App\Models\Post;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin.create_subject', compact('noti_small', 'notification_count'));
    }

    public function store(Request $request)
    {
        $subjectName = $request->input('subject_name');

        $existingSubject = Subject::where('name', $subjectName)->first();

        if ($existingSubject) {
            return redirect()->back()->with('error', 'Môn học đã tồn tại trong hệ thống.');
        }

        $subject = new Subject();
        $subject->name = $subjectName;
        $subject->save();

        return redirect('/admin/manage_subject')->with('success', 'Môn học đã được thêm mới thành công.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        $subject = Subject::find($id);
        return view('admin/edit_subject', compact('subject', 'noti_small', 'notification_count'));
    }


    public function destroy($id)
    {
         //Xóa các bài post liên quan đến môn học
         $posts = Post::where('subject', $id)->get();
         foreach ($posts as $post) {
             $post->delete();
         }

        // Tìm và xóa môn học
        $subject = Subject::find($id);
        $subject->delete();

        return response()->json(['message' => 'Xóa môn học thành công']);
    }


    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);
        $subjectName = $request->input('subject_name');

        $existingSubject = Subject::where('name', $subjectName)
            ->where('id', '!=', $subject->id)
            ->first();

        if ($existingSubject) {
            return redirect()->back()->with('error', 'Môn học đã tồn tại trong hệ thống.');
        }

        $subject->name = $subjectName;
        $subject->save();

        return redirect('/admin/manage_subject')->with('success', 'Môn học đã được chỉnh sửa thành công.');
    }
}
