<h3 class="page-title">
    {{ $pageTitle }}
    <small>{{ $smallTitle }}</small>
    <a href="{{ $createUrl }}" class="btn btn-primary pull-right">{{ $linkCreateCaption }}</a>
</h3>

<!-- END PAGE HEADER-->
@if(isset($search))
    <!-- BEGIN PAGE CONTENT-->
    <div class="search-form-containe">
        <form class="form search-form" action="{{ $indexUrl }}" method="get">
            <div class="form-group">
                <input type="text" name="q" placeholder="按名称搜索" class="form-control"
                       value="{{ request('q')  }}"
                >
            </div>
        </form>
    </div>
@endif

<table class="table table-striped table-hover table-bordered has-show-view">
    <thead>
    <tr>
        <th style="width:45px;">#</th>
        <th style="width:45px">语言</th>
        @foreach($tableHeaders as $tableHeader)
            <th>{{ $tableHeader }}</th>
        @endforeach
        <th class="text-center" style="width: 105px">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $item)
        @if($item->translate('zh'))
            <tr
                    data-target="_blank"
                    data-url="{{ $redirectTo.$item->id }}?locale=zh"
            >
                <td class="text-center" rowspan="2">{{ $loop->iteration }}</td>
                <td>中文</td>
                @foreach($listItems as $key=>$value)
                    @if($value == 'isImage')
                        <td><img src="{{ $item->translate('zh')->$key }}" alt="缩略图" style="width:200px;"></td>
                    @else
                        <td>{{ $item->translate('zh')->$key }}</td>
                    @endif
                @endforeach
                {{--                    <td>{{ $item->translate('zh')->less_intro }}</td>--}}
                <td class="text-center">
                    <a href="{{ $indexUrl.$item->translate('zh')->id }}/edit"
                       class="btn btn-primary btn-xs btn-edit">编辑</a>
                    <button class="btn btn-danger btn-xs btn-delete"
                            data-url="{{ $indexUrl.$item->translate('zh')->id }}">删除
                    </button>
                </td>
            </tr>
        @else
            <tr>
                <td rowspan="2">{{ $loop->iteration }}</td>
                <td>中文</td>
                <td colspan="4">
                    <a href="{{ $createUrl }}?id={{ $item->id }}&locale=zh"
                       class="btn btn-primary btn-sm">增加中文</a>
                </td>
            </tr>
        @endif


        @if($item->translate('en'))
            <tr
                    data-url="{{ $redirectTo.$item->id }}?locale=en"
                    data-target="_blank"
            >
                <td>英文</td>
                @foreach($listItems as $key=>$value)
                    @if($value == 'isImage')
                        <td><img src="{{ $item->translate('en')->$key }}" alt="缩略图" style="width:200px;"></td>
                    @else
                        <td>{{ $item->translate('en')->$key }}</td>
                    @endif
                @endforeach
                {{--                    <td>{{ $item->translate('en')->less_intro }}</td>--}}
                <td class="text-center">
                    <a href="{{ $indexUrl.$item->translate('en')->id }}/edit"
                       class="btn btn-primary btn-xs btn-edit">编辑</a>
                    <button class="btn btn-danger btn-xs btn-delete"
                            data-url="{{ $indexUrl.$item->translate('en')->id }}">删除
                    </button>
                </td>
        @else
            <tr>
                <td>英文</td>
                <td colspan="4">
                    <a href="{{ $createUrl }}?id={{ $item->id }}&locale=en"
                       class="btn btn-primary btn-sm">增加英文</a>
                </td>
                @endif
            </tr>
            @endforeach
    </tbody>
</table>
<div class="pagination-container">
    {{ $list->links() }}
</div>