<?php

namespace App\Http\Controllers;

use App\Http\Requests\YearValidation;
use App\Http\Resources\TeacherResource;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;

class YearController extends Controller
{
    public function show()
    {
        $years = TeacherResource::collection(Auth::user()->years);
        return response($years);
    }

    public function create(YearValidation $request)
    {
        $teacher = new Year();
        $teacher->year = $request->year;
        $teacher->name = $request->name;
        $teacher->organization_id = Auth::user()->organization_id;
        $teacher->save();
        return response([], 201);
    }

    public function destroy(Year $year)
    {
        return response(['count' => $year->academicYears()->count()]);
    }

    public function destroyDelete(Year $year)
    {
        if($year->academicYears()->count() > 0)
            return response([], 400);

        $year->delete();
        return response([], 202);
    }
}
