<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <!-- BEGIN PAGE HEADER -->
        <div class="clearfix">
            <h3 class="page-title pull-left">
                <a class="a-unstyled" href="{{ $indexUrl }}">
                    <i class="fa fa-chevron-circle-left"></i>
                </a>{{ $pageTitle }}</h3>
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
                            @foreach($formItem['options']['lists'] as $option)
                                <option value="{{ $formItem['options']['value'] }}"
                                @if($option[$formItem['options']['value']] == $obj['tag_id'])
                                    selected
                                @endif
                                >{{ $option[$formItem['options']['description']] }}</option>
                            @endforeach
                        </select>
                    </div>
                @elseif(isset($formItem['type']) && $formItem['type'] == 'checkbox')
                    <div class="form-group">
                        <label for="{{ $formItem['name'] }}">{{ $formItem['text'] }}</label>
                        <div class="row">
                            @foreach($formItem['checkbox']['lists'] as $checkbox)
                                <div class="col-md-4">
                                <input type="checkbox" name="{{ $formItem['name'] }}" value="{{ $checkbox[$formItem['checkbox']['value']] }}"
                                   @if(in_array($checkbox[$formItem['checkbox']['value']],$obj->$formItem['obj_check_name']))
                                       checked
                                   @endif
                                >{{ $checkbox[$formItem['checkbox']['description']] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(isset($formItem['type']) && $formItem['type'] == 'textarea')
                        <div class="form-group">
                        <label for="{{ $formItem['name'] }}">{{ $formItem['text'] }}</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="20">{{ $obj->$formItem['name'] }}</textarea>
                                </div>
                            </div>
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
                               value="{{ old($formItem['name'],isset($obj)?$obj->$formItem['name']:null) }}">

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