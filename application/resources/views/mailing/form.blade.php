@extends('app')

@section('title', __('New task'))

@section('content')
    @if (session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif

    <div class="col-md-12" id="shutterstock-query-form">
        <form action="{{ route('process-mailing') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-12">
                    <div class="form-group row">
                        <div class="col-md-6 row">
                            <div class="col-lg-7 col-md-12">
                                <label for="cc-name">@lang('Query')</label>
                                <input type="text" class="form-control" id="cc-name" required v-model="query">
                                <small class="text-muted">@lang('Search query for ShutterStock')</small>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <label for="cc-name">@lang('File')</label>
                                <div class="custom-file">
                                    <input type="file" name="file" required class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                                </div>
                                <small class="text-muted">@lang('File with email addresses')</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <button class="btn btn-secondary btn-lg btn-block" type="submit"
                            @click.prevent="loadResult()">@lang('Load from ShutterStock')</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-lg btn-block" type="submit"
                            v-show="dataLoaded">@lang('Process')</button>
                </div>
            </div>

            <div v-if="result.length > 0">
                <hr class="mb-4">
                <div class="row">
                    <div v-for="(item, index) in result" class="card" style="width: 12rem;">
                        <img class="card-img-top" :src="item.preview.url">
                        <input type="hidden" :name="'images['+index+']'" :value="item.src.url">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection