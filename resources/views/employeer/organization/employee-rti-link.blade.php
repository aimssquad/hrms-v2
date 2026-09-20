@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Employees (RTI)'))

@section('content')

<!-- Page Content -->

<div class="content container-fluid pb-0">


<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">

            <h3 class="page-title">
                {{ \App\Helpers\Helper::cachedTrans('Employees (RTI)') }}
                <span class="dual-lang-sub notranslate">Employees (RTI)</span>
            </h3>

            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('organization.home') }}">
                        {{ \App\Helpers\Helper::cachedTrans('Dashboard') }}
                        <span class="dual-lang-sub notranslate">Dashboard</span>
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    {{ \App\Helpers\Helper::cachedTrans('Employees (RTI)') }}
                    <span class="dual-lang-sub notranslate">Employees (RTI)</span>
                </li>
            </ul>

        </div>
    </div>
</div>
<!-- /Page Header -->


<div class="row">
    <div class="col-md-12">

        <div class="card custom-card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h4 class="card-title">
                    <i class="far fa-file"
                       aria-hidden="true"
                       style="color:#ffa318;"></i>&nbsp;

                    {{ \App\Helpers\Helper::cachedTrans('Employees (RTI)') }}
                    <span class="dual-lang-sub notranslate">Employees (RTI)</span>
                </h4>


                <div class="row">

                    <!-- Export Excel -->
                    <div class="col-auto">
                        <form action="{{ route('exportTableData') }}"
                              method="POST"
                              id="exportForm"
                              class="d-inline">

                            @csrf

                            <input type="hidden" name="data" id="data">
                            <input type="hidden" name="headings" id="headings">
                            <input type="hidden" name="filename" id="filename">

                            <input type="hidden"
                                   id="filenameInput"
                                   value="Employee-rtilink">

                            <button type="submit"
                                    class="btn-download btn-download-excel me-0">

                                {{ \App\Helpers\Helper::cachedTrans('Export to Excel') }}

                                <span class="dual-lang-sub notranslate">
                                    Export to Excel
                                </span>

                            </button>
                        </form>
                    </div>


                    <!-- Export PDF -->
                    <div class="col-auto">
                        <form action="{{ route('exportPDF') }}"
                              method="POST"
                              id="exportPDFForm">

                            @csrf

                            <input type="hidden" name="data" id="pdfData">
                            <input type="hidden" name="headings" id="pdfHeadings">
                            <input type="hidden" name="filename" id="pdfFilename">

                            <button type="submit"
                                    class="btn-download btn-download-pdf">

                                {{ \App\Helpers\Helper::cachedTrans('Export to PDF') }}

                                <span class="dual-lang-sub notranslate">
                                    Export to PDF
                                </span>

                            </button>

                        </form>
                    </div>

                </div>
            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table id="basic-datatables"
                           class="display table table-striped table-hover">

                        <thead>
                            <tr>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Sl No.') }}
                                    <span class="dual-lang-sub notranslate">
                                        Sl No.
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Employee Name') }}
                                    <span class="dual-lang-sub notranslate">
                                        Employee Name
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Department') }}
                                    <span class="dual-lang-sub notranslate">
                                        Department
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Job Type') }}
                                    <span class="dual-lang-sub notranslate">
                                        Job Type
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Job Title') }}
                                    <span class="dual-lang-sub notranslate">
                                        Job Title
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Immigration Status') }}
                                    <span class="dual-lang-sub notranslate">
                                        Immigration Status
                                    </span>
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            @php
                                $employee_or_rs = DB::table('company_employee')
                                    ->where('emid', '=', $companies_rs->reg)
                                    ->get();

                                $countwmploor = count($employee_or_rs);
                            @endphp


                            @if ($countwmploor != 0)

                                @foreach($employee_or_rs as $empuprotgans)

                                    @if ($empuprotgans->name != '')

                                        <tr>

                                            <!-- Sl No -->
                                            <td>
                                                {{ $loop->iteration }}
                                                <span class="dual-lang-sub notranslate">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>


                                            <!-- Employee Name -->
                                            <td>
                                                {{ $empuprotgans->name }}

                                                <span class="dual-lang-sub notranslate">
                                                    {{ $empuprotgans->name }}
                                                </span>
                                            </td>


                                            <!-- Department -->
                                            <td>
                                                {{ \App\Helpers\Helper::cachedTrans($empuprotgans->department) }}

                                                <span class="dual-lang-sub notranslate">
                                                    {{ $empuprotgans->department }}
                                                </span>
                                            </td>


                                            <!-- Job Type -->
                                            <td>
                                                {{ \App\Helpers\Helper::cachedTrans($empuprotgans->job_type) }}

                                                <span class="dual-lang-sub notranslate">
                                                    {{ $empuprotgans->job_type }}
                                                </span>
                                            </td>


                                            <!-- Job Title -->
                                            <td>
                                                {{ \App\Helpers\Helper::cachedTrans($empuprotgans->designation) }}

                                                <span class="dual-lang-sub notranslate">
                                                    {{ $empuprotgans->designation }}
                                                </span>
                                            </td>


                                            <!-- Immigration Status -->
                                            <td>
                                                {{ \App\Helpers\Helper::cachedTrans($empuprotgans->immigration) }}

                                                <span class="dual-lang-sub notranslate">
                                                    {{ $empuprotgans->immigration }}
                                                </span>
                                            </td>

                                        </tr>

                                    @endif

                                @endforeach

                            @endif

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>


</div>
<!-- /Page Content -->
@endsection

@section('script')

<!--script Content-->

<script>

    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }

</script>

<!--/script Content-->

@endsection
