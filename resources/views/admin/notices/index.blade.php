@include('admin.include.head')
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
                           <h4 class="card-title"><i class="far fa-user"></i> Notices <span><a data-toggle="tooltip" data-placement="bottom" title="Add Notice" href="{{ route('notices.create') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
                           @include('layout/message')
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="basic-datatables" class="display table table-striped table-hover" >
                                 <thead>
                                    <tr>
                                       <th>Sl.No.</th>
                                       <th>Title</th>
                                       <th>Start Date</th>
                                       <th>End Date</th>
                                       <th>Notice For</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php $i = 1;?>
                                        @foreach($notices as $datas)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datas->title }}</td>
                                        <td>{{ $datas->start_date }}</td>
                                        <td>{{ $datas->end_date }}</td>
                                        <td>{{ ucwords($datas->notice_for) }}</td>
                                        <td>
                                          @php
                                              $currentDate = now();
                                              $startDate = \Carbon\Carbon::parse($datas->start_date);
                                              $endDate = \Carbon\Carbon::parse($datas->end_date);
                                          @endphp
                                      
                                          @if ($currentDate->between($startDate, $endDate))
                                              <span class="badge badge-success">Active</span>
                                          @else
                                              <span class="badge badge-danger">Expired</span>
                                          @endif
                                      </td>

                                        <td class="icon">
                                          <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ route('notices.edit', $datas->id) }}">
                                             <img style="width: 14px;" src="{{ asset('assets/img/edit.png') }}">
                                         </a>
                                         <a data-toggle="tooltip" data-placement="bottom" title="Delete" href="javascript:void(0);" 
                                             onclick="confirmDelete('{{ route('notices.destroy', ['id' => $datas->id]) }}')">
                                             <img style="width: 14px;" src="{{ asset('assets/img/delete.png') }}">
                                          </a>
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
   @include('admin.include.script2')

   <script>
      function confirmDelete(url) {
          if (confirm('Are you sure you want to delete this notice?')) {
              // Create a hidden form to send the DELETE request
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = url;
  
              // Add CSRF token for Laravel
              const csrfInput = document.createElement('input');
              csrfInput.type = 'hidden';
              csrfInput.name = '_token';
              csrfInput.value = '{{ csrf_token() }}';
              form.appendChild(csrfInput);
  
              // Add the DELETE method spoofing input
              const methodInput = document.createElement('input');
              methodInput.type = 'hidden';
              methodInput.name = '_method';
              methodInput.value = 'DELETE';
              form.appendChild(methodInput);
  
              // Append the form to the body and submit it
              document.body.appendChild(form);
              form.submit();
          }
      }
  </script>

</body>
</html>
