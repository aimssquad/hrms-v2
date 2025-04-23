<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />


    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ["{{ asset('assets/css/fonts.min.css')}}"]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
    <style>
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>
</head>

<body>
    <div class="wrapper">

        @include('admin.include.header')
        <!-- Sidebar -->

        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">

            </div>
            <div class="content">
                <div class="page-inner">
                    <div class="row">
                       <div class="col-md-12">
                          <div class="card custom-card">
                             <div class="card-header">
                                <h4 class="card-title"><i class="far fa-newspaper"></i>Sponsor Dossier<span><a href="{{ url('superadmin/sponsor-dossier-add') }}" data-toggle="tooltip" data-placement="bottom" title="Generate Bill" style="padding: 8px 0;"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
                                @if(Session::has('message'))
                                <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                                @endif
                             </div>
                             <div class="card-body">
                                <div class="table-responsive">
                                   <table id="basic-datatables" class="display table table-striped table-hover" >
                                      <thead>
                                         <tr>
                                            <th>Sl.No.</th>
                                            <th>Dossier Title</th>
                                            <th>Dossier Link</th>
                                            <th>Dossier Type</th>
                                            <th>Dossier File</th>
                                            <th>Action</th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                         <tr>
                                            @foreach ($dossiers as $dossier)
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dossier->title }}</td>
                                            <td>{{ $dossier->link }}</td>
                                            <td>{{$dossier->status }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $dossier->dossier_file) }}" target="_blank">View File</a>
                                            </td>
                                            <td class="drp">
                                               <div class="dropdown">
                                                  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('dossiers.edit', $dossier->id) }}">
                                                        <i class="far fa-edit"></i>&nbsp; Edit
                                                    </a>
                                                    {{-- <form action="{{ route('dossiers.destroy', $dossier->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form> --}}
                                                    {{-- <a class="dropdown-item text-danger" 
                                                    href="{{ route('dossiers.destroy', $dossier->id) }}" 
                                                    onclick="event.preventDefault(); deleteDossier({{ $dossier->id }});">
                                                        <i class="fas fa-trash"></i>&nbsp; Delete
                                                    </a> --}}
                                                     <a class="dropdown-item text-danger" href="{{ route('dossiers.destroy', $dossier->id) }}" onclick="return confirm('Are you sure you want to delete this record?');">
                                                        <i class="fas fa-trash"></i>&nbsp; Delete
                                                    </a>
                                                  </div>
                                               </div>
                                            </td>
                                         </tr>
                                         @endforeach
                                      </tbody>
                                   </table>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
            </div>
            {{-- @include('admin.include.footer') --}}
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script>
        function deleteDossier(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                fetch(`/superadmin/dossiers/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        alert('Dossier deleted successfully!');
                        // Optionally reload the page or remove the deleted row
                        location.reload(); // Reload the page
                    } else {
                        alert('Failed to delete dossier. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        }

    </script> --}}
  

</body>

</html>