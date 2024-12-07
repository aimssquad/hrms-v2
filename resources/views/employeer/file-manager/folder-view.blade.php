@extends('employeer.include.app')
@section('title', 'Add Folder')
@section('css')
<style>
    .card-body a {
    display: inline-block;
    /*width: 100px;*/
    /*height: 100px;*/
    text-align: center;
    /*background: #f4f4f4;*/
    /*border: 1px solid #e4e4e4;*/
    padding:0px;
    margin: 2px;
    border-radius: 10px;
    vertical-align: top;
    position: relative;
    color:#000;
}
.card-body a:hover{
    color:#000;
}
</style>
@endsection
@section('content')
<div class="content container-fluid pb-0">
    <div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Add Folder</h3>
			</div>
			<div class="col-auto float-end ms-auto">
				{{-- <a href="{{ url('fileManagment/fileManagment-add') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Folder</a> --}}
                <button type="button" class="btn btn-primary mx-1" title="Import Files"  data-toggle="modal" data-target="#exampleModal1">
                    <i class="fa-solid fa-plus"></i> Add Folder
                </button>
			</div>
		</div>
	</div>
    @include('employeer.layout.message')
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header">
                    <h4 class="card-title"><i class="far fa-folder" aria-hidden="true"
                            style="color:#f80606;"></i>&nbsp;Add Folder<span>
                    </h4>
                </div>
                <div class="card-body">
                    @foreach($file_image as $item)
                    <a href="{{url('org-fileManagment/file-add/'.$item->id)}}" class="mb-2"><img src="{{asset('filemanagment/folder.png')}}" style="width:50px; border-radius:10px">
                    <p><?php echo $item->folder_name ?> </p>
                       </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
     <!-- Modal -->
   <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form style='padding: 0px;' action="{{url('org-fileManagment/saveFolder')}}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-content">
            <div class="modal-body">
                {{-- <div id="validationMessage" style="border: 1px solid red; color:red"></div> --}}
                <input type="hidden" name="empId" value="{{$data->emp_id}}">
                <input type="hidden" name="fileName" value="{{$data->file_name}}">
                <input type="hidden" name="orgId" value="{{$data->organization_id}}">
                <input type="hidden" name="file_id" value="{{ request()->route('id') }}">
                <div class="form-group">
                  <label for="excel_file">Folder Name</label>
                  <input type="text" name="folder_name" class="form-control" style='height: 40px;' id="fileInput" required>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="validateButton"  onclick="hello()">submit</button>
            </div>
            {{-- <div id="validationMessage"></div> --}}
          </div>
      </form>
    </div>
  </div>
  <!-- END -->

   <!-- Modal -->
   <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form style='padding: 0px;' action="{{url('fileManagment/updateUpload')}}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="file_id" name="fileupload_id">
                <input type="hidden" name="org_id" value="{{ request()->route('id') }}">
                <div class="form-group">
                  <label for="excel_file">File Name</label>
                  <input type="text" name="file_rename" class="form-control"  style='height: 40px;' id="filerenameid" required>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" style="padding: 0px 8px;height: 32px;" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="validateButton" onclick="hello()">Update</button>
            </div>
          </div>
      </form>
    </div>
  </div>
  <!-- END -->
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function helopj(id,fileRename){
       $("#file_id").val(id);
       $("#filerenameid").val(fileRename) ;
    }
</script>
@endsection