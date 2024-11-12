@include('admin.layout.head')
@include('admin.layout.navbar')
<link rel="stylesheet" href="/static/admin/css/bootstrap-table.min.css" media="all">
<link rel="stylesheet" href="/static/admin/css/dev.css" media="all">
<div class="sqlBox">
    <form name="sqlForm" method="post">
        <div class="input-group col-xs-12 clearfix">
            <span class="input-group-addon">SQL</span>
            <textarea class="form-control" name="sql"></textarea>
        </div>
        <div class="input-group col-xs-12 clearfix">
            {{csrf_field()}}
            <input type="button" class="btn-primary btn-sm sqlButton" data-type="raw" value="Execute"/>
            <input type="button" class="btn-default btn-sm sqlButton" data-type="excel" value="ExportExcel"/>
            <input type="button" class="btn-info btn-sm sqlButton" data-type="json" value="ExportJson"/>
        </div>
    </form>
    <div class="tableBox" id="tableBox">
        <table data-toggle="table" id="sqlTable" data-height="auto" data-pagination="true"></table>
    </div>
</div>
<script src="/static/admin/js/bootstrap-table.min.js" charset="utf-8"></script>
<script>
    function renderTable() {
        $("#tableBox").hide();
        let loadingIndex = common.loading('loading');
        $("#sqlTable").bootstrapTable('destroy').bootstrapTable({
            url: "{{url('admin/dev/index')}}",
            method: "post",
            dataType: "json",
            striped: true,
            silent: true,
            undefinedText: "Empty result",
            pagination: true,
            pageNumber: 1,
            pageSize: 5,
            smartDisplay: false,
            pageList: "[5, 10, 20, 30]",
            paginationPreText: '<',
            paginationNextText: '>',
            sidePagination: 'server',
            queryParams: function (params) {
                return {
                    offset: params.offset,
                    page_size: params.limit,
                    sql: $("textarea[name='sql']").val(),
                    _token: $("input[name='_token']").val(),
                    data_type: 'raw'
                };
            },
            onLoadSuccess: function (res) {
                console.log(res);
            },
            /*            columns: [{"field": "id", "title": "id"}, {"field": "migration", "title": "migration"}, {
                            "field": "batch",
                            "title": "batch"
                        }],*/
            responseHandler: function (res) {
                common.close(loadingIndex);

                if (res.token !== undefined) {
                    $("input[name='_token']").val(res.token);
                }

                if (parseInt(res.code) === 0) {
                    $("#tableBox").show();
                } else {
                    $("#tableBox").hide();
                    common.error(res.msg === undefined ? 'System Error' : res.msg);
                    return [];
                }

                if (res.cols !== undefined) columnArr = res.cols;

                if (is_init === 0 && columnArr.length > 0) {
                    $("#sqlTable").bootstrapTable('refreshOptions', {
                        'columns': res.cols
                    });
                    is_init = 1;
                }

                return {"total": res.total, "rows": res.data};
            },
            onLoadError: function (res) {
                common.close(loadingIndex);

                if (res.token !== undefined) {
                    $("input[name='_token']").val(res.token);
                }

                $("#tableBox").hide();
                common.error('init table failed, please try again!')
            }
        });
    }

    function validateSql() {
        const regex = /^\s*SELECT\s+.*$/i;
        if (!regex.test($("textarea[name='sql']").val())) {
            common.error('Please input Select type sql statement');
            return false;
        } else {
            return true;
        }
    }

    let is_init = 0;
    let columnArr = [];
    $(function () {
        $(".sqlButton").on('click', function () {
            let dataType = $(this).attr('data-type');

            if (validateSql()) {
                if (dataType === 'json' || dataType === 'excel') {

                } else {
                    is_init = 0;
                    renderTable();
                }
            }
        })
    })
</script>
