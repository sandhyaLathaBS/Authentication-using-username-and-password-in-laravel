@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form class="form-horizontal" id="details_form" action="{{ route('profile.editAction') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2">Full name:</label>
                    <div class="col-sm-10">
                        <input value="{{ old('fullname') }}" required type="text" class="form-control" name="fullname"
                            id="fullname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Email:</label>
                    <div class="col-sm-10">
                        <input value="{{ old('email') }}" required type="email" class="form-control" name="email"
                            id="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Mobile:</label>
                    <div class="col-sm-10">
                        <input value="{{ old('mobile') }}" required type="number" class="form-control" name="mobile"
                            id="mobile">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">DOB:</label>
                    <div class="col-sm-10">
                        <input value="{{ old('dob') }}" required type="date" class="form-control" name="dob" id="dob">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Organisation:</label>
                    <div class="col-sm-10">
                        <input value="{{ old('organisation') }}" required type="text" class="form-control"
                            name="organisation" id="organisation">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="file">Upload Photo</label>
                    <div class="col-sm-10">
                        <input value="{{ old('file') }}" required class="form-control" type="file" id="file" name="file"
                            multiple="multiple" accept="image/*" />
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
$.validator.methods.email = function(value, element) {
    return this.optional(element) || /[a-z]+@[a-z]+\.[a-z]+/.test(value);
}
$("#details_form").validate({
    rules: {
        fullname: "required",
        mobile: {
            required: true,
            digits: true
        },
        dob: {
            required: true,
            date: true
        },
        organisation: "required",
        file: {
            required: true,
            accept: "image/*"
        },
        email: {
            required: true,
            email: true
        }
    },
    messages: {
        fullname: "Please enter your full name",
        email: "Please enter a valid email address",
        mobile: "Please enter your mobile",
        dob: "Please enter your date of birth",
        organisation: "Please enter your organisation",
        file: "Please enter your image",
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush