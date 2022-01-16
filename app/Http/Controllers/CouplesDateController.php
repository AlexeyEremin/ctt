<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouplesDate\GetResource;
use App\Models\AcademicYear;
use App\Models\CouplesDate;
use Illuminate\Http\Request;

class CouplesDateController extends Controller
{
    public function show(AcademicYear $academicYear)
    {
        return response(GetResource::collection($academicYear->coulpesDates));
    }

    public function create(Request $request)
    {
        $couplesDate = new CouplesDate();
        $couplesDate->date = $request->date;
        $couplesDate->academic_year_id = $request->year;
        $couplesDate->save();

        return response([], 201);
    }

    public function groups(CouplesDate $couplesDate)
    {
        return response($couplesDate->academicYear->groups);
    }
}
