@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Authorizing Officer'))

@section('content')

<!-- Page Content -->

<div class="content container-fluid pb-0">

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">

            <h3 class="page-title">
                {{ \App\Helpers\Helper::cachedTrans('Authorizing Officer') }}
                <span class="dual-lang-sub notranslate">
                    Authorizing Officer
                </span>
            </h3>

            <ul class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('organization.home') }}">
                        {{ \App\Helpers\Helper::cachedTrans('Authorizing Officer') }}
                        <span class="dual-lang-sub notranslate">
                            Authorizing Officer
                        </span>
                        Dashboard
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    {{ \App\Helpers\Helper::cachedTrans('Authorizing Officer') }}
                    <span class="dual-lang-sub notranslate">
                        Authorizing Officer
                    </span>
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
                    <i class="far fa-user"
                       aria-hidden="true"
                       style="color:#ffa318;"></i>&nbsp;

                    {{ \App\Helpers\Helper::cachedTrans('Authorizing Officer') }}

                    <span class="dual-lang-sub notranslate">
                        Authorizing Officer
                    </span>
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
                                   value="Authorize-officer">

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
                                    {{ \App\Helpers\Helper::cachedTrans('Name') }}
                                    <span class="dual-lang-sub notranslate">
                                        Name
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Designation') }}
                                    <span class="dual-lang-sub notranslate">
                                        Designation
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Phone No') }}
                                    <span class="dual-lang-sub notranslate">
                                        Phone No
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Email Id') }}
                                    <span class="dual-lang-sub notranslate">
                                        Email Id
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Do you have a history of Criminal conviction/Bankruptcy?') }}
                                    <span class="dual-lang-sub notranslate">
                                        Do you have a history of Criminal conviction/Bankruptcy?
                                    </span>
                                </th>

                                <th>
                                    {{ \App\Helpers\Helper::cachedTrans('Proof Of Id') }}
                                    <span class="dual-lang-sub notranslate">
                                        Proof Of Id
                                    </span>
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            @if ($Roledata->f_name != '')

                                <tr>

                                    <!-- Sl No -->
                                    <td>
                                        1
                                        <span class="dual-lang-sub notranslate">
                                            1
                                        </span>
                                    </td>


                                    <!-- Name -->
                                    <td>
                                        {{ \App\Helpers\Helper::cachedTrans($Roledata->f_name) }}
                                        {{ \App\Helpers\Helper::cachedTrans($Roledata->l_name) }}

                                        <span class="dual-lang-sub notranslate">
                                            {{ $Roledata->f_name }}
                                            {{ $Roledata->l_name }}
                                        </span>
                                    </td>


                                    <!-- Designation -->
                                    <td>
                                        {{ \App\Helpers\Helper::cachedTrans($Roledata->desig) }}

                                        <span class="dual-lang-sub notranslate">
                                            {{ $Roledata->desig }}
                                        </span>
                                    </td>


                                    <!-- Phone -->
                                    <td>
                                        {{ \App\Helpers\Helper::cachedTrans($Roledata->con_num) }}

                                        <span class="dual-lang-sub notranslate">
                                            {{ $Roledata->con_num }}
                                        </span>
                                    </td>


                                    <!-- Email -->
                                    <td>
                                        {{ \App\Helpers\Helper::cachedTrans($Roledata->authemail) }}

                                        <span class="dual-lang-sub notranslate">
                                            {{ $Roledata->authemail }}
                                        </span>
                                    </td>


                                    <!-- Criminal / Bankruptcy -->
                                    <td>

                                        {{ \App\Helpers\Helper::cachedTrans($Roledata->bank_status) }}

                                        @if($Roledata->bank_status == 'Yes')
                                            ( {{ $Roledata->bank_other }} )
                                        @endif

                                        <span class="dual-lang-sub notranslate">

                                            {{ $Roledata->bank_status }}

                                            @if($Roledata->bank_status == 'Yes')
                                                ( {{ $Roledata->bank_other }} )
                                            @endif

                                        </span>

                                    </td>


                                    <!-- Proof Of ID -->
                                    <td>

                                        @if ($Roledata->proof != '')

                                            <a href="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}"
                                               target="_blank">

                                                <img src="{{ asset('storage/app/public/' . $companies_rs->level_proof) }}"
                                                     height="50px"
                                                     width="50px"/>

                                            </a>

                                        @else

                                            <p>
                                                {{ \App\Helpers\Helper::cachedTrans('No Proof Id') }}

                                                <span class="dual-lang-sub notranslate">
                                                    No Proof Id
                                                </span>
                                            </p>

                                        @endif

                                    </td>

                                </tr>

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
