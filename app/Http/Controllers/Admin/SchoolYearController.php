<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification_admin;
use App\Models\Post;
use App\Models\School_year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        return view('admin/school_years_add', compact('noti_small', 'notification_count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'year.required' => 'Vui lòng nhập năm.',
            'year.date_format' => 'Năm không đúng định dạng.',
            'name.required' => 'Vui lòng nhập tên khóa.',
            'name.numeric' => 'Tên khóa phải là số.',
            'duplicate_year' => 'Niên khóa đã tồn tại.',
        ];

        // Kiểm tra điều kiện dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'year' => 'required|date_format:Y',
            'name' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lấy thông tin từ request
        $year = $request->input('year');
        $name = $request->input('name');

        // Kiểm tra nếu đã tồn tại niên khóa
        $existingSchoolYear = School_year::where('year', $year)->orWhere('name', $name)->exists();

        if ($existingSchoolYear) {
            $validator->errors()->add('duplicate_year', $messages['duplicate_year']);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tạo mới niên khóa
        $schoolYear = new School_year;
        $schoolYear->year = $year;
        $schoolYear->name = $name;
        $schoolYear->save();

        return redirect('/admin/school_years')->with('success', 'Tạo mới niên khóa thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noti_small = Notification_admin::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $notification_count = Notification_admin::where('status', 'new')->count();
        $school_year = School_year::find($id);
        return view('admin/school_years_edit', compact('school_year', 'noti_small', 'notification_count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'year.required' => 'Vui lòng nhập năm.',
            'year.date_format' => 'Năm không đúng định dạng.',
            'name.required' => 'Vui lòng nhập tên khóa.',
            'name.numeric' => 'Tên khóa phải là số.',
            'duplicate_year' => 'Niên khóa đã tồn tại.',
        ];

        // Kiểm tra điều kiện dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'year' => 'required|date_format:Y',
            'name' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Lấy thông tin chỉnh sửa từ request
        $schoolYearId = $request->input('id_school_year');
        $year = $request->input('year');
        $name = $request->input('name');

        // Tìm và cập nhật thông tin niên khóa
        $schoolYear = School_year::find($schoolYearId);
        $schoolYear->year = $year;
        $schoolYear->name = $name;
        $schoolYear->save();

        return redirect('/admin/school_years')->with('success', 'Chỉnh sửa niên khóa thành công');
    }

    public function destroy(Request $request)
    {
        //Xóa các bài post liên quan đến niên khóa này
        $posts = Post::where('school_year', $request->id)->get();
        foreach ($posts as $post) {
            $post->delete();
        }

        // Tìm và xóa niên khóa
        $schoolYear = School_year::find($request->id);
        $schoolYear->delete();

        return response()->json(['message' => 'Xóa niên khóa thành công']);
    }
}
