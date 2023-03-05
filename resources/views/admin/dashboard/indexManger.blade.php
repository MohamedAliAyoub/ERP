@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.employees.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.details')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <style>
        .counter{
            font-size: large;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <!-- .row -->
    <div class="row">
        <div class="col-md-5 col-xs-12">
            <div class="white-box">
                <div class="user-bg">
                    <img src="{{$employee->image_url}}" alt="user" width="100%">
                    <div class="overlay-box">
                        <div class="user-content"> <a href="javascript:void(0)">
                                <img src="{{$employee->image_url}}" alt="user" class="thumb-lg img-circle">
                            </a>
                            <h4 class="text-white">{{ ucwords($employee->name) }}</h4>
                            <h5 class="text-white">{{ $employee->email }}</h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-7">
            <div class="user-btm-box">
                <div class="row row-in">
                    <div class="col-md-6 row-in-br">
                        <div class="col-in row">
                            <h3 class="box-title">@lang('modules.employees.tasksDone')</h3>
                            <div class="col-xs-4"><i class="ti-check-box text-success"></i></div>
                            <div class="col-xs-8 text-right counter">{{ $taskCompleted }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 row-in-br  b-r-none">
                        <div class="col-in row">
                            <h3 class="box-title">@lang('modules.employees.hoursLogged')</h3>
                            <div class="col-xs-2"><i class="icon-clock text-info"></i></div>
                            <div class="col-xs-10 text-right counter" style="font-size: 13px">{{ $hoursLogged }}</div>
                        </div>
                    </div>
                </div>
                <div class="row row-in">
                    <div class="col-md-6 row-in-br b-t">
                        <div class="col-in row">
                            <h3 class="box-title">@lang('modules.leaves.leavesTaken')</h3>
                            <div class="col-xs-4"><i class="icon-logout text-warning"></i></div>
                            <div class="col-xs-8 text-right counter">{{ $leavesCount }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 row-in-br  b-r-none b-t">
                        <div class="col-in row">
                            <h3 class="box-title">@lang('modules.leaves.remainingLeaves')</h3>
                            <div class="col-xs-4"><i class="icon-logout text-danger"></i></div>
                            <div class="col-xs-8 text-right counter">{{ ($allowedLeaves-count($leaves)) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="white-box">
                <ul class="nav nav-tabs tabs customtab">
                    <li class="active tab"><a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">@lang('modules.employees.profile')</span> </a> </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                        <div class="row">
                            <div class="col-xs-6 col-md-4  b-r"> <strong>@lang('modules.employees.employeeId')</strong> <br>
                                <p class="text-muted">{{ ucwords($employee->employeeDetail->employee_id) }}</p>
                            </div>
                            <div class="col-xs-6 col-md-4 b-r"> <strong>@lang('modules.employees.fullName')</strong> <br>
                                <p class="text-muted">{{ ucwords($employee->name) }}</p>
                            </div>
                            <div class="col-xs-6 col-md-4"> <strong>@lang('app.mobile')</strong> <br>
                                <p class="text-muted">{{ $employee->mobile ?? '-'}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 b-r"> <strong>@lang('app.email')</strong> <br>
                                <p class="text-muted">{{ $employee->email }}</p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>@lang('app.address')</strong> <br>
                                <p class="text-muted">{{ (!is_null($employee->employeeDetail)) ? $employee->employeeDetail->address : '-'}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 b-r"> <strong>@lang('app.designation')</strong> <br>
                                <p class="text-muted">{{ (!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation)) ? ucwords($employee->employeeDetail->designation->name) : '-' }}</p>
                            </div>
                            <div class="col-md-6 col-xs-6"> <strong>@lang('app.department')</strong> <br>
                                <p class="text-muted">{{ (!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->department)) ? ucwords($employee->employeeDetail->department->team_name) : '-' }}</p>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 b-r"> <strong>@lang('modules.employees.slackUsername')</strong> <br>
                                <p class="text-muted">{{ (!is_null($employee->employeeDetail)) ? '@'.$employee->employeeDetail->slack_username : '-' }}</p>
                            </div>
                            <div class="col-md-6 col-xs-6"> <strong>@lang('modules.employees.joiningDate')</strong> <br>
                                <p class="text-muted">{{ (!is_null($employee->employeeDetail)) ? $employee->employeeDetail->joining_date->format($global->date_format) : '-' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-xs-6 b-r"> <strong>@lang('modules.employees.gender')</strong> <br>
                                <p class="text-muted">{{ $employee->gender }}</p>
                            </div>
                            <div class="col-md-6 col-xs-6"> <strong>@lang('app.skills')</strong> <br>
                                {{implode(', ', $employee->skills()) }}

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-xs-6"> <strong>@lang('modules.employees.hourlyRate')</strong> <br>
                                <p class="text-muted">{{ (count($employee->employee) > 0) ? $employee->employee[0]->hourly_rate : '-' }}</p>
                            </div>
                        </div>
                        {{--Custom fields data--}}
                        @if(isset($fields))
                            <div class="row">
                                <hr>
                                @foreach($fields as $field)
                                    <div class="col-md-6">
                                        <strong>{{ ucfirst($field->label) }}</strong> <br>
                                        <p class="text-muted">
                                        @if( $field->type == 'text')
                                            {{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}
                                        @elseif($field->type == 'password')
                                            {{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}
                                        @elseif($field->type == 'number')
                                            {{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}

                                        @elseif($field->type == 'textarea')
                                            {{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}

                                        @elseif($field->type == 'radio')
                                            {{ !is_null($employeeDetail->custom_fields_data['field_'.$field->id]) ? $employeeDetail->custom_fields_data['field_'.$field->id] : '-' }}
                                        @elseif($field->type == 'select')
                                            {{ (!is_null($employeeDetail->custom_fields_data['field_'.$field->id]) && $employeeDetail->custom_fields_data['field_'.$field->id] != '') ? $field->values[$employeeDetail->custom_fields_data['field_'.$field->id]] : '-' }}
                                        @elseif($field->type == 'checkbox')
                                            <ul>
                                                @foreach($field->values as $key => $value)
                                                    @if($employeeDetail->custom_fields_data['field_'.$field->id] != '' && in_array($value ,explode(', ', $employeeDetail->custom_fields_data['field_'.$field->id]))) <li>{{$value}}</li> @endif
                                                @endforeach
                                            </ul>
                                            @elseif($field->type == 'date')
                                                {{ isset($employeeDetail->custom_fields_data['field_'.$field->id])? Carbon\Carbon::parse($employeeDetail->custom_fields_data['field_'.$field->id])->format($global->date_format): ''}}
                                            @endif
                                            </p>

                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{--custom fields data end--}}

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="edit-column-form" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script>
        // Show Create employeeDocs Modal
        function showAdd() {
            var url = "{{ route('admin.employees.docs-create', [$employee->id]) }}";
            $.ajaxModal('#edit-column-form', url);
        }

        $('#edit-leave-type').click(function () {
            var url = "{{ route('admin.employees.leaveTypeEdit', [$employee->id]) }}";
            $.ajaxModal('#edit-column-form', url);
        })

        $('body').on('click', '.sa-params', function () {
            var id = $(this).data('file-id');
            var deleteView = $(this).data('pk');
            swal({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.confirmation.deleteFile')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('messages.deleteConfirmation')",
                cancelButtonText: "@lang('messages.confirmNoArchive')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {

                    var url = "{{ route('admin.employee-docs.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE', 'view': deleteView},
                        success: function (response) {
                            console.log(response);
                            if (response.status == "success") {
                                $.unblockUI();
                                $('#employeeDocsList').html(response.html);
                            }
                        }
                    });
                }
            });
        });

        $('#leave-table').dataTable({
            responsive: true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0, 'width': '20%' },
                { responsivePriority: 2, targets: 1, 'width': '20%' }
            ],
            "autoWidth" : false,
            searching: false,
            paging: false,
            info: false
        });

        var table;

        function showTable() {

            if ($('#hide-completed-tasks').is(':checked')) {
                var hideCompleted = '1';
            } else {
                var hideCompleted = '0';
            }

            var url = '{{ route('admin.employees.tasks', [$employee->id, ':hideCompleted']) }}';
            url = url.replace(':hideCompleted', hideCompleted);

            table = $('#tasks-table').dataTable({
                destroy: true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: url,
                deferRender: true,
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function (oSettings) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                "order": [[0, "desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'project_name', name: 'projects.project_name', width: '20%'},
                    {data: 'heading', name: 'heading', width: '20%'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'column_name', name: 'taskboard_columns.column_name'},
                ]
            });
        }

        $('#hide-completed-tasks').click(function () {
            showTable();
        });

        $('#tasks-table').on('click', '.show-task-detail', function () {
            $(".right-sidebar").slideDown(50).addClass("shw-rside");

            var id = $(this).data('task-id');
            var url = "{{ route('admin.all-tasks.show',':id') }}";
            url = url.replace(':id', id);

            $.easyAjax({
                type: 'GET',
                url: url,
                success: function (response) {
                    if (response.status == "success") {
                        $('#right-sidebar-content').html(response.view);
                    }
                }
            });
        })

        showTable();

    </script>

    <script>
        var table2;

        function showTable2(){

            var url = '{{ route('admin.employees.time-logs', [$employee->id]) }}';

            table2 = $('#timelog-table').dataTable({
                destroy: true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: url,
                deferRender: true,
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                "order": [[ 0, "desc" ]],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'project_name', name: 'projects.project_name' },
                    { data: 'start_time', name: 'start_time' },
                    { data: 'end_time', name: 'end_time' },
                    { data: 'total_hours', name: 'total_hours' },
                    { data: 'memo', name: 'memo' }
                ]
            });
        }

        showTable2();
    </script>
@endpush

