<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
      <link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
      <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
      <script>
         WebFont.load({
         	google: {"families":["Lato:300,400,700,900"]},
         	custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
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
         .partner-header-row {
             background-color: #2c3e50;
             color: rgb(94, 154, 245);
             font-weight: bold;
         }
         .partner-details-row {
             background-color: #f8f9fa;
         }
         .org-table {
             margin-bottom: 0;
         }
         .org-table thead {
             background-color: #e9ecef;
         }
         .toggle-orgs {
             float: right;
         }
         .spacer-row {
             background-color: transparent;
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
               <!-- <h4 class="page-title">Organisation</h4> -->
            </div>
            <div class="content">
               <div class="page-inner">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card custom-card">
                           <div class="card-header">
                              <h4 class="card-title">
                                 <i class="fa fa-user"></i> Partner Organisation Employee Count    
                              </h4>
                              @if(Session::has('message'))
                              <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                              @endif
                           </div>
                           <div class="card-body">
                              <div class="table-responsive">
                                 <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="7" class="text-center">Partner and Organization Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subadmins as $subadmin)
                                            <!-- Partner Information -->
                                            <tr class="partner-header-row">
                                                <td><strong>Sl.No</strong></td>
                                                <td><strong>Partner Name:</strong></td>
                                                <td><strong>Email:</strong></td>
                                                <td><strong>Phone:</strong> </td>
                                                <td><strong>Website:</strong> </td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr class="partner-details-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td> {{ $subadmin->com_name ?? 'N/A' }}</td>
                                                <td> {{ $subadmin->email ?? 'N/A' }}</td>
                                                <td>{{ $subadmin->phone ?? 'N/A' }}</td>
                                                <td>{{ $subadmin->website ?? 'N/A' }}</td>
                                                <td colspan="2">
                                                    @if($subadmin->organizations->isNotEmpty())
                                                        <button class="btn btn-sm btn-primary toggle-orgs" data-partner-id="{{ $subadmin->id }}">
                                                            <i class="fas fa-plus"></i> Show Organizations
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                
                                            <!-- Organizations Section (hidden by default) -->
                                            <tr class="org-section org-section-{{ $subadmin->id }}" style="display: none;">
                                                <td colspan="7">
                                                    <table class="table table-bordered org-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Organization Name</th>
                                                                <th>Active Employees</th>
                                                                <th>Inactive Employees</th>
                                                                <th>Created At</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($subadmin->organizations as $index => $organization)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $organization->com_name }}</td>
                                                                    <td>{{ $organization->active_count ?? 0 }}</td>
                                                                    <td>{{ $organization->inactive_count ?? 0 }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($organization->created_at)->format('m-d-Y') }}</td>
                                                                    <td>
                                                                        <span class="badge badge-success">Active</span>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">No organizations found</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            
                                            <!-- Spacer row between partners -->
                                            <tr class="spacer-row">
                                                <td colspan="7" style="height: 20px;"></td>
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
            @include('admin.include.footer')
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
      <script >
         $(document).ready(function() {
         	$('#basic-datatables').DataTable({
         	});

         	$('#multi-filter-select').DataTable( {
         		"pageLength": 5,
         		initComplete: function () {
         			this.api().columns().every( function () {
         				var column = this;
         				var select = $('<select class="form-control"><option value=""></option></select>')
         				.appendTo( $(column.footer()).empty() )
         				.on( 'change', function () {
         					var val = $.fn.dataTable.util.escapeRegex(
         						$(this).val()
         						);

         					column
         					.search( val ? '^'+val+'$' : '', true, false )
         					.draw();
         				} );

         				column.data().unique().sort().each( function ( d, j ) {
         					select.append( '<option value="'+d+'">'+d+'</option>' )
         				} );
         			} );
         		}
         	});

         	// Add Row
         	$('#add-row').DataTable({
         		"pageLength": 5,
         	});

         	var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

         	$('#addRowButton').click(function() {
         		$('#add-row').dataTable().fnAddData([
         			$("#addName").val(),
         			$("#addPosition").val(),
         			$("#addOffice").val(),
         			action
         			]);
         		$('#addRowModal').modal('hide');

         	});
         });
      </script>
      <script>
         $(document).ready(function() {
             $('.toggle-orgs').click(function() {
                 var partnerId = $(this).data('partner-id');
                 var orgSection = $('.org-section-' + partnerId);
                 var icon = $(this).find('i');
                 
                 if (orgSection.is(':hidden')) {
                     orgSection.show();
                     icon.removeClass('fa-plus').addClass('fa-minus');
                     $(this).html('<i class="fas fa-minus"></i> Hide Organizations');
                 } else {
                     orgSection.hide();
                     icon.removeClass('fa-minus').addClass('fa-plus');
                     $(this).html('<i class="fas fa-plus"></i> Show Organizations');
                 }
             });
         });
         </script>
   </body>
</html>
