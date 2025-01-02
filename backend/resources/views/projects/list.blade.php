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
    <div class="email-leftbar">
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
                        <a href="javascript:void(0);"
                            class="project-link"
                            data-id="{{ $project->id }}">
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
        {{-- <div class="card">
            <div class="card-body">
                <a href="javascript:void(0);" class="btn btn-danger w-100">
                    Deleted Projects
                </a>
                <div class="card p-0 overflow-hidden mt-4 shadow-none">
                    <div class="mail-list">
                        @foreach($deletedProjects as $project)
                        <a href="javascript:void(0);"
                            class="project-link"
                            data-id="{{ $project->id }}">
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
        </div> --}}
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
                            <label class="form-label">Project File <span class="text-danger"> *</span></label>
                            <input type="file" class="form-control" id="file" name="file" accept=".pdf">
                            <span class="text-danger text-error"></span>
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
                            <label class="form-label">Project File</label>
                            <input type="file" class="form-control" id="edit_file" name="file" accept=".pdf">
                            <span id="existing-file" class="text-muted"></span>
                            <span class="text-danger text-error"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger"> *</span></label>
                            <textarea class="form-control" rows="4" name="description" id="edit_description"></textarea>
                            <span class="text-danger text-error"></span>
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
                                <div class="badge bg-primary mb-2">
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
                                                    ${data.status !== 'Active' ? `
                                                        <button type="button" class="btn btn-danger waves-light waves-effect"
                                                                onclick="deleteProject(${data.id})">
                                                                <i class="far fa-trash-alt"></i></button>
                                                    ` : ''}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6><span class="badge bg-primary mb-2">Company Details</span></h6>
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
                            <a href="{{ asset('public/uploads/projects') }}/${data.file}" 
                                target="_blank" class="btn btn-sm btn-primary mt-1 mb-3">
                                View File <i class="fa fa-eye ms-1"></i>
                            </a>
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
                                                <div class="badge bg-primary mb-2">${formatDateWithTime(result.message.created_at)}</div>
                                                <p class="mb-4">${result.message.message}</p>
                                                ${result.message.image ? `
                                                    <img src="{{ URL::asset('public/uploads/messages/${result.message.image}') }}" 
                                                        class="w-60 img-thumbnail mb-4" alt="${result.message.image}">
                                                ` : ''}
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
                    $('#edit_' + key).next('.text-danger').html(value);
                    } else {
                    $('#' + key).next('.text-danger').html(value);
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
        $('#projectsedit').attr('action', "{{ url('/admin/projects') }}/" + id);
        $.ajax({
          url: "{{ url('admin/projects') }}" + '/' + id + '/edit',
          type: "GET",
          success: function(response) {
            $('#project-modal-edit').modal('show');
            $('#edit_name').val(response.project.name);
            $('#existing-file').html(`<a href="{{ asset('public/uploads/projects') }}/${response.project.file}" target="_blank" class="btn btn-sm btn-primary mt-1">View File <i class="fa fa-eye ms-1"></i></a>`);
            $('#edit_description').val(response.project.description)
  
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
      // 

    </script>
    @endsection