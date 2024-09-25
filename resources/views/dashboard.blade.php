@extends('layouts.app') @section('title', 'Home') @section('content')
<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3>{{ config("app.name") }} Dashboard</h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            <div class="dropdown me-2 d-inline-block position-relative">
                <a
                    class="btn btn-light bg-white shadow-sm dropdown-toggle"
                    href="#"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                >
                    <i class="align-middle mt-n1" data-lucide="calendar"></i>
                    Today
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Settings</h6>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>

            <button class="btn btn-primary shadow-sm">
                <i class="align-middle" data-lucide="filter">&nbsp;</i>
            </button>
            <button class="btn btn-primary shadow-sm">
                <i class="align-middle" data-lucide="refresh-cw">&nbsp;</i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card illustration flex-fill">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">
                                    Welcome Back, {{ Auth::user()->userId }}!
                                </h4>
                                <p class="mb-0">DigitalBook Dashboard</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img
                                src="{{ URL::asset('build/assets/images/customer-support.png'); }}"
                                alt="Customer Support"
                                class="img-fluid illustration-img"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $messageCategoryTotal = DB::table('message_categories')->count();
            $messageCategoryApproved = DB::table('message_categories')->where('status',1)->count();
            $mcProgressWidth = round(($messageCategoryTotal!=0?$messageCategoryApproved/$messageCategoryTotal:0)*100);

            $messageTemplateTotal = DB::table('message_templates')->count();
            $messageTemplateApproved = DB::table('message_templates')->where('content_ok',1)->where('grammar_ok',1)->where('spelling_ok',1)->count();
            $mtProgressWidth = round(($messageTemplateTotal!=0?$messageTemplateApproved/$messageTemplateTotal:0)*100);

            $responseTemplateTotal = DB::table('response_templates')->count();
            $responseTemplateApproved = DB::table('response_templates')->where('content_ok',1)->where('grammar_ok',1)->where('spelling_ok',1)->count();
            $rtProgressWidth = round(($responseTemplateTotal!=0?$responseTemplateApproved/$responseTemplateTotal:0)*100);

            $eventCategoryTotal = DB::table('event_categories')->count();
            $eventCategoryApproved = DB::table('event_categories')->where('status',1)->count();
            $ecProgressWidth = round(($eventCategoryTotal!=0?$eventCategoryApproved/$eventCategoryTotal:0)*100);

            
            
        @endphp

        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="card-actions float-end">
                    </div>
                    <h5 class="card-title mb-0">Content Approval</h5>
                </div>
                <table class="table table-striped my-0">
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th class="text-end">#Total</th>
                            <th class="d-none d-xl-table-cell w-75">% Completion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style='width:40%'>Message Category</td>
                            <td class="text-end">{{$messageCategoryTotal}}</td>
                            <td class="d-none d-xl-table-cell">
                                <div class="progress">
                                    @if ($mcProgressWidth>=75)
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$mcProgressWidth}}%;" aria-valuenow="{{$mcProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$mcProgressWidth}}%</div>                                        
                                    @elseif ($mcProgressWidth>=50)
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$mcProgressWidth}}%;" aria-valuenow="{{$mcProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$mcProgressWidth}}%</div>                                        
                                    @else
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$mcProgressWidth}}%;" aria-valuenow="{{$mcProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$mcProgressWidth}}%</div>                                        
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style='width:40%'>Message Template</td>
                            <td class="text-end">{{$messageTemplateTotal}}</td>
                            <td class="d-none d-xl-table-cell">
                                <div class="progress">
                                    @if ($mtProgressWidth>=75)
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$mtProgressWidth}}%;" aria-valuenow="{{$mtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$mtProgressWidth}}%</div>                                        
                                    @elseif ($mtProgressWidth>=50)
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$mtProgressWidth}}%;" aria-valuenow="{{$mtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$mtProgressWidth}}%</div>                                        
                                    @else
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$mtProgressWidth}}%;" aria-valuenow="{{$mtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$mtProgressWidth}}%</div>                                        
                                    @endif
                                </div>
                            </td>
                        </tr>
                        

                        <tr>
                            <td style='width:40%'>Response Template</td>
                            <td class="text-end">{{$responseTemplateTotal}}</td>
                            <td class="d-none d-xl-table-cell">
                                <div class="progress">
                                    @if ($rtProgressWidth>=75)
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$rtProgressWidth}}%;" aria-valuenow="{{$rtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$rtProgressWidth}}%</div>                                        
                                    @elseif ($rtProgressWidth>=50)
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$rtProgressWidth}}%;" aria-valuenow="{{$rtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$rtProgressWidth}}%</div>                                        
                                    @else
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$rtProgressWidth}}%;" aria-valuenow="{{$rtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$rtProgressWidth}}%</div>                                        
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style='width:40%'>Event Category</td>
                            <td class="text-end">{{$eventCategoryTotal}}</td>
                            <td class="d-none d-xl-table-cell">
                                <div class="progress">
                                    @if ($ecProgressWidth>=75)
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$ecProgressWidth}}%;" aria-valuenow="{{$rtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$ecProgressWidth}}%</div>                                        
                                    @elseif ($ecProgressWidth>=50)
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$ecProgressWidth}}%;" aria-valuenow="{{$rtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$ecProgressWidth}}%</div>                                        
                                    @else
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$ecProgressWidth}}%;" aria-valuenow="{{$rtProgressWidth}}" aria-valuemin="0" aria-valuemax="100">{{$ecProgressWidth}}%</div>                                        
                                    @endif
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="col-12 col-sm-3 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{$messageCategoryTotal}}</h3>
                            <p class="mb-2">Message Category</p>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-info" data-lucide="message-square-more"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{$messageTemplateTotal}}</h3>
                            <p class="mb-2">Message Templates</p>
                            {{-- <div class="mb-0">
                                <span class="badge badge-subtle-success me-2">
                                    {{$mtProgressWidth}}%
                                </span>
                                <span class="text-muted">Approved</span>
                            </div> --}}
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-success" data-lucide="message-square-more"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-3 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{$responseTemplateTotal}}</h3>
                            <p class="mb-2">Response Template</p>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-info" data-lucide="vote"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{$eventCategoryTotal}}</h3>
                            <p class="mb-2">Event Catgeory</p>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat">
                                <i class="align-middle text-info" data-lucide="vote"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
