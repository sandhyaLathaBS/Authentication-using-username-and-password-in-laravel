@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" enctype="multipart/form-data" id="image-upload">
                <div class="row">
                    <div class="col-md-2">
                        <img id="preview-image" src="{{ asset('uploads/' .  @$user->userdetails->image) }}"
                            alt="{{@$user->userdetails->image}}" style="max-height: 250px;width : 100%">
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <input type="file" class="form-control" name="image" placeholder="Choose image"
                                    id="image">
                                @error('name')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h1>Welcome <strong>{{@$user->userdetails->fullname}}</strong> </h1>
                        <div class="mt-3">
                            <p>Mobile: <strong>{{@$user->userdetails->mobile}}</strong></p>
                            <p>Organization: <strong>{{@$user->userdetails->organization}}</strong></p>
                            <p>Email: <strong>{{@$user->userdetails->email}}</strong></p>
                            <p>Date of birth: <strong>{{@$user->userdetails->dob}}</strong></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$('#image').change(function() {
    let reader = new FileReader();
    reader.onload = (e) => {
        $('#preview-image').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
    $('#image-upload').submit();
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(e) {
    $('#image-upload').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('profile.imageupdate')}}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                this.reset();
                alert('File has been uploaded successfully');
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
});
</script>
@endpush