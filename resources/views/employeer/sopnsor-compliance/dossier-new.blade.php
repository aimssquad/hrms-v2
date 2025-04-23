







@extends('employeer.include.app')
@section('title', ' Sponsor Management Dossier')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
function my_simple_crypt( $string, $action = 'encrypt' ) {
// you may change these values to your own
$secret_key = 'bopt_saltlake_kolkata_secret_key';
$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
$output = false;
$encrypt_method = "AES-256-CBC";
$key = hash( 'sha256', $secret_key );
$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
if( $action == 'encrypt' ) {
$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
}
else if( $action == 'decrypt' ){
$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
}
return $output;
}
@endphp
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">  Sponsor Management Dossier</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active"> Sponsor Management Dossier</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
        <div class="accordion accordion-primary" id="accordionDossier">
            @foreach($dossier3Records->groupBy('dossier_id') as $dossierId => $dossier3Group)
                @php $dossier = $dossier3Group->first()->dossier @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDossier{{ $dossierId }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#collapseDossier{{ $dossierId }}" aria-expanded="false" 
                                aria-controls="collapseDossier{{ $dossierId }}">
                            {{ $dossier->title ?? 'N/A' }}
                        </button>
                    </h2>
                    <div id="collapseDossier{{ $dossierId }}" class="accordion-collapse collapse" 
                         aria-labelledby="headingDossier{{ $dossierId }}" data-bs-parent="#accordionDossier">
                        <div class="accordion-body">
        
                            <!-- Level 2: Dossier2 -->
                            <div class="accordion accordion-secondary" id="accordionDossier2{{ $dossierId }}">
                                @foreach($dossier3Group->groupBy('dossier2_id') as $dossier2Id => $dossier3SubGroup)
                                    @php $dossier2 = $dossier3SubGroup->first()->dossier2 @endphp
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingDossier2{{ $dossier2Id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                    data-bs-target="#collapseDossier2{{ $dossier2Id }}" aria-expanded="false" 
                                                    aria-controls="collapseDossier2{{ $dossier2Id }}">
                                                {{ $dossier2->title2 ?? 'N/A' }}
                                            </button>
                                        </h2>
                                        <div id="collapseDossier2{{ $dossier2Id }}" class="accordion-collapse collapse" 
                                             aria-labelledby="headingDossier2{{ $dossier2Id }}" data-bs-parent="#accordionDossier2{{ $dossierId }}">
                                            <div class="accordion-body">
        
                                                <!-- Level 3: Dossier3 -->
                                                <div class="accordion accordion-tertiary" id="accordionDossier3{{ $dossier2Id }}">
                                                    @foreach($dossier3SubGroup as $dossier3)
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingDossier3{{ $dossier3->id }}">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                                        data-bs-target="#collapseDossier3{{ $dossier3->id }}" aria-expanded="false" 
                                                                        aria-controls="collapseDossier3{{ $dossier3->id }}">
                                                                    {{ $dossier3->title3 ?? 'N/A' }}
                                                                </button>
                                                            </h2>
                                                            <div id="collapseDossier3{{ $dossier3->id }}" class="accordion-collapse collapse" 
                                                                 aria-labelledby="headingDossier3{{ $dossier3->id }}" 
                                                                 data-bs-parent="#accordionDossier3{{ $dossier2Id }}">
                                                                <div class="accordion-body">
        
                                                                    <!-- Level 4: Files -->
                                                                    <ul class="list-group">
                                                                        @foreach($dossier3->files as $file)
                                                                            <li class="list-group-item d-flex align-items-center justify-content-between" style="border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                                                                                <div>
                                                                                    <span style="font-weight: bold; margin-right: 10px; border-right: 2px solid #000; padding-right: 10px;">
                                                                                        File Name: {{ $file->file_name ?? 'N/A' }}
                                                                                    </span>
                                                                                    <span style="color: #555;">
                                                                                        Description :{{ $file->description ?? 'No description available' }}
                                                                                    </span>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="{{ asset('storage/' . $file->file) }}" class="btn btn-sm btn-outline-primary" target="_blank" style="padding: 5px 15px; font-size: 14px;">
                                                                                        <i class="fa fa-eye"></i> View File
                                                                                    </a>
                                                                                </div>
                                                                            </li>
                                                                            
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div> <!-- End Level 3 -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div> <!-- End Level 2 -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div> <!-- End Level 1 -->
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<script>
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
   
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
   
    function copyToClipboard(text, el) {
   var copyTest = document.queryCommandSupported('copy');
   var elOriginalText = el.attr('data-original-title');
   
   if (copyTest === true) {
    var copyTextArea = document.createElement("textarea");
    copyTextArea.value = text;
    document.body.appendChild(copyTextArea);
    copyTextArea.select();
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'Copied!' : 'Whoops, not copied!';
      el.attr('data-original-title', msg).tooltip('show');
    } catch (err) {
      console.log('Oops, unable to copy');
    }
    document.body.removeChild(copyTextArea);
    el.attr('data-original-title', elOriginalText);
   } else {
    // Fallback if browser doesn't support .execCommand('copy')
    window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
   }
   }
   
   $(document).ready(function() {
   // Initialize
   // ---------------------------------------------------------------------
   
   // Tooltips
   // Requires Bootstrap 3 for functionality
   $('.js-tooltip').tooltip();
   
   // Copy to clipboard
   // Grab any text in the attribute 'data-copy' and pass it to the 
   // copy function
   $('.js-copy').click(function() {
    var text = $(this).attr('data-copy');
    var el = $(this);
    copyToClipboard(text, el);
   });
   });
</script>
@endsection