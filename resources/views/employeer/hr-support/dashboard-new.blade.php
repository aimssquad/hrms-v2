@extends('employeer.include.app')

@section('title', 'Home - HRMS admin template')

@section('css')
<style>

.accordion-secondary .accordion-button {
    background-color: #f8f9fa;
}

.accordion-tertiary .accordion-button {
    background-color: #e9ecef;
}
</style>

@endsection

@section('content')

                <div class="content container-fluid pb-0">
					<div class="row">
						

                      
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Hr Support Files</div>
                                </div>
                                <div class="card-body">
                                  
                                    <div class="accordion accordion-primary" id="accordionType">
                                        @foreach($data as $type)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingType{{ $type->id }}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseType{{ $type->id }}" aria-expanded="false" aria-controls="collapseType{{ $type->id }}">
                                                        {{ $type->type }}
                                                    </button>
                                                </h2>
                                                <div id="collapseType{{ $type->id }}" class="accordion-collapse collapse" aria-labelledby="headingType{{ $type->id }}" data-bs-parent="#accordionType">
                                                    <div class="accordion-body">
                                                        <div class="accordion accordion-secondary" id="accordionSubtype{{ $type->id }}">
                                                            @foreach($type->subHrFileTypes as $subtype)
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="headingSubtype{{ $subtype->id }}">
                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubtype{{ $subtype->id }}" aria-expanded="false" aria-controls="collapseSubtype{{ $subtype->id }}">
                                                                            {{ $subtype->sub_name }}
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapseSubtype{{ $subtype->id }}" class="accordion-collapse collapse" aria-labelledby="headingSubtype{{ $subtype->id }}" data-bs-parent="#accordionSubtype{{ $type->id }}">
                                                                        <div class="accordion-body">
                                                                            <div class="accordion accordion-tertiary" id="accordionFiles{{ $subtype->id }}">
                                                                                @foreach($subtype->hrSupportFiles as $file)
                                                                                    <div class="accordion-item">
                                                                                        <h2 class="accordion-header" id="headingFile{{ $file->id }}">
                                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFile{{ $file->id }}" aria-expanded="false" aria-controls="collapseFile{{ $file->id }}">
                                                                                                {{ $file->title }}
                                                                                            </button>
                                                                                        </h2>
                                                                                        <div id="collapseFile{{ $file->id }}" class="accordion-collapse collapse" aria-labelledby="headingFile{{ $file->id }}" data-bs-parent="#accordionFiles{{ $subtype->id }}">
                                                                                            <div class="accordion-body d-flex justify-content-between align-items-center">
                                                                                                <div>
                                                                                                    <strong>{!! $file->small_description ?? '' !!}</strong> - {!! $file->description ?? '' !!}

                                                                                                </div>
                                                                                                <div>
                                                                                                    <!-- View Icon -->
                                                                                                    <a href="{{ isset($file->id) ? route('support-file.details', ['id' => $file->id]) : '#' }}" class="btn btn-small btn-primary" title="View">
                                                                                                        <i class="fa fa-eye" data-bs-toggle="tooltip" title="View "></i>
                                                                                                    </a>
                                                                                                    <!-- Download Icon -->

                                                                                                    <a href=" {{ asset('storage/app/public/hrsupport/pdf/' . $file->pdf) }}" class="btn btn-small btn-primary"  title="Download" target="_blank">
                                                                                                        <i class="fa fa-sticky-note" data-bs-toggle="tooltip" title="View pdf" ></i>
                                                                                                    </a>

                                                                                                    <a href="{{ asset('storage/app/public/hrsupport/doc/' . $file->doc) }}" class="btn btn-small btn-primary"  title="Download" download>
                                                                                                        <i class="fa fa-arrow-circle-down" data-bs-toggle="tooltip" title="Download DOC" ></i>
                                                                                                    </a>

                                                                                                  
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
					</div>
                </div>
                  


@endsection