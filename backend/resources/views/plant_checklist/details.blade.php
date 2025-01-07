@extends('layouts.master')
@section('title')
Plant Checklist Details
@endsection
@section('css')
<!-- Add any additional CSS if needed -->
@endsection
@section('page-title')
Plant Checklist Details
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
                            <h5 class="font-size-16 mb-1">Plant Checklist Details</h5>
                            <p class="text-muted text-truncate mb-0">View the information below</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-top">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="plantTypeTable">
                            <tr>
                                <td class="align-middle text-start fw-bold">Plant Type</td>
                                <td>{{ $PlantTypes[$DailyChecklist->plant_type] ?? 'Unknown' }}</td>
                                <td class="align-middle text-start fw-bold">Project</td>
                                <td>{{ $DailyChecklist->project->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="itemsCheckedTable">
                            <tr>
                                <th>Items Checked</th>
                                @foreach($Days as $key => $value)
                                <th class="text-center">{{ $value }}</th>
                                @endforeach
                            </tr>
                            @foreach($PlantChecklists as $key => $value)
                            <tr>
                                <td class="fw-bold">{{ $value }}</td>
                                @foreach($Days as $day)
                                <td class="text-center">{{ json_decode($DailyChecklist->checklist, true)[$value][$day] ?? ''
                                    }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="defectTable">
                            <tr class="fw-bold">
                                <td>Defect:</td>
                                <td>Date Reported:</td>
                                <td>Usable:</td>
                                <td>Reported To:</td>
                                <td>Operator:</td>
                            </tr>
                            @if(isset($DailyChecklist->reports))
                            @php
                            $reports = json_decode($DailyChecklist->reports, true);
                            @endphp
                            @if(is_array($reports['defect'] ?? []))
                            @for($i = 0; $i < count($reports['defect']); $i++)
                            <tr>
                                <td>{{ $reports['defect'][$i] ?? '' }}</td>
                                <td>{{ $reports['date_reported'][$i] ?? '' }}</td>
                                <td>{{ $reports['useable'][$i] ?? '' }}</td>
                                <td>{{ $reports['reported_to'][$i] ?? '' }}</td>
                                <td>{{ $reports['operator'][$i] ?? '' }}</td>
                            </tr>
                            @endfor
                            @endif
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
        // Import jsPDF and autoTable from the global namespace
        const { jsPDF } = window.jspdf;

        // Initialize jsPDF
        const pdf = new jsPDF();

        // Add a title
        pdf.text('Plant Checklist Report', 14, 15);

        // Get the table elements
        const plantTypeTable = document.getElementById('plantTypeTable');
        const itemsCheckedTable = document.getElementById('itemsCheckedTable');
        const defectTable = document.getElementById('defectTable');

        // Use autoTable to generate PDF from each table
        pdf.autoTable({
            html: plantTypeTable, // Table HTML
            startY: 20, // Start position on the page
            theme: 'striped', // Theme for the table
            headStyles: { fillColor: [22, 160, 133] }, // Styling for the table header
            styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } // Apply borders
        });

        pdf.autoTable({
            html: itemsCheckedTable, // Table HTML
            startY: pdf.lastAutoTable.finalY + 10, // Start position after the previous table
            theme: 'striped', // Theme for the table
            headStyles: { fillColor: [22, 160, 133] }, // Styling for the table header
            styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } // Apply borders
        });

        pdf.autoTable({
            html: defectTable, // Table HTML
            startY: pdf.lastAutoTable.finalY + 10, // Start position after the previous table
            theme: 'striped', // Theme for the table
            headStyles: { fillColor: [22, 160, 133] }, // Styling for the table header
            styles: { lineColor: [0, 0, 0], lineWidth: 0.1 } // Apply borders
        });

        // Save the PDF
        pdf.save('Plant_Checklist.pdf');
    });

    document.getElementById('exportToExcel').addEventListener('click', function () {
        // Create a new workbook
        const wb = XLSX.utils.book_new();

        // Get the table elements
        const plantTypeTable = document.getElementById('plantTypeTable');
        const itemsCheckedTable = document.getElementById('itemsCheckedTable');
        const defectTable = document.getElementById('defectTable');

        // Convert each table to an array of arrays
        const plantTypeData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(plantTypeTable), { header: 1 });
        const itemsCheckedData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(itemsCheckedTable), { header: 1 });
        const defectData = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(defectTable), { header: 1 });

        // Combine all data into a single array
        const combinedData = [
            ...plantTypeData,
            [],
            ...itemsCheckedData,
            [],
            ...defectData
        ];

        // Convert the combined data to a worksheet
        const ws = XLSX.utils.aoa_to_sheet(combinedData);

        // Append the worksheet to the workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Plant Checklist');

        // Save the workbook
        XLSX.writeFile(wb, 'Plant_Checklist.xlsx');
    });
    </script>
    @endsection