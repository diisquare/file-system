@extends('modules.header')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/fileManager/fileList.css')}}">
@endsection

<script>
    $('.media-reload').click(function () {
        $.pjax.reload('#pjax-container');
    });
</script>


@section('content')
    <div class="container bg">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div class="mailbox-controls with-border">
                            <div class="btn-group">
                                <a href="" type="button" class="btn btn-default btn media-reload" title="Refresh">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                {{--                            <a type="button" class="btn btn-default btn file-delete-multiple" title="Delete">--}}
                                {{--                                <i class="fa fa-trash-o"></i>--}}
                                {{--                            </a>--}}
                            </div>

                            {{--                        <label class="btn btn-default btn"--}}{{-- data-toggle="modal" data-target="#uploadModal"--}}{{-->--}}
                            {{--                            <i class="fa fa-upload"></i>&nbsp;&nbsp;{{ trans('admin.upload') }}--}}
                            {{--                            <form action="{{ $url['upload'] }}" method="post" class="file-upload-form" enctype="multipart/form-data" pjax-container>--}}
                            {{--                                <input type="file" name="files[]" class="hidden file-upload" multiple>--}}
                            {{--                                <input type="hidden" name="dir" value="{{ $url['path'] }}" />--}}
                            {{--                                {{ csrf_field() }}--}}
                            {{--                            </form>--}}
                            {{--                        </label>--}}
                            {{--list_or_table--}}
                            {{--                        <div class="btn-group">--}}
                            {{--                            <a href="{{ route('file-manager-index', ['path' => $url['path'], 'view' => 'table']) }}" class="btn btn-default {{ request('view') == 'table' ? 'active' : '' }}"><i class="fa fa-list"></i></a>--}}
                            {{--                            <a href="{{ route('file-manager-index', ['path' => $url['path'], 'view' => 'list']) }}" class="btn btn-default {{ request('view') == 'list' ? 'active' : '' }}"><i class="fa fa-th"></i></a>--}}
                            {{--                        </div>--}}
                            {{--search-box--}}
                            {{--                        <div class="input-group input-group-sm pull-right goto-url" style="width: 250px;">--}}
                            {{--                            <input type="text" name="path" class="form-control pull-right" value="{{ '/'.trim($url['path'], '/') }}">--}}

                            {{--                            <div class="input-group-btn">--}}
                            {{--                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-right"></i></button>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}
                        </div>
                    </div>

                    {{--                box_body--}}
                    <div class="box-footer">
                        <ol class="breadcrumb" style="margin-bottom: 10px;">

                            <li><a href="{{ route('post') }}"><i class="fa fa-th-large"></i> </a></li>
                                <li style="width: 15px">  </li>

                            @foreach($nav as $item)
                                <li><a href="{{ $item['url'] }}"> {{ $item['name'] }}</a></li>
                                <li> / </li>
                            @endforeach
                        </ol>
                        <ul class="files clearfix">

                            @if (empty($list))
                                <li style="height: 200px;border: none;"></li>
                            @else
                                @foreach($list as $item)
                                    <li>
                            <span class="file-select">
                                <input type="checkbox" value="{{ $item['name'] }}"/>
                            </span>

                                        {!! $item['preview'] !!}

                                        <div class="file-info">
                                            <a @if(!$item['isDir'])target="_blank"@endif href="{{ $item['link'] }}" class="file-name" title="{{ $item['name'] }}">
                                                {{ $item['icon'] }} {{ basename($item['name']) }}
                                            </a>
                                            <span class="file-size">
                              {{ $item['size'] }}&nbsp;

                                <div class="btn-group btn-group-xs pull-right">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="file-rename" data-toggle="modal" data-target="#moveModal" data-name="{{ $item['name'] }}">Rename & Move</a></li>
                                        <li><a href="#" class="file-delete" data-path="{{ $item['name'] }}">Delete</a></li>
                                        @unless($item['isDir'])
                                            <li><a target="_blank" href="{{ $item['download'] }}">Download</a></li>
                                        @endunless
                                        <li class="divider"></li>
                                        <li><a href="#" data-toggle="modal" data-target="#urlModal" data-url="{{ $item['url'] }}">Url</a></li>
                                    </ul>
                                </div>
                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
