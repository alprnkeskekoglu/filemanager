@extends('FileManagerView::layouts.app')

@section('content')
    <header id="page-header">
        <div class="content-header">
        </div>
    </header>
    <main id="main-container">
        <div class="p-5">
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#dropzoneTab">{{ __('FileManagerLang::upload.from_computer') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#linkTab">{{ __('FileManagerLang::upload.from_url') }}</a>
                    </li>
                </ul>
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="dropzoneTab" role="tabpanel">
                        <div class="p-3">
                            <div id="dropzone" class="dropzone">
                                <div class="dz-message">
                                    {{ __('FileManagerLang::upload.dropzone.text_1') }}
                                    <br>
                                    {{ __('FileManagerLang::upload.dropzone.text_2') }}
                                    <br>
                                    {{ __('FileManagerLang::upload.dropzone.text_3') }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="linkTab" role="tabpanel">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="url" name="url" placeholder="{{ __('FileManagerLang::upload.paste_url') }}">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="uploadFromUrl">{{ __('FileManagerLang::upload.upload') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ fileManagerAsset('plugins/dropzone/dist/min/dropzone.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ fileManagerAsset('plugins/dropzone/dropzone.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone('div#dropzone', {
            url: "{{ route('dawnstar.filemanager.uploadFromComputer') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            paramName: 'files',
            maxFilesize: 2048, //MB
            timeout: 180000, //ms
            uploadMultiple: true
        });

        myDropzone.on('error', function (response) {
           if(response.xhr) {
               var error = JSON.parse(response.xhr.response);
               showErrorModal(error.message);
           }
        });

        myDropzone.on('success', function (response) {
            window.location.href = '{!! route('dawnstar.filemanager.index', $requestParams) !!}';
        });

        $('#uploadFromUrl').click(function () {
            var url = $('#url').val();

            $.ajax({
                'url': '{{ route('dawnstar.filemanager.uploadFromUrl') }}',
                'method': 'POST',
                'data': {'url': url, '_token': '{{ csrf_token() }}'},
                success: function (response) {
                    showSuccessModal(response.message);
                    window.location.href = '{{ route('dawnstar.filemanager.index') }}';
                },
                error: function(response) {
                    showErrorModal(response.responseJSON.message);
                }

            })
        });

        function showSuccessModal(message) {
            alert('SUCCESS!! ' + message);
        }

        function showErrorModal(message) {
            alert('ERROR!! ' + message);
        }
    </script>
@endpush
