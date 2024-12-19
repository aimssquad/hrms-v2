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
                              <h4 class="card-title"><i class="far fa-newspaper"></i>Dossier Lavel3 Add</h4>
                           </div>
                           <div class="card-body">
                            <form action="{{ url('superadmin/dossiers3save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectFloatingLabel3" class="placeholder">Sponsor Management Dossier</label>		
                                            <select class="form-control input-border-bottom" id="dossier_id" name="dossier_id" required>
                                                <option value="">Select</option>
                                                @foreach($dossiers as $dossier)
                                                    <option value="{{$dossier->id}}">{{$dossier->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectFloatingLabel3" class="placeholder">Dossier Level 2</label>		
                                            <select class="form-control input-border-bottom" id="dossier_id2" name="dossier_id2" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="selectFloatingLabel3" class="placeholder">Dossier3 Title</label>		
                                            <input type="text" id="title" name="title3" class="form-control" required value="">
                                        </div>
                                    </div>
                                    <div id="duplicate_row_container">
                                        <div id="duplicate_row" class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel3" class="placeholder">Dossier File Name</label>	
                                                    <textarea id="description" name="file_name[]" class="form-control input-border-bottom" required></textarea>	
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel3" class="placeholder">Dossier Description & Link</label>	
                                                    <textarea id="description" name="description[]" class="form-control input-border-bottom" required></textarea>	
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="selectFloatingimage" class="placeholder">Dossier3 File</label>
                                                    <input id="dossier_file3" type="file" class="form-control" name="file[]" onchange="Filevalidationproimge()">
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-right mt-2">
                                                <button type="button" class="btn btn-primary add-row">Add</button>
                                                <button type="button" class="btn btn-danger remove-row">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="col-md-2 mt-3">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </form>
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
      <!--   Core JS Files   -->
    @include('admin.include.script')
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('smalldescription');
    </script>
      <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#dossierForm").on("submit", function (e) {
                const fileInput = $("#dossier_file")[0];
                const maxSize = 3 * 1024 * 1024; // 3 MB in bytes
        
                if (fileInput.files.length > 0) {
                    const fileSize = fileInput.files[0].size;
        
                    if (fileSize > maxSize) {
                        e.preventDefault(); // Prevent form submission
                        alert("The file size must not exceed 3 MB.");
                        return false;
                    }
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#dossier_id').on('change', function() {
                var dossierId = $(this).val();  // Get the selected dossier_id

                // Check if a valid dossier_id is selected
                if (dossierId) {
                    // Send an AJAX request to fetch Dossier2 entries
                    $.ajax({
                        url: '/superadmin/get-dossier2-by-dossier',  // Define the URL of the route
                        type: 'GET',
                        data: {
                            dossier_id: dossierId  // Pass the selected dossier_id as data
                        },
                        success: function(response) {
                            // Clear the current options in the dossier_id2 dropdown
                            $('#dossier_id2').empty();
                            $('#dossier_id2').append('<option value="">Select</option>'); // Add the default "Select" option

                            // Loop through the response data (which should be Dossier2 entries) and append to the second dropdown
                            $.each(response.dossiers2, function(key, dossier2) {
                                $('#dossier_id2').append('<option value="' + dossier2.id + '">' + dossier2.title2 + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching Dossier2:', error);
                        }
                    });
                } else {
                    // If no dossier_id is selected, clear the second dropdown
                    $('#dossier_id2').empty();
                    $('#dossier_id2').append('<option value="">Select</option>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Add new row
            $(document).on("click", ".add-row", function () {
                let newRow = $("#duplicate_row").first().clone(); // Clone the first row
                newRow.find("textarea, input").val(""); // Clear input fields
                $("#duplicate_row_container").append(newRow); // Append the new row to the container
            });
    
            // Remove row
            $(document).on("click", ".remove-row", function () {
                if ($("#duplicate_row_container .row").length > 1) {
                    $(this).closest("#duplicate_row").remove(); // Remove the specific row
                } else {
                    alert("At least one row must remain!");
                }
            });
        });
    </script>
   </body>
</html>