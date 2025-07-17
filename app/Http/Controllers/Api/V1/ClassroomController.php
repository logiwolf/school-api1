<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClassroomRequest;
use App\Models\Classroom;
use Illuminate\Http\JsonResponse;

class ClassroomController extends Controller
{
    /**
     * Store a newly created classroom in storage.
     */
    public function index(): JsonResponse
    {
        $classrooms = Classroom::with('students')->get();

        return response()->json([
            'data' => $classrooms,
        ]);
    }

    public function show($id)
    {
        $classroom = Classroom::with('students')->find($id);

        if (!$classroom) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        return response()->json($classroom);
    }


    public function store(StoreClassroomRequest $request): JsonResponse
    {
        $classroom = Classroom::create($request->only(['name', 'section', 'max_students']));

        if ($request->has('student_ids')) {
            $classroom->students()->sync($request->student_ids);
        }

        return response()->json([
            'message' => 'Classroom created successfully',
            'data' => $classroom->load('students'),
        ]);
    }

    public function update(StoreClassroomRequest $request, Classroom $classroom)
    {
        $classroom->update($request->validated());

        return response()->json([
            'message' => 'Classroom updated successfully',
            'data' => $classroom
        ]);
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return response()->json([
            'message' => 'Classroom deleted successfully'
        ]);
    }

    public function assignStudent(Request $request, Classroom $classroom): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        if ($classroom->students()->count() >= $classroom->max_students) {
            return response()->json([
                'message' => 'Classroom is full, cannot assign more students.'
            ], 422);
        }

        // Attach student without removing existing ones
        $classroom->students()->syncWithoutDetaching($validated['student_id']);

        return response()->json([
            'message' => 'Student assigned successfully to the classroom.'
        ]);
    }
}
