<div class="col-md-12" style="margin:0 auto;">
@include('livewire.create')
@include('livewire.update')
@if(session()->has('message'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  {{  session('message')  }}
</div>
@endif
    <div class="card">
        <div class="card-header">
            <h3>
                All Students 
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddNewStudentModal">
                Add New Student
                </button>
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody wire:sortable="updateOrder">
                @foreach ($students as $student)
                <tr wire:sortable.item="{{ $student->id }}" wire:key="student-{{ $student->id }}">
                    <div>
                        <td wire:sortable.handle>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                    </div>
                    <td>
                        <button class="btn btn-info" wire:click.prevent="edit({{$student->id}})" data-toggle="modal" data-target="#updateStudentModal">Edit</button>
                        <button class="btn btn-danger" wire:click.prevent="delete({{$student->id}})">Delete</button>
                    </td>
                </tr>           
                @endforeach
                </tbody>
            </table>
            {{ $students->links() }}
        </div>
    </div>
</div>
