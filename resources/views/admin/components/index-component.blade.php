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
        @foreach($tableHeaders as $tableHeader)
            <th>{{ $tableHeader }}</th>
        @endforeach
        <th class="text-center" style="width: 105px">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $item)
        <tr
                data-target="_blank"
                data-url="{{ $redirectTo.$item->id }}?locale=zh"
        >
            <td class="text-center">{{ $loop->iteration }}</td>
            @foreach($listItems as $key=>$value)
                <td class="text-center">
                    @if($value == 'isImage')
                        <img src="{{ $item->$key }}" alt="缩略图" style="width:200px;">
                    @else
                        {{ $item->$value }}
                    @endif
                </td>
            @endforeach
            <td class="text-center">
                <a href="{{ $indexUrl.$item->id }}/edit"
                   data-pjax
                   data-container="#page_content_container"
                   class="btn btn-primary btn-xs btn-edit">编辑</a>
                <button class="btn btn-danger btn-xs btn-delete"
                        data-url="{{ $indexUrl.$item->id }}">删除
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pagination-container">
    {{ $list->links() }}
</div>