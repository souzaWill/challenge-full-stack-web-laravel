<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\Students\StudentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    public function __construct(protected StudentServiceInterface $studentService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Student::class);

        if ($request->search) {
            $students = $this->studentService->findByUserName(
                $request->search,
            );

            return StudentResource::collection($students);

        }

        $students = $this->studentService->list(
            $request->per_page,
        );

        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $student = $this->studentService->create($request->validated());

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        Gate::authorize('view', $student);

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student = $this->studentService->update(
            $student,
            $request->validated()
        );

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Gate::authorize('delete', $student);

        $student = $this->studentService->delete(
            $student
        );

        return response()->noContent();
    }
}
