@extends('layouts.master')
@section('title')
Edit Vehicle Checklist
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Edit Vehicle Checklist
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
                            <h5 class="font-size-16 mb-1">Edit Vehicle Checklist</h5>
                            <p class="text-muted text-truncate mb-0">Update the information below</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-top">
                    <form action="{{ route('vehicle_checklists.update', $DailyChecklist->id) }}" method="POST"
                        enctype="multipart/form-data" id="checklist-form">
                        @csrf
                        @method('PUT')
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="align-middle text-start fw-bold">Projects <span
                                            class="text-danger">*</span></td>
                                    <td>
                                        <select class="form-select" name="project_id" id="project_id">
                                            <option value="">Select Project</option>
                                            @foreach($Projects as $project)
                                            <option value="{{ $project->id }}" {{ $DailyChecklist->project_id ==
                                                $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <tr>
                                    @foreach($VehicleData as $key => $value)
                                    <th>
                                        <span name="vehicle_data" id="vehicle_data">{{ $value }}:</span>
                                    </th>
                                    @endforeach
                                </tr>
                                @if(isset($DailyChecklist->vehicle_data))
                                    @php
                                    $vehicle_data = json_decode($DailyChecklist->vehicle_data, true);
                                    @endphp
                                    @for($i = 0; $i < count($vehicle_data['vehicle_registration']); $i++)
                                        <tr>
                                            <td>
                                                <input type="text" name="vehicle_registration[]"
                                                    value="{{ $vehicle_data['vehicle_registration'][$i] ?? '' }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="date" name="date[]" value="{{ $vehicle_data['date'][$i] ?? '' }}"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="driver_name[]"
                                                    value="{{ $vehicle_data['driver_name'][$i] ?? '' }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="miles[]" value="{{ $vehicle_data['miles'][$i] ?? '' }}"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                    @endfor
                                @endif
                            </table>
                        </div>
                        <button type="button" class="btn btn-primary vehicle_data_row mb-4">Add More</button>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <tr>
                                    <th>Items Checked</th>
                                    @foreach($Days as $key => $value)
                                    <th class="text-center">
                                        <span name="day" id="day">{{ $value }}</span>
                                    </th>
                                    @endforeach
                                </tr>
                                @foreach($VehicleItems as $key => $value)
                                <tr>
                                    <td class="fw-bold">{{ $value }}</td>
                                    @foreach($Days as $day)
                                    <td class="text-center">
                                        <input type="text" name="checklist[{{ $value }}][{{ $day }}]"
                                            class="form-control"
                                            value="{{ json_decode($DailyChecklist->checklist, true)[$value][$day] ?? '' }}">
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered defect-table">
                                <tr class="fw-bold">
                                    <td>Defect</td>
                                    <td>Date Reported</td>
                                    <td>Usable</td>
                                </tr>
                                @if(isset($DailyChecklist->reports))
                                @php
                                $reports = json_decode($DailyChecklist->reports, true);
                                @endphp
                                @for($i = 0; $i < count($reports['defect'] ?? []); $i++)
                                <tr>
                                    <td>
                                        <input type="text" name="defect[]" value="{{ $reports['defect'][$i] ?? '' }}"
                                            class="form-control">
                                    </td>
                                    <td>
                                        <input type="date" name="date_reported[]"
                                            value="{{ $reports['date_reported'][$i] ?? '' }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="useable[]" value="{{ $reports['useable'][$i] ?? '' }}"
                                            class="form-control">
                                    </td>
                                </tr>
                                @endfor
                                @endif
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
                    <td><input type="text" name="defect[]" class="form-control"></td>
                    <td><input type="date" name="date_reported[]" class="form-control"></td>
                    <td><input type="text" name="useable[]" class="form-control"></td>
                `;
            });
        });

        document.querySelectorAll('.vehicle_data_row').forEach(button => {
            button.addEventListener('click', function () {
                const table = this.previousElementSibling;
                const newRow = table.insertRow();
                newRow.innerHTML = `
                    <td><input type="text" name="vehicle_registration[]" class="form-control"></td>
                    <td><input type="date" name="date[]" class="form-control"></td>
                    <td><input type="text" name="driver_name[]" class="form-control"></td>
                    <td><input type="text" name="miles[]" class="form-control"></td>
                `;
            });
        });
    });
</script>
@endsection