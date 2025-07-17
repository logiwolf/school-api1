<?php

namespace Tests\Unit;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassAssignmentUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_assigned_to_classroom()
    {
        // Create a student and a classroom
        $student = Student::factory()->create();
        $classroom = Classroom::factory()->create();

        // Assign the classroom to the student
        $student->classrooms()->attach($classroom->id);

        // Refresh the student model to load fresh relationships
        $student->refresh();

        // Check if the classroom is assigned
        $this->assertTrue($student->classrooms->contains($classroom));
    }

    public function test_student_can_be_assigned_to_multiple_classrooms()
    {
        $student = Student::factory()->create();
        $classrooms = Classroom::factory()->count(3)->create();

        // Attach all classrooms
        $student->classrooms()->attach($classrooms->pluck('id'));

        $student->refresh();

        // Check all classrooms are attached
        $this->assertCount(3, $student->classrooms);
    }
}
