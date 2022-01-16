<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCreateValidation;
use App\Http\Resources\TeacherResource;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampusController extends Controller
{
    public function show()
    {
        $data = TeacherResource::collection(Auth::user()->campuses);
        return response($data);
    }

    public function create(TeacherCreateValidation $request)
    {
        $item = new Campus();
        $item->name = $request->name;
        $item->organization_id = Auth::user()->organization_id;
        $item->save();
        return response([], 201);
    }

    public function createList(TeacherCreateValidation $request)
    {
        $campuses = explode(';', $request->name);
        foreach($campuses as $name) {
            $campus = new Campus();
            $campus->name = $name;
            $campus->organization_id = Auth::user()->organization_id;
            $campus->save();
        }
        return response([], 201);
    }

    public function edit(TeacherCreateValidation $request, Campus $campus)
    {
        $campus->name = $request->name;
        $campus->save();
        return response([], 202);
    }

    public function destroy(Campus $campus)
    {
        return response($campus->academicYears());
    }

    public function destroyDelete(Campus $campus)
    {
        if($campus->academicYears()->count() > 0)
            return response([], 400);

        $campus->delete();
        return response([], 202);
    }
}
