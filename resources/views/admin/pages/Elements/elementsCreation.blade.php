@extends('admin.layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <div class="container-fluid mt-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3>Elements Creation</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.createElement') }}" method="POST">
                    @csrf
                    <div class="form-group col-12">
                        <label for="element_name_en">Element name En</label>
                        <input id="element_name_en" type="text" name="element_name_en" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="element_name_ar">Element name Ar</label>
                        <input id="element_name_ar" type="text" name="element_name_ar" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="order">Order</label>
                        <input id="order" type="text" name="order" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="disability">Disability</label>
                        <div class="form-check">
                            <input id="disability" type="checkbox" value="1" name="disability"
                                class="form-check-input">
                            <label class="form-check-label" for="disability">Yes, I have a disability</label>
                        </div>

                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
            </div>
            <div class="card-footer">

                <a href="/dashboard/elements" class="btn btn-lg btn-danger ">Back</a>
                <button class="btn btn-lg btn-primary ">Save</button>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#element_name_en").keyup(function() {
                str = $(this).val().replace(/\s+/g, '_').toLowerCase();
                console.log(str);
                $(this).val(str);
            });
        });
    </script>
@endpush
