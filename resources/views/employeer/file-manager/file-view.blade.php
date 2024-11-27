@extends('employeer.include.app')
@section('title', 'Add Folder')
@section('css')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<style>
   .card-body a {
   display: inline-block;
   width: 100px;
   height: 100px;
   text-align: center;
   background: #f4f4f4;
   border: 1px solid #e4e4e4;
   padding: 10px;
   margin: 6px;
   border-radius: 10px;
   vertical-align: top;
   position: relative;
   }
   .card-body a img{
   max-width: 100%;
   height: auto!important;
   position: absolute;
   left: 0;
   right: 0;
   margin: auto;
   top: 0;
   bottom: 0;
   }
   .file_uploading{
   margin:0;
   padding:0;
   }
   .file_uploading li {
   width: 135px;
   text-align: center;
   list-style: none;
   display: inline-block;
   margin: 0 5px;
   vertical-align: top;
   }
   .file_uploading li img{
   height: 40px;
   }
   .file_btn .material-symbols-outlined {
   font-size: 15px;
   }
   .file_btn {
   right: 0;
       position: absolute;
    top: -13px;
   }
   .file_uploading a{
   color: #000;
    background: #eee;
    display: inline-block !important;
    line-height: 12px;
    width: 20px;
   }
   .file_uploading a:hover{
   color:#000;
   }
  .file_uploading p {
    line-height: 10px;
    /* margin-top: 18px; */
    height: 22px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    padding-top: 12px;
   }
</style>
@endsection
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Add Files</h3>
         </div>
         <div class="col-auto float-end ms-auto">
            {{-- <a href="{{ url('fileManagment/fileManagment-add') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Folder</a> --}}
            {{-- <button type="button" class="btn btn-primary mx-1" title="Import Files"  data-toggle="modal" data-target="#exampleModal1">
            <i class="fa-solid fa-plus"></i> Add Folder
            </button> --}}
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between mb-2">
                  <div class="mt-1"><i class="fa fa-cog" aria-hidden="true" style="color:#fda520;"></i> Files</div>
                  <div>
                     <button type="button" class="btn btn-primary mx-1" title="Import Files"  data-toggle="modal" data-target="#exampleModal1">
                     Add File
                     </button>
                  </div>
               </div>
               <div>
                  <ul class="m-0 p-0 file_uploading">
                     @foreach($file_image as $item)
                     <?php
                        $filename = 'FileManagment/'.$item->fileName.'/'.$item->uploadFile;
                         $fileInfo = pathinfo($filename);
                         $extension = $fileInfo['extension']; // $extension will be 'jpg'
                        ?> 
                     @if ($extension=="pdf")
                     {{-- <li class="position-relative shadow-lg p-2 mb-3">
                        <div class="file_btn position-absolute">
                           <a class="drop_downmain" style="    position: absolute; right: 0;" href="javascript:void(0)">
                              <div>
                                 <span class="material-symbols-outlined show">
                                 more_vert
                                 </span>
                                 <span class="material-symbols-outlined hide">
                                 close
                                 </span>
                              </div>
                           </a>
                           <div class="drop_down" style-="    background: #fff; font-size: 13px;">
                              <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                              <span class="fa-solid fa-pencil">edit</span> Edit
                              </a>
                              <a class="d-block" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                              <span class="fa-solid fa-trash-can text-danger">delete</span> Delete
                              </a>
                           </div>
                        </div>
                        <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                           <!--<div class="file_icon">-->
                           <!--   <img src="{{asset('filemanagment/pdf.png')}}">-->
                           <!--</div>-->
                           <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                        </a>
                     </li> --}}
                     <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                                <span class="fa-solid fa-pencil">edit</span>
                            </a>
                        </div>
                        <a class="dropdown-item" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                        <span class="fa-solid fa-trash-can text-danger">delete</span>
                        </a>
                        <a class="dropdown-item" href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                            <!--<div class="file_icon">-->
                            <!--    <span class="fa-solid fa-pdf text-danger">Downlode</span>-->
                            <!--</div>-->
                            <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                         </a>
                    </div>
                     @elseif ($extension=="txt")
                     <li class="position-relative shadow-sm p-2 mb-3">
                        <div class="file_btn position-absolute">
                           <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                           <span class="material-symbols-outlined">edit</span>
                           </a>
                           <a class="d-block" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                           <span class="material-symbols-outlined text-danger">delete</span>
                           </a>
                        </div>
                        <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                           <!--<div class="file_icon">-->
                           <!--   <img src="{{asset('filemanagment/txt.png')}}">-->
                           <!--</div>-->
                           <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                        </a>
                     </li>
                     @elseif($extension=="docx")
                     <li class="position-relative shadow-sm p-2 mb-3">
                        <div class="file_btn position-absolute">
                           <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                           <span class="material-symbols-outlined">edit</span>
                           </a>
                           <a class="d-block" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                           <span class="material-symbols-outlined text-danger">delete</span>
                           </a>
                        </div>
                        <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                           <!--<div class="file_icon">-->
                           <!--   <img src="{{asset('filemanagment/doc.png')}}">-->
                           <!--</div>-->
                           <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                        </a>
                     </li>
                     @else
                     <!--<li class="position-relative shadow-sm p-2 mb-3">-->
                     <!--   <div class="file_btn position-absolute">-->
                     <!--      <a href="#" class="d-block edit_btn" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">-->
                     <!--      <span class="material-symbols-outlined">Edit</span>-->
                     <!--      </a>-->
                     <!--      <a class="d-block delete_btn" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">-->
                     <!--      <span class="material-symbols-outlined text-danger">Delete</span>-->
                     <!--      </a>-->
                     <!--   </div>-->
                     <!--   <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>-->
                     <!--      <div class="file_icon">-->
                     <!--         <img src="{{asset('filemanagment/ot.png')}}">-->
                     <!--      </div>-->
                     <!--      <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>-->
                     <!--   </a>-->
                     <!--</li>-->
                     @endif
                     @endforeach
                     
                     <li class="position-relative shadow-sm p-2 mb-3">
                         <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcStvemsgeqbhOP8B1aNFbP2qBPncmpWeQUAug&s" alt="" />
                         <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                            <div class="file_btn d-flex">
                           <a href="#" class="d-block edit_btn" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                           <span class="material-symbols-outlined">
edit
</span></a>
                           <a class="d-block delete_btn ms-2" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                           <span class="material-symbols-outlined text-danger">Delete</span>
                           </a>
                        </div>
                       
                     </li>
                     
                     <li class="position-relative shadow-sm p-2 mb-3">
                         <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7lSQSZeFUAd5C-nFX5i8AtT3Qz8WUNwnU8g&s" alt="" />
                         <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                            <div class="file_btn d-flex">
                           <a href="#" class="d-block edit_btn" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                           <span class="material-symbols-outlined">
edit
</span></a>
                           <a class="d-block delete_btn ms-2" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                           <span class="material-symbols-outlined text-danger">Delete</span>
                           </a>
                        </div>
                       
                     </li>
                     
                      <li class="position-relative shadow-sm p-2 mb-3">
                         <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHxTt4LF09PvGaeWwy5eTA6J8mcse5_Pot7Q&s" alt="" />
                         <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                            <div class="file_btn d-flex">
                           <a href="#" class="d-block edit_btn" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                           <span class="material-symbols-outlined">
edit
</span></a>
                           <a class="d-block delete_btn ms-2" href="{{url('org-fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                           <span class="material-symbols-outlined text-danger">Delete</span>
                           </a>
                        </div>
                       
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form style='padding: 0px;' action="{{url('org-fileManagment/saveUpload')}}" method="post" enctype="multipart/form-data">
         @csrf
         <div class="modal-content">
            <div class="modal-body">
               {{-- 
               <div id="validationMessage" style="border: 1px solid red; color:red"></div>
               --}}
               <input type="hidden" name="empId" value="{{$data->emp_id}}">
               <input type="hidden" name="fileName" value="{{$data->file_name}}">
               <input type="hidden" name="folderName" value="{{$data->folder_name}}">
               <input type="hidden" name="orgId" value="{{$data->org_id}}">
               <input type="hidden" name="file_id" value="{{$data->file_id}}">
               <input type="hidden" name="file_add" value="{{ request()->route('id') }}">
               <div class="form-group">
                  <label for="excel_file">File Name</label>
                  <input type="text" name="file_rename[]" class="form-control" style='height: 40px;' id="fileInput" required>
                  <label for="excel_file">Upload Files</label>
                  <input type="file" name="uploadFile[]" class="form-control" style='height: 40px;' id="fileInput" multiple required>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary" id="validateButton"  onclick="hello()">submit</button>
            </div>
            {{-- 
            <div id="validationMessage"></div>
            --}}
         </div>
      </form>
   </div>
</div>
<!-- END -->
<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form style='padding: 0px;' action="{{url('org-fileManagment/updateUpload')}}" method="post" enctype="multipart/form-data">
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
               <button type="submit" class="btn btn-primary" id="validateButton" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;" onclick="hello()">Update</button>
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
   // $(".drop_down").hide();
   $(".drop_downmain").click(function(){
       
       $(".drop_down").toggleClass("action");
   });
   $(".drop_downmain").click(function(){
       
       $(".drop_downmain").toggleClass("action2");
   });
</script>
<style>
   .drop_down,.hide{
   display:none;
   opacity:0;
   }
   .drop_down.action{
   display: block;
   opacity: 1;
   background: #f8f8f8;
   padding: 5px;
   font-size: 13px;
   padding-top: 14px;
   border: 1px solid #f1f1f1;
   /*text-align: left;*/
   }
   .drop_down.action .material-symbols-outlined{
   vertical-align: middle;
   }
   .drop_downmain.action2 .show{
   display:none;
   }
   .drop_downmain.action2 .hide{
   display:block;
   opacity:1;
   }
</style>
@endsection