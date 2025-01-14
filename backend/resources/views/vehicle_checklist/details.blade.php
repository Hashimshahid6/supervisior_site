@extends('layouts.master')
@section('title')
Vehicle Checklist Details
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Vehicle Checklist Details
@endsection
@section('body')
<body>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
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
                        <h5 class="font-size-16 mb-1">Vehicle Checklist Details</h5>
                        <p class="text-muted text-truncate mb-0">View the information below</p>
                    </div>
                </div>
            </div>
            <div class="p-4 border-top">
                <div class="table-responsive">
                    <table class="table table-bordered" id="projectTable">
                        <tr>
                            <td class="align-middle text-start fw-bold">Project</td>
                            <td>{{ $DailyChecklist->project->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="vehiclesTable">
                        <tr>
                            @foreach($VehicleData as $key => $value)
                            <th>{{ $value }}</th>
                            @endforeach
                        </tr>
                        @if(isset($DailyChecklist->vehicle_data))
                        @php
                        $vehicle_data = json_decode($DailyChecklist->vehicle_data, true);
                        @endphp
                        @for($i = 0; $i < count($vehicle_data['vehicle_registration'] ?? []); $i++)
                        <tr>
                            <td>{{ $vehicle_data['vehicle_registration'][$i] ?? '' }}</td>
                            <td>{{ $vehicle_data['date'][$i] ?? '' }}</td>
                            <td>{{ $vehicle_data['driver_name'][$i] ?? '' }}</td>
                            <td>{{ $vehicle_data['miles'][$i] ?? '' }}</td>
                        </tr>
                        @endfor
                        @endif
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="itemsCheckedTable">
                        <tr>
                            <th>Items Checked</th>
                            @foreach($Days as $value)
                            <th class="text-center">{{ $value }}</th>
                            @endforeach
                        </tr>
                        @foreach($VehicleItems as $value)
                        <tr>
                            <td class="fw-bold">{{ $value }}</td>
                            @foreach($Days as $day)
                            <td class="text-center">{{ json_decode($DailyChecklist->checklist, true)[$value][$day] ?? '' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered defect-table" id="defectTable">
                        <tr class="fw-bold">
                            <td>Defect:</td>
                            <td>Date Reported:</td>
                            <td>Usable:</td>
                        </tr>
                        @if(isset($DailyChecklist->reports))
                        @php
                        $reports = json_decode($DailyChecklist->reports, true);
                        @endphp
                        @for($i = 0; $i < count($reports['defect'] ?? []); $i++)
                        <tr>
                            <td>{{ $reports['defect'][$i] ?? '' }}</td>
                            <td>{{ $reports['date_reported'][$i] ?? '' }}</td>
                            <td>{{ $reports['useable'][$i] ?? '' }}</td>
                        </tr>
                        @endfor
                        @endif
                    </table>
                </div>
                <div class="row mb-4">
                    <div class="col text-end">
                        <a class="btn btn-danger" id="exportToPdf">Export to PDF</a>
                        <a class="btn btn-success" id="exportToExcel">Export to Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportToPdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        pdf.text('Vehicle Checklist Report', 14, 15);
        const projectTable = document.getElementById('projectTable');
        const vehiclesTable = document.getElementById('vehiclesTable');
        const itemsCheckedTable = document.getElementById('itemsCheckedTable');
        const defectTable = document.getElementById('defectTable');
        pdf.autoTable({ html: projectTable, startY: 20, theme: 'striped', headStyles: { fillColor: [22, 160, 133] }, styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } });
        pdf.autoTable({ html: vehiclesTable, startY: pdf.lastAutoTable.finalY + 10, theme: 'striped', headStyles: { fillColor: [22, 160, 133] }, styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } });
        pdf.autoTable({ html: itemsCheckedTable, startY: pdf.lastAutoTable.finalY + 10, theme: 'striped', headStyles: { fillColor: [22, 160, 133] }, styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } });
        pdf.autoTable({ html: defectTable, startY: pdf.lastAutoTable.finalY + 10, theme: 'striped', headStyles: { fillColor: [22, 160, 133] }, styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } });
        pdf.save('Vehicle_Checklist.pdf');
    });
    document.getElementById('exportToExcel').addEventListener('click', function () {
        const wb = XLSX.utils.book_new();
        const projectTable = document.getElementById('projectTable');
        const vehiclesTable = document.getElementById('vehiclesTable');
        const itemsCheckedTable = document.getElementById('itemsCheckedTable');
        const defectTable = document.getElementById('defectTable');

        const projectData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(projectTable), { header: 1 });
        const vehiclesData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(vehiclesTable), { header: 1 });
        const itemsCheckedData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(itemsCheckedTable), { header: 1 });
        const defectData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(defectTable), { header: 1 });

        const combinedData = [...projectData, [], ...vehiclesData, [], ...itemsCheckedData, [], ...defectData];
        const ws = XLSX.utils.aoa_to_sheet(combinedData);

        // Format date columns to display as date in Excel
        const dateColumns = [1, 2]; // Assuming date columns are at index 1 and 2
        dateColumns.forEach(col => {
            for (let i = 1; i < combinedData.length; i++) {
                if (combinedData[i][col]) {
                    ws[XLSX.utils.encode_cell({ r: i, c: col })].z = 'dd/mm/yyyy';
                }
            }
        });

        XLSX.utils.book_append_sheet(wb, ws, 'Vehicle Checklist');
        XLSX.writeFile(wb, 'Vehicle_Checklist.xlsx');
    });
</script>
@endsection