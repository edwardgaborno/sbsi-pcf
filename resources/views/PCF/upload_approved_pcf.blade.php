@extends('layouts.app')
@section('title','PCF - PCF Request')

@push('styles')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('layouts.navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                 <!-- Page Heading -->
                 <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Upload Approved PCF Request</h1>
                </div>

                <div class="">
                    <a href="{{ route('PCF.index') }}" class="btn btn-sm btn-light mr-2"><i class="fas fa-arrow-circle-left"></i> Back to index page</a>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
                            <div class="card-body">
                                @can('upload_pcf')
                                <div class="tab-pane show active fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                                    <form action="#" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="upload_file"></label>
                                                            <!--  For single file upload  -->
                                                            <input type="hidden" id="pcf_request_id">
                                                            <input type="file" name="pcf_rfq" 
                                                                accept="application/pdf"
                                                                class="@error('upload_file') is-invalid @enderror" 
                                                                data-max-file-size="5MB" 
                                                                credits="false"/>
                        
                                                            @error('upload_file')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('PCF.index') }}" class="btn btn-link">
                                                <i class="fas fa-times"></i> Cancel</a>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputElement = document.querySelector('input[name="pcf_rfq"]');
            var store = FilePond.create((inputElement),
            {
                labelIdle: `Drag & Drop document file or <span class="filepond--label-action">Browse</span>`,
                imagePreviewHeight: 170,
            });
            
            store.setOptions({
                server: {
                    url: "{{ route('store.pcf_document') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
            });
        });
    </script>
@endsection

@push('scripts')
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush