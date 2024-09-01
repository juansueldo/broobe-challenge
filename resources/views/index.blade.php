
@section('active-run', 'active')

@extends('layouts.main')
@section('title', 'Broobe Challenge')

@section('content')
    <form id="metrics-form">
        <div class="container mb-3">
            <div class="container-inputs mb-3">
                <label class="form-label" for="url">URL</label>
                <div class="form-check form-check-inline">
                    <input type="text" class="form-control" id="url" name="url" placeholder="https://www.broobe.com"><br/>
                </div>
                    @error('url')
                        <p style="color:red">{{$message}}</p>
                    @enderror
                
                
                    <label class="form-label">{{ __('metrics.categories') }}</label><br>
                    <div class="form-check form-check-inline">
                        @foreach($categories as $category)
                            <input class="form-check-input" type="checkbox" name="categories" value="{{ $category->name }}">
                            <label class="form-check-label">{{ $category->name }}</label>
                        @endforeach
                    </div>
                
                <div class="form-group">
                    <label class="form-label" for="strategy">Strategy</label>
                    <div class="form-check form-check-inline">
                        <select class="form-control" id="strategy" name="strategy">
                            @foreach($strategies as $strategy)
                                <option value="{{ $strategy->name }}">{{ $strategy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-primary" id="submit-btn">Get Metrics</button>
            </div>
        </div>
    </form>
    <form id="metrics-results-form" class="d-none">
        <div id="metrics-results" class="mb-3">

        </div>
        <div class="form-group mb-3 text-center">
            <button type="button" class="btn btn-success" id="save-metrics-btn">Save Metric Run</button>
        </div>
    </form>
@endsection