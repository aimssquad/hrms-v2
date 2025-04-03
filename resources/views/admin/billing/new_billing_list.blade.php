<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
      {{-- <link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/> --}}
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
                               <i class="far fa-building"></i> Invoice Not Issued For Partner&Organisation List <span><a href="{{ url('superadmin/partner-org-notissued') }}" data-toggle="tooltip" data-placement="bottom" title="Show Not Issued List" style="padding: 8px 0;"><img  style="width: 25px;" src="{{ asset('img/work_checks.png')}}"></a></span><br> 
                            </h4>
                            @if(Session::has('message'))
                            <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                            @endif
                            @if(Session::has('error'))
                            <div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('error') }}</em></div>
                            @endif
                         </div>
                        <div class="card-body">
                            <h4 class="card-title">
                                <i class="far fa-building"></i>Invoice <span><a href="{{ url('superadmin/add-billing2') }}" data-toggle="tooltip" data-placement="bottom" title="Create Invoice" style="padding: 8px 0;"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span><br>   
                             </h4>
                           <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead>
                                   <tr>
                                      <th>Sl.No.</th>
                                      <th>Invoice.No.</th>
                                      <th>Billg Item</th>
                                      <th>Billing Month</th>
                                      <th>Billing To</th>
                                      <th>Entity Id</th>
                                      <th>Amount</th>
                                      <th>Total Employee</th>
                                      <th>Vat</th>
                                      <th>Total Amount</th>
                                      <th>Payment Mode</th>
                                      <th>Payment Id</th>
                                      <th>Payment Document</th>
                                      {{-- <th>Description</th> --}}
                                      <th>Action</th>
                                   </tr>
                                </thead>
                                <tbody>
                                  @foreach($billing_list as $billing)
                                      {{-- @php
                                         DB::table('registration')->where('') 
                                      @endphp --}}
                                   <tr>
                                      <td>{{$loop->iteration}}</td>
                                      <td><a href="{{ route('admin.billing.invoice', $billing->id) }}">{{$billing->invoice_no}}</a></td>
                                      <td>{{$billing->bill_for ?? 'NA'}}</td>
                                      {{-- <td>{{$billing->billFor->item_name ?? 'NA'}}</td> --}}
                                      <td>{{ \Carbon\Carbon::parse($billing->date)->format('d-m-Y')  ?? 'NA'}}</td>
                                      <td>{{$billing->billing_type  ?? 'NA'}}</td>
                                      <td>{{$billing->company->name  ?? 'NA'}}</td>
                                      {{-- <td>{{$billing->entity_id}}</td> --}}
                                      <td>{{$billing->amount  ?? 'NA'}}</td>
                                      <td>{{$billing->total_employee  ?? 'NA'}}</td>
                                      <td>{{$billing->vat ?? 'NA'}}</td>
                                      <td>{{$billing->total_amount  ?? 'NA'}}</td>
                                      <td>{{$billing->payment_mode  ?? 'NA'}}</td>
                                      <td>{{$billing->payment_dtl ?? 'NA'}}</td>
                                      <td>
                                          @if ($billing->payment_document)
                                              <a href="{{ asset('storage/' . $billing->payment_document) }}" target="blank"><img src="{{ asset('storage/' . $billing->payment_document) }}" alt="Payment Document" style="width: 100px; height: auto;"></a>
                                          @else
                                              NA
                                          @endif
                                      </td>
                                      {{-- <td>{{$billing->description}}</td> --}}
                                      <td class="drp">
                                         <div class="dropdown">
                                            <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                               <a class="dropdown-item" href="{{ route('superadmin.billing.edit', $billing->id) }}"><i class="far fa-edit"></i>&nbsp; Edit</a>
                                               @if($billing->payment_status == 0)
                                               <a class="dropdown-item text-danger" href="{{ route('billing.delete', $billing->id) }}" onclick="return confirm('Are you sure you want to delete this record?');">
                                                  <i class="fas fa-trash"></i>&nbsp; Delete
                                              </a>
                                               @endif
                                               <a class="dropdown-item" href="{{ route('admin.billing.invoice', $billing->id) }}" target="_blank"><i class="fas fa-eye"></i>&nbsp; View Invoice</a> 
                                               {{-- <a class="dropdown-item" target="_blank" href="#" ><i class="fas fa-eye"></i>&nbsp; Download Invoice</a> --}}
                                               <a class="dropdown-item" href="{{ route('admin.invoice.mail', $billing->id) }}"><i class="fas fa-paper-plane"></i>&nbsp; Send Email</a>
                                               <a class="dropdown-item" href=""><i class="fa fa-comments"></i>&nbsp; Remarks</a>
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
