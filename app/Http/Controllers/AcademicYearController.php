<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYearValidation;
use App\Http\Resources\AcademicYearsResource;
use App\Http\Resources\Timetables\AcademicYearsResource as T_AcademicYearsResource;
use App\Models\AcademicYear;
use App\Models\Campus;
use Illuminate\Support\Facades\Auth;

class AcademicYearController extends Controller
{
    public function show(Campus $campus)
    {
        $years = AcademicYearsResource::collection($campus->academicYears);
        return response($years);
    }

    public function create(AcademicYearValidation $request)
    {
        $teacher = new AcademicYear();
        $teacher->campus_id = $request->campus_id;
        $teacher->year_id = $request->year_id;
        $teacher->save();
        return response([], 201);
    }

    public function years(Campus $campus)
    {
        $whereNotIn = $campus->academicYears->pluck('year_id');
        return response(Auth::user()->years()->whereNotIn('id', $whereNotIn)->get());
    }

    public function destroy(AcademicYear $academicYear)
    {
        return response(['count' => $academicYear->groups()->count()]);
    }

    public function destroyDelete(AcademicYear $academicYear)
    {
        if($academicYear->groups()->count() > 0)
            return response([], 400);

        $academicYear->delete();
        return response([], 202);
    }


    public function timetableShow()
    {
        $data = Auth::user()->campus->academicYears;
        return response(T_AcademicYearsResource::collection($data));
    }
}
