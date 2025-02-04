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
                              @php
                                 $data = DB::table('registration')->where('reg',$org_id)->first();
                              @endphp
                              <h2 class="card-title">
                                 <i class="far-fa-building"></i> ( {{$data->com_name}} - {{$data->reg}}) Organization Permission 
                                 
                              </h2>
                              @if(Session::has('message'))
                              <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                              @endif
                           </div>
                           <form action="{{ url('superadmin/add-permission') }}" method="POST">
                              @csrf
                              <input type="hidden" name="employee_id" value="{{$org_id}}">
                              <div class="table-responsive">
                                  <table class="table table-striped table-bordered custom-table">
                                      <thead>
                                          <tr>
                                              <th width="50">
                                                  <label class="custom_check">
                                                      <input type="checkbox" id="all" onclick="toggleAll(this)">
                                                      <span class="checkmark"></span>
                                                  </label>
                                              </th>

                                              <th width="150" colspan="2"> <h5><b>Module Name</b></h5></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($module as $menu)
                                          <tr>
                                                <td>{{$loop->iteration}}</td>
                                              <td>
                                                  <label class="custom_check">
                                                      <input type="checkbox" 
                                                          name="modules[]" 
                                                          value="{{ $menu->id }}" 
                                                          {{ in_array($menu->id, $org_module) ? 'checked' : '' }}>
                                                      <span class="checkmark"></span>
                                                  </label>
                                              </td>
                                              <td>
                                                  <h5>{{ $menu->module_name }}</h5>
                                              </td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <button type="submit" class="btn btn-primary">Save</button>
                          </form>
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
      {{-- <script>
         document.addEventListener('DOMContentLoaded', function () {
             // Select all checkbox
             const selectAllCheckbox = document.getElementById('all');
             // All individual checkboxes
             const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
     
             // Event listener for select all checkbox
             selectAllCheckbox.addEventListener('change', function () {
                 const isChecked = selectAllCheckbox.checked;
     
                 // Select or unselect all module checkboxes
                 moduleCheckboxes.forEach(checkbox => {
                     checkbox.checked = isChecked;
                 });
             });
     
             // Handle individual checkbox changes
             moduleCheckboxes.forEach(checkbox => {
                 checkbox.addEventListener('change', function () {
                     if (!this.checked) {
                         // If any checkbox is unchecked, uncheck the "select all" checkbox
                         selectAllCheckbox.checked = false;
                     } else {
                         // If all checkboxes are checked, check the "select all" checkbox
                         selectAllCheckbox.checked = [...moduleCheckboxes].every(chk => chk.checked);
                     }
                 });
             });
         });
     </script> --}}
     <script>
      function toggleAll(source) {
          checkboxes = document.querySelectorAll('input[name="modules[]"]');
          for (let i = 0; i < checkboxes.length; i++) {
              checkboxes[i].checked = source.checked;
          }
      }
  </script>
   </body>
</html>