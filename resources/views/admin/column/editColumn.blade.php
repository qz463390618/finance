@extends('layouts.admin')
@section('title', '编辑栏目')
@section('my-css')
@endsection
@section('content')
    <div id="content-header">
        <h1>首页</h1>
        <div class="btn-group">
            <a class="btn btn-large tip-bottom" title="Manage Files"><i class="icon-file"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Users"><i class="icon-user"></i></a>
            <a class="btn btn-large tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a>
            <a class="btn btn-large tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a>
        </div>
    </div>
    <div id="breadcrumb">
        <a href="#" title="返回后台首页" class="tip-bottom"><i class="icon-home"></i> 后台</a>
        <a href="{{url('/admin/column')}}" class="tip-bottom">栏目管理</a>
        <a href="#" class="current">编辑栏目</a>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
								<span class="icon">
									<i class="icon-align-justify"></i>
								</span>
                        <h5>编辑栏目</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="{{url('/admin/column/doEdit')}}" method="post" class="form-horizontal" >
                            {{csrf_field()}}
                            <input type="hidden" name="column_id" value="{{$columnInfo->column_id}}">
                            <div class="control-group">
                                <label class="control-label">栏目名</label>
                                <div class="controls">
                                    <input type="text" name="column_name" placeholder="请输入栏目名" value="{{old('column_name') ? old('column_name'): $columnInfo -> column_name }}"/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('column_name')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">上级栏目</label>
                                <div class="controls">

                                    <fieldset disabled>
                                        <div class="form-group">
                                            <select id="disabledSelect" class="form-control" readonly>
                                                <option>{{getParetColumn($columnInfo ->column_pid)}}</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label">文件名</label>
                                <div class="controls">
                                    <input type="text" name="column_filename" placeholder="请输入文件名" value="{{old('column_filename') ? old('column_filename'):$columnInfo -> column_filename }}" readonly/>
                                    @if(count($errors)>0)
                                        <span class="help-block">{{$errors -> first('column_filename')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">控制显隐</label>
                                <div class="controls">
                                    <label><input type="radio" name="display" value="1" style="margin-right: 10px;"  <?= $columnInfo-> column_display == 1 ? 'checked':'' ?> >显示</label>
                                    <label><input type="radio" name="display" value="2" style="margin-right: 10px;"  <?= $columnInfo-> column_display == 2 ? 'checked':'' ?>>隐藏</label>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">编辑</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
@endsection