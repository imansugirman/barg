@extends('user::layouts.master')

@section('title', 'User Manager')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header bg-transparent">
            <h5 class="mb-0 text-center">User List</h5>
          </div>
          <div class="card-body">
            <table class="table table-striped table-sm data-table">
              <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Level</th>
                <th>Created</th>
                <th class="hidden-sm hidden-xs hidden-md">{!! trans('laravelusers::laravelusers.users-table.created') !!}</th>
                <th class="hidden-sm hidden-xs hidden-md">{!! trans('laravelusers::laravelusers.users-table.updated') !!}</th>
                <th class="no-search no-sort">{!! trans('laravelusers::laravelusers.users-table.actions') !!}</th>

              </thead>
              <tbody>
                @if(config('laravelusers.enableSearchUsers'))
                    @include('laravelusers::partials.search-users-form')
                @endif
                @foreach ($user as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @if(config('laravelusers.rolesEnabled'))
                            <td class="hidden-sm hidden-xs">
                                @foreach ($user->roles as $user_role)
                                    @if ($user_role->name == 'User')
                                        @php $badgeClass = 'primary' @endphp
                                    @elseif ($user_role->name == 'Admin')
                                        @php $badgeClass = 'warning' @endphp
                                    @elseif ($user_role->name == 'Unverified')
                                        @php $badgeClass = 'danger' @endphp
                                    @else
                                        @php $badgeClass = 'dark' @endphp
                                    @endif
                                    <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>
                                @endforeach
                            </td>
                        @endif

                        @if(config('laravelusers.rolesEnabled'))
                            <td class="hidden-sm hidden-xs">
                                @foreach ($user->roles as $user_role)
                                    @if ($user_role->level == '5')
                                        @php $badgeClass = 'primary' @endphp
                                    @elseif ($user_role->level == '1')
                                        @php $badgeClass = 'warning' @endphp
                                    @elseif ($user_role->level == '0')
                                        @php $badgeClass = 'danger' @endphp
                                    @else
                                        @php $badgeClass = 'dark' @endphp
                                    @endif
                                    <span class="badge badge-{{$badgeClass}}">{{ $user_role->level }}</span>
                                @endforeach
                            </td>
                        @endif
                        <td>{{ $user->created_at }}</td>
                        <td>
                            {!! Form::open(array('url' => 'user/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => trans('laravelusers::laravelusers.tooltips.delete'))) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                {!! Form::button(trans('laravelusers::laravelusers.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('laravelusers::modals.delete_user_title'), 'data-message' => trans('laravelusers::modals.delete_user_message', ['user' => $user->name]))) !!}
                            {!! Form::close() !!}
                        </td>
                        <td>
                            <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('users/' . $user->id) }}" data-toggle="tooltip" title="{!! trans('laravelusers::laravelusers.tooltips.show') !!}">
                                {!! trans('laravelusers::laravelusers.buttons.show') !!}
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('users/' . $user->id . '/edit') }}" data-toggle="tooltip" title="{!! trans('laravelusers::laravelusers.tooltips.edit') !!}">
                                {!! trans('laravelusers::laravelusers.buttons.edit') !!}
                            </a>
                        </td>
                        {{-- <td>{{ $user->roles->name }}</td> --}}
                    </tr>
                @endforeach
              </tbody>
              @if(config('laravelusers.enableSearchUsers'))
                    <tbody id="search_results"></tbody>
              @endif
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('template_scripts')
@if ((count($users) > config('laravelusers.datatablesJsStartCount')) && config('laravelusers.enabledDatatablesJs'))
        @include('laravelusers::scripts.datatables')
    @endif
    @include('laravelusers::scripts.delete-modal-script')
    @include('laravelusers::scripts.save-modal-script')
    @if(config('laravelusers.tooltipsEnabled'))
        @include('laravelusers::scripts.tooltips')
    @endif
@if(config('laravelusers.enableSearchUsers'))
        @include('laravelusers::scripts.search-users')
    @endif
@endsection
