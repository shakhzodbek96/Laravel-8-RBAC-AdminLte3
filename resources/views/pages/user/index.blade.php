@extends('layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('cruds.user.title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                            <li class="breadcrumb-item active">@lang('cruds.user.title')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('cruds.user.title_singular')</h3>
                            @can('user.add')
                            <a href="{{ route('userAdd') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                @lang('global.add')
                            </a>
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Data table -->
                            <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>@lang('cruds.user.fields.id')</th>
                                    <th>@lang('cruds.user.fields.name')</th>
                                    <th>@lang('cruds.user.fields.email')</th>
                                    <th>@lang('cruds.user.fields.roles')</th>
                                    <th>@lang('cruds.permission.fields.permissions')</th>
                                    <th class="w-25">@lang('global.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles()->pluck('name') as $role)
                                                <span class="badge badge-primary">{{ $role }} </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($user->getAllPermissions()->pluck('name') as $permission)
                                                <span class="badge badge-secondary">{{ $permission }} </span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @can('user.delete')
                                            <form action="{{ route('userDestroy',$user->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    @can('user.edit')
                                                    <a href="{{ route('userEdit',$user->id) }}" type="button" class="btn btn-info btn-sm"> @lang('global.edit')</a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "> @lang('global.delete')</button>
                                                </div>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
@endsection
