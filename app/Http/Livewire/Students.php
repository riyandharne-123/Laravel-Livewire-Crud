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

        $student = Student::all()->last();
        $i = '';
        
        if ($student->order)
        {
            $i = $student->order += 1;
        }

        else {
            $i = 1;
        }

        Student::create([
            'name' => $this->name,
            'email' => $this->email,
            'order' => $i,
        ]);

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

    public function updateOrder($list)
    {
        foreach ($list as $item) {
            Student::find($item['value'])->update([
                'order' => $item['order'],
            ]);
        }
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();

        session()->flash('message', 'Student Deleted Successfully!');
    }

    public function render()
    {
        $students = Student::orderBy('order','ASC')->paginate(6);
        return view('livewire.students',['students' => $students]);
    }
}
