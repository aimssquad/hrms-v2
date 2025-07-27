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
                                 <i class="far-fa-building"></i> All Organisation Filter
                                 
                              </h4>
                              {{-- @if(Session::has('message'))
                              <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                              @endif --}}
                           </div>
                           <div class="card-body">
                                <form method="GET" action="{{ url()->current() }}">
                                    <div class="row mb-4">
                                        <!-- Search Input -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="search">Search</label>
                                                <input type="text" class="form-control" id="search" name="search" 
                                                    placeholder="Search by Organisation name or email" value="{{ request('search') }}">
                                            </div>
                                        </div>
                                        
                                        <!-- Status Filter -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="">Select</option>
                                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Verification Filter -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="verify">Verification</label>
                                                <select class="form-control" id="verify" name="verify">
                                                    <option value="">Select</option>
                                                    <option value="approved" {{ request('verify') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="not approved" {{ request('verify') == 'not approved' ? 'selected' : '' }}>Not Approved</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Buttons - Now in their own column aligned to the right -->
                                        <div class="col-md-5 d-flex align-items-end justify-content-center">
                                            <div class="form-group d-flex">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                                <a href="{{ url()->current() }}" class="btn btn-secondary">
                                                    <i class="fas fa-sync-alt"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           </div>
                         
                           <div class="card-body">
                              <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Organisation Name</th>
                                            <th>Organisation Address</th>
                                            <th>Login User ID</th>
                                            <th>Password</th>
                                            <th>Phone No.</th>
                                            <th>Status</th>
                                            <th>Verification</th>
                                            <th>Sub-Admins</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($result as $company)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $company['org_com_name'] }}</td>
                                            <td>
                                                @if($company['org_address'])
                                                    {{ $company['org_address'] }}
                                                    @if($company['org_city']), {{ $company['org_city'] }} @endif
                                                @endif
                                            </td>
                                            <td>{{ $company['org_email'] }}</td>
                                            <td>{{ $company['org_password'] }}</td>
                                            <td>{{ $company['org_phone'] }}</td>
                                            <td>{{ strtoupper($company['org_status']) }}</td>
                                            <td>
                                                @if($company['org_verify'] == 'approved')
                                                    VERIFIED
                                                @else
                                                    NOT VERIFIED
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($company['sub_admins']) > 0)
                                                    @foreach($company['sub_admins'] as $subAdmin)
                                                        {{$subAdmin['sub_com_name']}}
                                                    @endforeach
                                                    {{-- <div class="dropdown">
                                                        <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="subAdminDropdown{{ $loop->index }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            View Sub-Admins ({{ count($company['sub_admins']) }})
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="subAdminDropdown{{ $loop->index }}">
                                                            @foreach($company['sub_admins'] as $subAdmin)
                                                                <a class="dropdown-item" href="#">
                                                                    <strong>{{ $subAdmin['sub_name'] }}</strong><br>
                                                                    {{ $subAdmin['sub_email'] }}<br>
                                                                    Status: {{ strtoupper($subAdmin['sub_status']) }}<br>
                                                                    Verified: {{ $subAdmin['sub_verify'] == 'approved' ? 'YES' : 'NO' }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div> --}}
                                                @else
                                                    No
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown{{ $loop->index }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="actionDropdown{{ $loop->index }}">
                                                        <a class="dropdown-item" href="{{ url('superadmin/edit-company/'.$company['id']) }}">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                        @if(count($company['sub_admins']) > 0)
                                                            <div class="dropdown-divider"></div>
                                                            <h6 class="dropdown-header">Sub-Admin Actions</h6>
                                                            @foreach($company['sub_admins'] as $subAdmin)
                                                                <a class="dropdown-item" href="#">
                                                                    <i class="fas fa-user-edit"></i> Edit {{ $subAdmin['sub_name'] }}
                                                                </a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td> --}}
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
   </body>
</html>