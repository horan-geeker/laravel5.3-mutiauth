<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <!-- BEGIN PAGE HEADER -->
        <div class="clearfix">
            <h3 class="page-title pull-left">
                <a class="a-unstyled" href="{{ $indexUrl }}">
                    <i class="fa fa-chevron-circle-left"></i>
                </a>新增{{ $pageTitle }}</h3>
        </div>
        <hr>
        <!-- END PAGE HEADER -->
    </div>
    <div class="col-xs-12 col-md-10 col-lg-8">
        <form novalidate action="{{ $postUrl }}" method="post" enctype="multipart/form-data">
            @if($errors->has('general'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ $errors->first('general') }}
                </div>
            @endif
            {{ csrf_field() }}
            @foreach($formItems as $formItem)
                @if(isset($formItem['type']) && $formItem['type'] == 'select')
                    <div class="form-group">
                        <label for="{{ $formItem['name'] }}">{{ $formItem['text'] }}</label>
                        <select name="{{ $formItem['name'] }}" id="{{ $formItem['name'] }}" class="form-control">
                            @foreach($formItem['options'] as $option)
                                <option value="{{ $option['value'] }}">{{ $option['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="form-group {{ $errors->has($formItem['name'])?'has-error':'' }}">

                        <label for="name">{{ $formItem['text'] }}</label>
                        <input type="text" id="{{ $formItem['name'] }}" name="{{ $formItem['name'] }}"
                               class="form-control"
                               @if(isset($formItem['require']))
                               required
                               @foreach($formItem['require'] as $role)
                               {{ $role['role_type']."=".$role['role_value'] }}
                               @endforeach
                               @endif
                               value="{{ old($formItem['name']) }}">

                        @if ($errors->has($formItem['name']))
                            <span class="help-block">
                                <strong>{{ $errors->first($formItem['name']) }}</strong>
                            </span>
                        @endif
                    </div>
                @endif
            @endforeach
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-submit">提交</button>
            </div>
        </form>
    </div>
</div>