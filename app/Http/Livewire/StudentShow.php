<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;

use Livewire\WithPagination;

class StudentShow extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $count_value, $student_id;
    public $search = '';

    public function editStudent(int $student_id)
    {
        $student = Student::find($student_id);
        if ($student) {

            $this->student_id = $student->id;
            $this->count_value = $student->count_value;
            // $this->email = $student->email;
            // $this->course = $student->course;
        } else {
            return redirect()->to('/students');
        }
    }
    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->count_value = '';
   
    }

    // public function render()
    // {
    //     return view('livewire.student-show');
    // }
    public function render()
    {
        $students = Student::where('count_value', 'like', '%' . $this->search . '%')->orderBy('id', 'DESC')->paginate(3);
        return view('livewire.student-show', ['students' => $students]);
    }
}
