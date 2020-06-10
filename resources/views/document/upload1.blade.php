@extends('layouts.app')

@section('content')

<section id="image-form-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload Your Image Here</div>
                    <div class="panel-body">
                        <Formupload></Formupload>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection