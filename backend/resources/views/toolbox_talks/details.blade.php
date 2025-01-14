@extends('layouts.master')
@section('title')
Toolbox Talk Details
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Toolbox Talk Details
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
                            <h5 class="font-size-16 mb-1">Toolbox Talk Details</h5>
                            <p class="text-muted text-truncate mb-0">View the information below</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-top">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="projectTable">
                            <tr>
                                <td class="align-middle text-start fw-bold">Project</td>
                                <td>{{ $toolboxTalk->project->name }}</td>
                            </tr>
                            <tr>
                                <td class="align-middle text-start fw-bold">Topic</td>
                                <td>{{ $toolboxTalk->topic }}</td>
                            </tr>
                            <tr>
                                <td class="align-middle text-start fw-bold">Presented By</td>
                                <td>{{ $toolboxTalk->presented_by }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendeesTable">
                            <tr>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Date</th>
                            </tr>
                            @if(isset($toolboxTalk->toolbox_talk))
                            @php
                            $toolboxTalk = json_decode($toolboxTalk->toolbox_talk, true);
                            @endphp
                            @for($i = 0; $i < count($toolboxTalk['first_name']); $i++) <tr>
                                <td>{{ $toolboxTalk['first_name'][$i] }}</td>
                                <td>{{ $toolboxTalk['surname'][$i] }}</td>
                                <td>{{ $toolboxTalk['date'][$i] }}</td>
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
            pdf.text('Toolbox Talk Report', 14, 15);
            const projectTable = document.getElementById('projectTable');
            const attendeesTable = document.getElementById('attendeesTable');
            pdf.autoTable({ html: projectTable, startY: 20, theme: 'striped', headStyles: { fillColor: [22, 160, 133] }, styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } });
            pdf.autoTable({ html: attendeesTable, startY: pdf.lastAutoTable.finalY + 10, theme: 'striped', headStyles: { fillColor: [22, 160, 133] }, styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } });
            pdf.save('Toolbox_Talk.pdf');
        });

        document.getElementById('exportToExcel').addEventListener('click', function () {
            const wb = XLSX.utils.book_new();
            const projectTable = document.getElementById('projectTable');
            const attendeesTable = document.getElementById('attendeesTable');
            const projectData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(projectTable), { header: 1 });
            const attendeesData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(attendeesTable), { header: 1 });
            const combinedData = [...projectData, [], ...attendeesData];
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
            
            XLSX.utils.book_append_sheet(wb, ws, 'Toolbox Talk');
            XLSX.writeFile(wb, 'Toolbox_Talk.xlsx');
        });
    </script>
    @endsection