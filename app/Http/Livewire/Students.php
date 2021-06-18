<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name;
    public $email;
    public $student_id;

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->student_id = '';
    }

    public function store()
    {
        $validatedData= $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        Student::create($validatedData);

        session()->flash('message', 'Student Created Successfully!');
        
        $this->resetInputFields();
        $this->emit('studentAdded');
    }

    public function edit($id)
    {
        $student = Student::find($id);

        $this->student_id = $student->id;
        $this->name = $student->name;
        $this->email = $student->email;
    }

    public function update()
    {
        $validatedData= $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        Student::find($this->student_id)->update($validatedData);

        session()->flash('message', 'Student Updated Successfully!');
        
        $this->resetInputFields();
        $this->emit('studentUpdated');
    }

    public function render()
    {
        $students = Student::orderBy('created_at','DESC')->paginate(6);
        return view('livewire.students',['students' => $students]);
    }
}
