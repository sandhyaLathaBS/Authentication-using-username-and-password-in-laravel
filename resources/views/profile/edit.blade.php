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
            <form class="form-horizontal" id="details_form" action="{{ route('profile.editAction') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2">Full name:</label>
                    <div class="col-sm-10">
                        <input required type="text" class="form-control" name="fullname" id="fullname">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Email:</label>
                    <div class="col-sm-10">
                        <input required type="email" class="form-control" name="email" id="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Mobile:</label>
                    <div class="col-sm-10">
                        <input required type="number" class="form-control" name="mobile" id="mobile">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">DOB:</label>
                    <div class="col-sm-10">
                        <input required type="date" class="form-control" name="dob" id="dob">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Organisation:</label>
                    <div class="col-sm-10">
                        <input required type="text" class="form-control" name="organisation" id="organisation">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="file">Upload Photo</label>
                    <div class="col-sm-10">
                        <input required class="form-control" type="file" id="file" name="image" multiple="multiple"
                            accept="image/*" />
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
<script>
$("#details_form").
</script>
@endpush