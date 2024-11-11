@include('admin.layout.head')
@include('admin.layout.navbar')
<link rel="stylesheet" href="/static/admin/css/bootstrap-table.min.css" media="all">
<link rel="stylesheet" href="/static/admin/css/dev.css" media="all">
<div class="sqlBox">
    <div class="input-group col-xs-12 clearfix">
        <span class="input-group-addon">SQL</span>
        <textarea class="form-control" name="sql"></textarea>
    </div>
    <div class="input-group col-xs-12 clearfix">
        <input type="button" class="btn-primary btn-sm" value="Execute"/>
        <input type="button" class="btn-default btn-sm" value="ExportExcel"/>
        <input type="button" class="btn-info btn-sm" value="ExportJson"/>
    </div>
</div>
