@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Users</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>First name</th>
                <th>User name</th>
                <th>Mobile</th>
                <th>DOB</th>
                <th>Organization</th>
                <th>Profile Completed</th>
                <th>Active</th>
                <th>Last Logged in</th>
            </tr>
        </thead>
        <tbody>
            @if($users)
            @foreach($users as $user)
            <tr>
                <td> <img id="preview-image" src="{{ asset('uploads/' .  @$user->userdetails->image) }}"
                        alt="{{@$user->userdetails->image}}" style="max-height: 250px;width : 100%"></td>
                <td>{{@$user->userdetails->fullname}}</td>
                <td>{{@$user->username}}</td>
                <td>{{@$user->userdetails->mobile}}</td>
                <td>{{@$user->userdetails->dob}}</td>
                <td>{{@$user->userdetails->organization}}</td>
                <td>{{(@$user->is_profilecompleted == 2) ? "Completed": "Pending"}}</td>
                <td>
                    @if( $user->is_profilecompleted == 2)
                    <button id="activebtn" onclick="changeActiveStatus('{{base64_encode(@$user->id)}}')"
                        class="btn {{(@$user->is_active == 0) ? 'btn-danger' : 'btn-success'}} ">
                        {{(@$user->is_active == 0) ? "Inactive" : "Active"}}
                    </button>
                    @else
                    Login pending
                    @endif
                </td>
                <td>{{date('d-m-y H:i:s' ,strtotime(@$user->last_logged_at))}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
function changeActiveStatus(uuid) {
    console.log(uuid);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "{{ route('update.status')}}",
        data: {
            uuid: uuid
        },
        success: (data) => {
            console.log(data.activestatus);
            if (data.activestatus) {
                $("#activebtn").removeClass("btn-danger").addClass("btn-success").html('Active');
            } else {
                $("#activebtn").addClass("btn-danger").removeClass("btn-success").html('Inactive');
            }
            alert('Status updated successfully');
        },
        error: function(data) {
            console.log(data);
        }
    });
}
</script>
@endpush