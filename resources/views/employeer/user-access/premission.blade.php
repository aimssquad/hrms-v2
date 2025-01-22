@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems();
    //dd($sidebarItems);
@endphp
@extends('employeer.include.app')
@section('title', 'Employee Permission')
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('user-access-role/dashboard')}}">User Permissions Dashboard</a></li>
            <li class="breadcrumb-item active">Employee Permission</li> 
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-user"></i> {{$employee_id}}  Employee Permission</h4>
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                    <form action="{{ url('user-access/emp-permission') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee_id }}">
                    
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h5 class="card-title m-b-20">Module Access</h5>
                                @php
                                    $moduleNames = array_column($sidebarItems, 'module_name');
                                @endphp
                                <table class="table table-striped custom-table" style="border: 1px solid rgb(204, 200, 200);">
                                    <thead>
                                        <tr>
                                            <th style="color:#3103fc"><strong>Module Name</strong></th>
                                            <th style="color:#4e03fc"><strong>Submenu</strong></th>
                                            <th class="text-center" style="color:#4e03fc"></th>
                                            {{-- <th class="text-center" style="color:#0307fa">Edit</th>
                                            <th class="text-center" style="color:#fa0202">Delete</th>
                                            <th class="text-center" style="color:#fa0202">Export</th>
                                            <th class="text-center" style="color:#fa0202">Import</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menu as $moduleIndex => $module)
                                            @if (in_array($module->id, $moduleNames))
                                                <!-- Module Row -->
                                                <tr>
                                                    <td>
                                                        <h4 style="color:#FF902F">{{ $module->module_name }}</h4>
                                                    </td>
                                                    <td>
                                                        <h4 style="font-size: 18px">Add All</h4>
                                                    </td>
                                                    <td class="text-center">
                                                        <label class="custom_check">
                                                            <input type="checkbox" 
                                                                class="module-checkbox" 
                                                                data-module-index="{{ $moduleIndex }}" 
                                                                name="modules[{{ $moduleIndex }}][module_name]" 
                                                                value="{{ $module->module_name }}"
                                                                {{ $permission->contains(function ($perm) use ($module) {
                                                                    return $module->subMenus->contains('id', $perm->submenu_id);
                                                                }) ? 'checked' : '' }}>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                    
                                                <!-- Submenu Rows -->
                                                @foreach ($module->subMenus as $submenu)
                                                    <tr class="submenu-row-{{ $moduleIndex }}">
                                                        <td></td>
                                                        <td class="ps-5">
                                                            {{-- <input type="hidden" name="modules[{{ $moduleIndex }}][submenus][{{ $submenu->id }}][submenu_name]" value="{{ $submenu->submenu_name }}"> --}}
                                                            {{ $submenu->submenu_name }}
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="custom_check">
                                                                <input type="checkbox" 
                                                                    class="submenu-checkbox-{{ $moduleIndex }}" 
                                                                    name="modules[{{ $moduleIndex }}][submenus][{{ $submenu->id }}][add]" 
                                                                    value="1" {{ $permission->first(function ($perm) use ($submenu) {
                                                                        return $perm->submenu_id === $submenu->id && $perm->can_add == 1;
                                                                    }) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                        {{-- <td class="text-center">
                                                            <label class="custom_check">
                                                                <input type="checkbox" 
                                                                    class="submenu-checkbox-{{ $moduleIndex }}" 
                                                                    name="modules[{{ $moduleIndex }}][submenus][{{ $submenu->id }}][edit]" 
                                                                    value="1"
                                                                    {{ $permission->first(function ($perm) use ($submenu) {
                                                                        return $perm->submenu_id === $submenu->id && $perm->can_edit == 1;
                                                                    }) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="custom_check">
                                                                <input type="checkbox" 
                                                                    class="submenu-checkbox-{{ $moduleIndex }}" 
                                                                    name="modules[{{ $moduleIndex }}][submenus][{{ $submenu->id }}][delete]" 
                                                                    value="1"
                                                                    {{ $permission->first(function ($perm) use ($submenu) {
                                                                        return $perm->submenu_id === $submenu->id && $perm->can_delete == 1;
                                                                    }) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="custom_check">
                                                                <input type="checkbox" 
                                                                    class="submenu-checkbox-{{ $moduleIndex }}" 
                                                                    name="modules[{{ $moduleIndex }}][submenus][{{ $submenu->id }}][export]" 
                                                                    value="1"
                                                                    {{ $permission->first(function ($perm) use ($submenu) {
                                                                        return $perm->submenu_id === $submenu->id && $perm->can_export == 1;
                                                                    }) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="custom_check">
                                                                <input type="checkbox" 
                                                                    class="submenu-checkbox-{{ $moduleIndex }}" 
                                                                    name="modules[{{ $moduleIndex }}][submenus][{{ $submenu->id }}][import]" 
                                                                    value="1"
                                                                    {{ $permission->first(function ($perm) use ($submenu) {
                                                                        return $perm->submenu_id === $submenu->id && $perm->can_import == 1;
                                                                    }) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    // Handle module checkbox click
    const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
    moduleCheckboxes.forEach(moduleCheckbox => {
        moduleCheckbox.addEventListener('change', function () {
            const moduleIndex = this.getAttribute('data-module-index');
            const isChecked = this.checked;

            // Select/deselect all submenus under this module
            const submenuCheckboxes = document.querySelectorAll(`.submenu-checkbox-${moduleIndex}`);
            submenuCheckboxes.forEach(submenuCheckbox => {
                submenuCheckbox.checked = isChecked;
            });
        });
    });

    // Remove unchecked submenus before form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function (e) {
        const allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        allCheckboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.name = ''; // Remove the name attribute of unchecked checkboxes
            }
        });
    });
});

    </script>
@endsection