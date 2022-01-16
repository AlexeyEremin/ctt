<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\CouplesDateController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupDisciplineController;
use App\Http\Controllers\HorlyLoadController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\LessonTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function() {
    Route::get('user-data', [UserController::class, 'user']);
    Route::get('logout', [UserController::class, 'logout']);

    # Creator System
    Route::middleware('access:creator')->group(function() {
        Route::prefix('teacher')->group(function() {
            Route::get('/', [TeacherController::class, 'show']);
            Route::post('/create', [TeacherController::class, 'create']);
            Route::post('/create-list', [TeacherController::class, 'createList']);
            Route::post('/edit/{teacher}', [TeacherController::class, 'edit']);
            Route::get('/destroy/{teacher}', [TeacherController::class, 'destroy']);
            Route::delete('/destroy/{teacher}', [TeacherController::class, 'destroyDelete']);
        });
        Route::prefix('discipline')->group(function() {
            Route::get('/', [DisciplineController::class, 'show']);
            Route::post('/create', [DisciplineController::class, 'create']);
            Route::post('/create-list', [DisciplineController::class, 'createList']);
            Route::post('/edit/{discipline}', [DisciplineController::class, 'edit']);
            Route::get('/destroy/{discipline}', [DisciplineController::class, 'destroy']);
            Route::delete('/destroy/{discipline}', [DisciplineController::class, 'destroyDelete']);

            Route::prefix('teachers')->group(function() {
                Route::get('/{discipline}', [DisciplineController::class, 'teacherDiscipline']);
                Route::post('/{discipline}', [DisciplineController::class, 'teacherDisciplineCreate']);
                Route::delete('/{discipline}', [DisciplineController::class, 'teacherDisciplineDestroy']);
            });
        });
        Route::prefix('campus')->group(function() {
            Route::get('/', [CampusController::class, 'show']);
            Route::post('/create', [CampusController::class, 'create']);
            Route::post('/create-list', [CampusController::class, 'createList']);
            Route::post('/edit/{campus}', [CampusController::class, 'edit']);
            Route::get('/destroy/{campus}', [CampusController::class, 'destroy']);
            Route::delete('/destroy/{campus}', [CampusController::class, 'destroyDelete']);
        });
        Route::prefix('user')->group(function() {
            Route::get('/', [UserController::class, 'show']);

            Route::get('/campuses', [UserController::class, 'campuses']);

            Route::post('/create', [UserController::class, 'create']);
            Route::post('/edit/{user}', [UserController::class, 'edit']);
            Route::get('/destroy/{user}', [UserController::class, 'destroy']);
            Route::delete('/destroy/{user}', [UserController::class, 'destroyDelete']);
        });
        Route::prefix('lesson-type')->group(function() {
            Route::get('/', [LessonTypeController::class, 'show']);
            Route::post('/create', [LessonTypeController::class, 'create']);
            Route::post('/edit/{lessonType}', [LessonTypeController::class, 'edit']);
            Route::get('/edit/{lessonType}/{checkbox}', [LessonTypeController::class, 'editCheckbox']);
            Route::get('/destroy/{lessonType}', [LessonTypeController::class, 'destroy']);
            Route::delete('/destroy/{lessonType}', [LessonTypeController::class, 'destroyDelete']);
        });
        Route::prefix('year')->group(function() {
            Route::get('/', [YearController::class, 'show']);
            Route::post('/create', [YearController::class, 'create']);
            Route::get('/destroy/{year}', [YearController::class, 'destroy']);
            Route::delete('/destroy/{year}', [YearController::class, 'destroyDelete']);
        });
        Route::prefix('academic-years')->group(function(){
            Route::post('/create', [AcademicYearController::class, 'create']);
            Route::get('/destroy/{academicYear}', [AcademicYearController::class, 'destroy']);
            Route::delete('/destroy/{academicYear}', [AcademicYearController::class, 'destroyDelete']);
            Route::get('/{campus}', [AcademicYearController::class, 'show']);
            Route::get('/{campus}/years', [AcademicYearController::class, 'years']);
        });
        Route::prefix('group')->group(function() {
            Route::post('/create', [GroupController::class, 'create']);
            Route::post('/create-list', [GroupController::class, 'createList']);
            Route::post('/edit/{group}', [GroupController::class, 'edit']);
            Route::get('/destroy/{group}', [GroupController::class, 'destroy']);
            Route::delete('/destroy/{group}', [GroupController::class, 'destroyDelete']);

            Route::get('/disciplines/{group}', [GroupDisciplineController::class, 'show']);
            Route::post('/disciplines/{group}', [GroupDisciplineController::class, 'createOrDestroy']);
            Route::get('/{academicYear}', [GroupController::class, 'show']);
        });
        Route::prefix('hourly-load')->group(function() {
            Route::post('create', [HorlyLoadController::class, 'create']);
            Route::post('update/{horlyLoad}', [HorlyLoadController::class, 'update']);
            Route::get('/discipline/{groupDiscipline}', [HorlyLoadController::class, 'showTeacher']);
            Route::get('/{group}', [HorlyLoadController::class, 'show']);
        });
    });

    # Timetables
    Route::middleware('access:timetable')->group(function() {
        Route::get('academy-years', [AcademicYearController::class, 'timetableShow']);
        Route::get('couples-dates/{academicYear}', [CouplesDateController::class, 'show']);
        Route::post('couples-dates', [CouplesDateController::class, 'create']);
        Route::get('group-disciplines/{group}', [ScheduleController::class, 'groupDisciplines']);
        Route::post('schedule/create', [ScheduleController::class, 'createAndDestroy']);

        Route::prefix('timetables/{couplesDate}')->group(function() {
            Route::get('groups', [CouplesDateController::class, 'groups']);
            Route::get('open/{group}', [ScheduleController::class, 'open']);
            Route::get('schedule', [ScheduleController::class, 'schedule']);
            Route::get('scheduleTeacher', [ScheduleController::class, 'scheduleTeacher']);
        });
    });
});
