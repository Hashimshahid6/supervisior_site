@extends('layouts.master')
@section('title')
Projects
@endsection
@section('page-title')
Projects
@endsection
@section('body')

<body>
    @endsection
    @section('content')
    @include('components.flash_messages')
    <!-- Left sidebar -->
    @if($uploadedProjects >= $packageLimit)
    @if(auth()->user()->role == 'Company')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-alert-circle me-2"></i>
        You have reached your project upload limit. Please upgrade your package to add more projects.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @else
    @if(auth()->user()->role == 'Company')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check me-2"></i>
        You have <strong>{{ $packageLimit - $uploadedProjects }}</strong> projects limit to upload.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @endif
    {{-- Search Filters --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('projects.index') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request()->search }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="Active" @if(request()->status == 'Active') selected @endif>Active
                                        </option>
                                        <option value="Inactive" @if(request()->status == 'Inactive') selected
                                            @endif>Inactive</option>
                                        <option value="Deleted" @if(request()->status == 'Deleted') selected
                                            @endif>Deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="sort_by" class="form-label">Sort By</label>
                                    <select class="form-select" id="sort_by" name="sort_by">
                                        <option value="id" @if(request()->sort_by == 'id') selected @endif>ID</option>
                                        <option value="name" @if(request()->sort_by == 'name') selected @endif>Project
                                            Name</option>
                                        <option value="status" @if(request()->sort_by == 'status') selected
                                            @endif>Status</option>
                                        <option value="created_at" @if(request()->sort_by == 'created_at') selected
                                            @endif>Created At</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <select class="form-select" id="sort_order" name="sort_order">
                                        <option value="desc" @if(request()->sort_order == 'desc') selected
                                            @endif>Descending</option>
                                        <option value="asc" @if(request()->sort_order == 'asc') selected
                                            @endif>Ascending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="per_page" class="form-label">Per Page</label>
                                    <select class="form-select" id="per_page" name="per_page">
                                        <option value="10" @if(request()->per_page == '10') selected @endif>10</option>
                                        <option value="25" @if(request()->per_page == '25') selected @endif>25</option>
                                        <option value="50" @if(request()->per_page == '50') selected @endif>50</option>
                                        <option value="100" @if(request()->per_page == '100') selected @endif>100
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3 mt-4">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('projects.index') }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="email-leftbar mb-5">
        <div class="card">
            <div class="card-body">
                @if($canAddProject && auth()->user()->role == 'Company')
                <button type="button" class="btn btn-primary waves-effect waves-light w-100" data-bs-toggle="modal"
                    data-bs-target="#composemodal">
                    Add Project
                </button>
                @endif
                <div class="card p-0 overflow-hidden mt-4 shadow-none">
                    <div class="mail-list">
                        @foreach($projects as $project)
                        <a href="javascript:void(0);" class="project-link" data-id="{{ $project->id }}">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-folder-outline font-size-20 align-middle me-3"></i>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-14 mb-0">Project</h5>
                                    <span class="text-muted font-size-13">{{ $project->name }}</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="float-end">
                                        <span class="bg-primary badge">{{ $loop->iteration }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->role == 'Company')
        <div class="card">
            <div class="card-body">
                <a href="javascript:void(0);" class="btn btn-danger w-100">
                    Deleted Projects
                </a>
                <div class="card p-0 overflow-hidden mt-4 shadow-none">
                    <div class="mail-list">
                        @foreach($deletedProjects as $project)
                        <a href="javascript:void(0);" class="project-link" data-id="{{ $project->id }}">
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-folder-outline font-size-20 align-middle me-3"></i>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-14 mb-0">Project</h5>
                                    <span class="text-muted font-size-13">{{ $project->name }}</span>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="float-end">
                                        <span class="bg-primary badge">{{ $loop->iteration }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- End Left sidebar -->

    <!-- Right Sidebar -->
    <div class="email-rightbar mb-3">
        <div class="card">
            <div class="card-body" id="project-content">
                <p class="text-muted">Select a project from the left sidebar to view details.</p>
            </div>
        </div>
    </div>
    <div class="row">
        {{ $projects->links() }}
    </div>
    <!-- end Col-9 -->

    <!-- Add Modal -->
    <div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="composemodalTitle">Upload New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.store') }}" method="POST" class="projectsform"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Project Name <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" id="name" name="name">
                            <span class="text-danger text-error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project Files <span class="text-danger"> *</span></label>
                            <div id="file-upload-container">
                                <input type="file" class="form-control mb-2" name="files[]" accept=".pdf" multiple>
                            </div>
                            <span class="text-danger text-error" id="file-error"></span>
                            <button type="button" class="badge bg-primary-subtle text-primary" id="add-file-upload">Add
                                File</button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger"> *</span></label>
                            <textarea class="form-control" rows="4" name="description" id="description"></textarea>
                            <span class="text-danger text-error"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit <i
                                    class="fab fa-telegram-plane ms-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Modal -->

    <!--Edit Modal -->
    <div class="modal fade" id="project-modal-edit" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="composemodalTitle">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="projectsedit" class="projectsform editform" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Project Name <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                            <span class="text-danger text-error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project Files</label>
                            <div id="edit-file-upload-container">
                                <input type="file" class="form-control mb-2" name="files[]" accept=".pdf" multiple>
                            </div>
                            <button type="button" class="badge bg-primary-subtle text-primary mb-4"
                                id="add-edit-file-upload">Add File</button>
                            <span id="existing-files" class="text-muted"></span>
                            <span class="text-danger text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger"> *</span></label>
                            <textarea class="form-control" rows="4" name="description" id="edit_description"></textarea>
                            <span class="text-danger text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger"> *</span></label>
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="status" id="active"
                                        value="Active">
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="status" id="inactive"
                                        value="Inactive">
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="deleted"
                                        value="Deleted">
                                    <label class="form-check-label" for="deleted">Deleted</label>
                                </div>
                            </div>
                        </div>
                        <div id="active-warning" class="text-danger" style="display: none;">
                            <i class="mdi mdi-alert-circle me-2"></i>
                            You need to delete one of your active projects to make a deleted project active.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update
                                <i class="fab fa-telegram-plane ms-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal -->

    <!-- Delete Modal -->
    <div class="modal fade" id="project-modal-delete" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="composemodalTitle">Delete Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="delete_project" method="POST">
                        @csrf
                        @method('DELETE')
                        <p>Are you sure you want to delete this project?</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete <i
                                    class="fas fa-trash-alt ms-1"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete File Modal -->
    <div class="modal fade" id="file-modal-delete" tabindex="-1" role="dialog" aria-labelledby="fileModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalTitle">Delete File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this file?</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirm-delete-file">Delete <i
                                class="fas fa-trash-alt ms-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
        const projectLinks = document.querySelectorAll('.project-link');
        const projectContent = document.getElementById('project-content');

        projectLinks.forEach(link => {
            link.addEventListener('click', function () {
                const projectId = this.getAttribute('data-id');

                // Remove active class from all links
                projectLinks.forEach(l => l.classList.remove('active', 'bg-primary-subtle'));
                this.classList.add('active', 'bg-primary-subtle');

                // Fetch project data
                fetch(`{{ route('projects.show', '') }}/${projectId}`)
                    .then(response => response.json())
                    .then(data => {
                        const messagesHTML = data.messages.map(message => `
                            <div class="border-bottom border-1 py-3">
                                <div class="badge bg-primary-subtle text-primary mb-2">
                                    ${formatDateWithTime(message.created_at)}
                                </div>
                                <p>${message.message}</p>
                                ${message.image ? `
                                    <img class="w-auto h-auto img-thumbnail mb-4"
                                        src="{{ asset('public/uploads/messages/') }}/${message.image}" 
                                        alt="${message.image}">
                                ` : ''}
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex">
                                            <img src="{{ URL::asset('public/uploads/users/${message.user.avatar}') }}" 
                                                class="avatar-sm rounded-circle" alt="${message.user.avatar}">
                                            <div class="flex-1 ms-2 ps-1">
                                                <h5 class="font-size-15 mb-0">${message.user.name}</h5>
                                                <p class="text-muted mb-0 mt-1">${message.user.email}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('');

                        projectContent.innerHTML = `
                            <div class="">
                                <div class="row mb-4">
                                    <div class="col-xl-3 col-md-12">
                                        <div class="pb-3 pb-xl-0">
                                            <form class="email-search">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control bg-light" placeholder="Search...">
                                                    <span class="bx bx-search font-size-18"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-xl-9 col-md-12">
                                        <div class="pb-3 pb-xl-0">
                                            <div class="btn-toolbar float-end" role="toolbar">
                                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                                    <button type="button" class="btn btn-primary waves-light waves-effect" 
                                                            onclick="editProject(${data.id})">
                                                            <i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-danger waves-light waves-effect"
                                                                onclick="deleteProject(${data.id})">
                                                                <i class="far fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-shrink-0 me-3">
                                    <img class="rounded-circle avatar-sm" src="{{ URL::asset('public/uploads/users/${data.user.avatar}') }}"
                                        alt="Generic placeholder image">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="font-size-14 mb-0">${data.user.name}</h5>
                                    <small class="text-muted">${data.user.email}</small>
                                </div>
                            </div>
                            <h4 class="font-size-16">${data.name}</h4>
                            <p>${data.description}</p>
                            <div class="mt-3">
                                <h6>Project Files:</h6>
                                ${data.project_files.map(file => `
                                    <a href="{{ asset('public/uploads/projects') }}/${file.file}" target="_blank" class="badge bg-primary-subtle text-primary mt-1">View File <i class="fa fa-eye ms-1"></i></a>
                                `).join(' ')}
                            </div>
                            <hr class="border-1">
                            <span class="border-bottom border-1 py-3"></span>
                            <div class="tab-pane" id="messages" role="tabpanel">
                                <div class="py-2">
                                    <div class="mx-n4 px-2 bg-light rounded" data-simplebar style="max-height: 360px;overflow-y: auto; shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                        ${messagesHTML}
                                        <div id="new-message"></div>
                                    </div>
                                    <div class="mt-2">
                                        <form id="message-form" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="projects_id" value="${data.id}">
                                            <div class="border rounded mt-4">
                                                <div class="py-1 bg-light">
                                                    <div class="btn-group" role="group">
                                                        <!-- Button to trigger file upload -->
                                                        <label class="btn btn-link text-decoration-none text-muted mb-0" for="image-upload">
                                                            <i class="bx bx-images"></i>
                                                        </label>
                                                        <!-- Hidden file input -->
                                                        <input type="file" name="image" id="image-upload" accept="image/*" class="d-none" onchange="handleImageUpload(this)">
                                                    </div>
                                                </div>
                                                <div id="image-preview-container"></div>
                                                <div class="px-2 py-1">
                                                    <textarea rows="3" class="form-control border-0 resize-none"
                                                        placeholder="Your Message..." name="message"></textarea>
                                                    <span class="text-danger text-error"></span>
                                                </div>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button type="submit" class="btn btn-primary w-sm">Send <i
                                                        class="fab fa-telegram-plane ms-1"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;

                        // Attach event listener to form
                        const messageForm = document.getElementById('message-form');
                        messageForm.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const formData = new FormData(this);

                            fetch(`{{ route('messages.store') }}`, {
                                method: 'POST',
                                body: formData
                            }).then(response => response.json())
                                .then(result => {
                                    if (result.status) {
                                        // Update messages UI
                                        const messagesContainer = document.querySelector('.mx-n4.px-2');
                                        const newMessageHTML = `
                                            <div class="border-bottom border-1 py-3">
                                                <p class="mb-4">${result.message.message}</p>
                                                ${result.message.image ? `
                                                    <img src="{{ URL::asset('public/uploads/messages/${result.message.image}') }}" 
                                                        class="w-60 img-thumbnail mb-4" alt="${result.message.image}">
                                                ` : ''}
                                                <div class="badge bg-primary-subtle text-primary mb-2">${formatDateWithTime(result.message.created_at)}</div>
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex">
                                                            <img src="{{ URL::asset('public/uploads/users/${result.message.user.avatar}') }}" class="avatar-sm rounded-circle" alt="">
                                                            <div class="flex-1 ms-2 ps-1">
                                                                <h5 class="font-size-15 mb-0">${result.message.user.name}</h5>
                                                                <p class="text-muted mb-0 mt-1">${result.message.user.email}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                        const newMessageContainer = document.getElementById('new-message');
                                        newMessageContainer.insertAdjacentHTML('beforebegin', newMessageHTML);
                                        messageForm.reset();
                                        document.getElementById('image-preview-container').innerHTML = ''; // Clear image preview

                                        // Scroll the messages container to the bottom to display the latest message
                                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                                        messagesContainer.scrollIntoView(true);
                                        //overflow-y auto
                                    } else {
                                        alert('Failed to send message.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error submitting message:', error);
                                });
                        });
                    })
                    .catch(error => {
                        projectContent.innerHTML = `<p class="text-danger">Failed to load project details.</p>`;
                        console.error('Error fetching project data:', error);
                    });
            });
        });
    });

        function handleImageUpload(input) {
            const previewContainer = document.getElementById('image-preview-container');
            previewContainer.innerHTML = ""; // Clear previous preview

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Create and display the image preview
                    const imgPreview = document.createElement('img');
                    imgPreview.src = e.target.result;
                    imgPreview.alt = "Image Preview";
                    imgPreview.className = "img-thumbnail";
                    imgPreview.style.width = "auto";
                    imgPreview.style.height = "auto";
                    imgPreview.style.marginLeft = "10px";
                    imgPreview.style.marginTop = "10px";
                    imgPreview.style.objectFit = "cover";

                    previewContainer.appendChild(imgPreview);
                };

                reader.readAsDataURL(file);
            }
        }
        $(document).ready(function() {
            $(".projectsform").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(this);

            // Check if files are selected
            if (!formData.has('files[]') || formData.getAll('files[]').length === 0) {
                $('#file-error').html('Please select at least one file.');
                return;
            }

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting content type
                success: function(response) {
                // Clear previous error messages
                $('.text-danger').html('');
                window.location.reload();
                },
                error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    if (form.hasClass('editform')) {
                    $('#edit_' + key).parent().find('.text-error').html(value);
                    } else {
                    $('#' + key).parent().find('.text-error').html(value);
                    }
                });
                }
            });
        });
      });
      const formatDateWithTime = (timestamp) => {
        const date = new Date(timestamp);
        const day = date.getDate();
        const month = date.toLocaleString('default', { month: 'long' });
        const year = date.getFullYear();
        const hours = date.getHours() % 12 || 12; // Convert to 12-hour format
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const period = date.getHours() >= 12 ? 'PM' : 'AM';
        return `${day} ${month}, ${year} ${hours}:${minutes} ${period}`;
    };

      function editProject(id) {
        $('#projectsedit').attr('action', "{{ url('projects') }}/" + id);
        $.ajax({
          url: "{{ url('projects') }}" + '/' + id + '/edit',
          type: "GET",
          success: function(response) {
            $('#project-modal-edit').modal('show');
            $('#edit_name').val(response.project.name);
            $('#existing-file').html(`<a href="{{ asset('public/uploads/projects') }}/${response.project.file}" target="_blank" class="btn btn-sm btn-primary mt-1">View File <i class="fa fa-eye ms-1"></i></a>`);
            $('#edit_description').val(response.project.description);

            // Parse and display existing files with delete option
            const files = response.project.project_files;
            $('#existing-files').html(files.map(file => `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <a href="{{ asset('public/uploads/projects') }}/${file.file}" target="_blank" class="badge bg-primary-subtle text-primary mt-1">View File <i class="fa fa-eye ms-1"></i></a>
                    <button type="button" class="badge bg-danger-subtle text-danger ms-2" onclick="deleteFile(${file.id}, this)">Delete</button>
                </div>
            `).join(' '));

            // Set the status radio button based on the service status
            $('input[name="status"]').prop('checked', false); // Clear previous selection
            if (response.project.status === 'Active') {
              $('#active').prop('checked', true);
            } else if (response.project.status === 'Inactive') {
              $('#inactive').prop('checked', true);
            } else if (response.project.status === 'Deleted') {
              $('#deleted').prop('checked', true);
            }
          },
          error: function(xhr) {
            console.log(xhr);
          }
        });
      } //
      function deleteProject(id) {
        $('#delete_project').attr('action', "{{ route('projects.destroy', '') }}/" + id);
        $('#project-modal-delete').modal('show');
      } //
      function deleteFile(fileId, button) {
        $('#file-modal-delete').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');
        $('#project-modal-edit').css('opacity', '0.8').css('background-color', 'black');
        $('#file-modal-delete').on('hidden.bs.modal', function () {
            $('#project-modal-edit').css('opacity', '1').css('background-color', '');
        });
        $('#confirm-delete-file').off('click').on('click', function() {
            $.ajax({
                url: "{{ url('admin/project-files') }}" + '/' + fileId,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status) {
                        $(button).closest('div').remove();
                        $('#file-modal-delete').modal('hide');
                        $('#project-modal-edit').css('opacity', '1').css('background-color', '');
                    } else {
                        alert('Failed to delete file.');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });
    }

    document.getElementById('add-file-upload').addEventListener('click', function() {
        const container = document.getElementById('file-upload-container');
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'files[]';
        input.accept = '.pdf';
        input.className = 'form-control mb-2';
        container.appendChild(input);
    });

    document.getElementById('add-edit-file-upload').addEventListener('click', function() {
        const container = document.getElementById('edit-file-upload-container');
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'files[]';
        input.accept = '.pdf';
        input.className = 'form-control mb-2';
        container.appendChild(input);
    });

    const activeRadio = document.getElementById('active');
    const activeWarning = document.getElementById('active-warning');

    activeRadio.addEventListener('change', function () {
        if (this.checked && @json($uploadedProjects) >= @json($packageLimit)) {
            activeWarning.style.display = 'block';
        } else {
            activeWarning.style.display = 'none';
        }
    });
    </script>
    <style>
        .email-leftbar {
            max-height: 600px;
            /* Adjust the height as needed */
            overflow-y: auto;
        }

        /* Custom scrollbar styles */
        .email-leftbar::-webkit-scrollbar {
            width: 8px;
        }

        .email-leftbar::-webkit-scrollbar-thumb {
            background-color: #007bff;
            /* Primary color */
            border-radius: 10px;
        }

        .email-leftbar::-webkit-scrollbar-thumb:hover {
            background-color: #0056b3;
            /* Darker primary color on hover */
        }

        .email-leftbar::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            /* Light background color */
        }

        /* Black overlay for modal */
        .modal-backdrop.show {
            opacity: 0.8;
            background-color: black;
        }
    </style>
    @endsection