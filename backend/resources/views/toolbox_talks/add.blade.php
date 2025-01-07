@extends('layouts.master')
@section('title')
Toolbox Talks
@endsection
@section('css')
@section('page-title')
Toolbox Talks
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="card">
                    <div class="p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                        <h5 class="text-primary font-size-17 mb-0">S</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="font-size-16 mb-1">Toolbox Talks Template</h5>
                                <p class="text-muted text-truncate mb-0">Fill all information below</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-top">
                        <form action="{{ route('toolbox_talks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="align-middle text-start fw-bold">Projects <span
                                                class="text-danger">*</span></td>
                                        <td>
                                            <select class="form-select" name="project_id" id="project_id">
                                                <option value="">Select Project</option>
                                                @foreach($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-start fw-bold">Topic <span
                                                class="text-danger">*</span>
                                        </td>
                                        <td>
                                            <input type="text" name="topic" class="form-control">
                                            @error('topic')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle text-start fw-bold">Presented By <span
                                                class="text-danger">*</span></td>
                                        <td>
                                            <input type="text" name="presented_by" class="form-control">
                                            @error('presented_by')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>First Name</th>
                                        <th>Surname</th>
                                        <th>Date</th>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="first_name[]" class="form-control"></td>
                                        <td><input type="text" name="surname[]" class="form-control"></td>
                                        <td><input type="date" name="date[]" class="form-control"></td>
                                    </tr>
                                </table>
                            </div>
                            <button type="button" class="btn btn-primary add-row">Add More</button>
                            <div class="row mb-4">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-secondary" name="action" value="save">Save
                                        Progress</button>
                                    <button type="submit" class="btn btn-success" name="action"
                                        value="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    @endsection
    @section('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.add-row').forEach(button => {
                button.addEventListener('click', function () {
                    const table = this.previousElementSibling;
                    const newRow = table.insertRow();
                    newRow.innerHTML = `
                        <td><input type="text" name="first_name[]" class="form-control"></td>
                        <td><input type="text" name="surname[]" class="form-control"></td>
                        <td><input type="date" name="date[]" class="form-control"></td>
                    `;
                });
            });
        });
    </script>
    @endsection