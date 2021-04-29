@extends('layouts.app')

@section('content')
    <h1>List of Users</h1>

    @empty($users)
        <div class="alert alert-warning">
            The list of users is empty
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Admin Since</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->admin_since}}</td>
                            <td>
                              
                                <form class = "d-inline" 
                                action="{{route('users.admin.toggle', [
                                'user' => $user])}}"
                                method = "POST">
                                @csrf 
                                    <button 
                                    class = "btn btn-link"
                                    type = "submit">
                                    Admin
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endempty

@endsection
