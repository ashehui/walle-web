<?php
/**
 * @var yii\web\View $this
 */
$this->title = yii::t('task', 'submit task title');
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\Task;
?>
<div class="box">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
      <div class="box-body">
        <?= $form->field($task, 'title')->label(yii::t('task', 'submit title'), ['class' => 'control-label bolder blue']) ?>

        <!-- 分支选取 -->
        <?php if ($conf->repo_mode == Project::REPO_MODE_BRANCH) { ?>
          <div class="form-group">
              <label><?= yii::t('task', 'select branches') ?>
                  <a class="show-tip icon-refresh green" href="javascript:;">刷新分支</a>
                  <span class="tip"><?= yii::t('task', 'all branches') ?></span>
                  <i class="get-branch icon-spinner icon-spin orange bigger-125" style="display: none"></i>
              </label>
              <select name="Task[branch]" aria-hidden="true" tabindex="-1" id="branch" class="form-control select2 select2-hidden-accessible">
                  <option value="master">master</option>
              </select>
          </div>
        <?php } ?>
        <!-- 分支选取 end -->

        <?= $form->field($task, 'commit_id')->dropDownList([])
          ->label(yii::t('task', 'select branch').'<i class="get-history icon-spinner icon-spin orange bigger-125"></i>', ['class' => 'control-label bolder blue']) ?>

          <!-- 全量/增量 -->
          <div class="form-group">
              <label class="text-right bolder blue">
                  <?= yii::t('task', 'file transmission mode'); ?>
              </label>
              <div id="transmission-full-ctl" class="radio" style="display: inline;" data-rel="tooltip" data-title="<?= yii::t('task', 'file transmission mode full tip') ?>" data-placement="right">
                  <label>
                      <input name="Task[file_transmission_mode]" value="<?= Task::FILE_TRANSMISSION_MODE_FULL ?>" type="radio" class="ace">
                      <span class="lbl"><?= yii::t('task', 'file transmission mode full') ?></span>
                  </label>
              </div>

              <div id="transmission-part-ctl" class="radio" style="display: inline;" data-rel="tooltip" data-title="<?= yii::t('task', 'file transmission mode part tip') ?>" data-placement="right">
                  <label>
                      <input name="Task[file_transmission_mode]" value="<?= Task::FILE_TRANSMISSION_MODE_PART ?>" type="radio" checked="checked" class="ace">
                      <span class="lbl"><?= yii::t('task', 'file transmission mode part') ?></span>
                  </label>
              </div>
          </div>
          <!-- 全量/增量 end -->

<?php /*
          <!-- 文件列表 -->
          <?= $form->field($task, 'file_list')
              ->textarea([
                  'rows'           => 12,
                  'placeholder'    => "index.php\nREADME.md\ndir_name\nfile*",
                  'data-html'      => 'true',
                  'data-placement' => 'top',
                  'data-rel'       => 'tooltip',
                  'data-title'     => yii::t('task', 'file list placeholder'),
                  'style'          => 'display: none',
              ])
              ->label(yii::t('task', 'file list'),
                  ['class' => 'control-label bolder blue', 'style' => 'display: none']) ?>
          <!-- 文件列表 end -->
*/ ?>
      <div class="col-lg-5">
      <table id="file-list" class="table table-striped table-bordered" cellspacing="0" style="width:99%">
        <thead>
            <tr>
                <th style="width:30px;" data-class-name="aaaa">#</th>
                <th style="width:50px;">状态</th>
                <th style="width:50px;">比较</th>
                <th data-class-name="file-name">文件</th>
            </tr>
        </thead>
      </table>
    </div>
    <div class="col-lg-7">
      <table id="diff-view" class="table table-striped table-bordered DifferencesSideBySide" cellspacing="0" style="width:99%">
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th data-class-name="Left">新版(待发布)</th>
                <th style="width:30px;">#</th>
                <th data-class-name="Right">旧版(线上)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>请选择文件</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
      </table>

    </div>

      </div><!-- /.box-body -->

      <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="<?= yii::t('w', 'submit') ?>">
      </div>

    <!-- 错误提示-->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="800px">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        <?= yii::t('w', 'modal error title') ?>
                    </h4>
                </div>
                <div class="modal-body"></div>
            </div><!-- /.modal-content -->
        </div>

    </div>
    <!-- 错误提示-->

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs(<<<JS
    jQuery(function($) {
            var showFile = [];
            var dt = $('#diff-view').DataTable({
                scrollY : "400px",
                scrollCollapse: true,
                paging: false,
                ordering: false,
                createdRow : function(row, data, index) {
                    $(row).addClass(data.class);
                },
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "文件无变化",
                    "info": "共 _PAGES_ 页，当前第 _PAGE_ 页",
                    "infoEmpty": "文件无变化",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                },
                columns : [
                    {data: 'idx_c', defaultContent: ''},
                    {data: 'c'},
                    {data: 'idx_b', defaultContent: ''},
                    {data: 'b'}
                ]
            });

            $('#file-list').dataTable({
                paging: false,
                scrollY : "400px",
                scrollCollapse: true,
                //select : true,
                //searching: false,
                order: [[3, 'asc']],
                //processing: true,
                //serverSide: true,
                //ajax: "/project/filelist?projectId=8&commitId=61c7d31",
                columns : [
                    {data: 'selected'},
                    {data: 'status', defaultContent: 'S'},
                    {defaultContent:'<a href="javascript:return void(0);">a</a>'},
                    {data: 'file'}
                ],
                "columnDefs": [
                    {
                        "render": function ( data, type, row ) {
                            var html = '<input type="checkbox" name="Task[file_list][]" value="' + row.file + '"'
                            if (data) {
                                html += ' checked="checked" ';
                            }
                            html += ' />';
                            showFile.push(row.file);
                            return html;
                        },
                        "targets": 0
                    },
                    {
                        render : function (data, type, row) {
                            if (row.type == 'f') {
                                return '<a data-title="/home/xianzhao/workspace/ggame-coop/common/models/Admin.php" href="javascript:void(0);" class="file-diff label label-warning">diff</a>';
                            } else {
                                return '<a class="dir-open label label-primary" href="javascript:void(0);">open</a>';
                            }
                        },
                        "targets": 2
                    }
                ],
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "所选版本和线上版本一致",
                    "info": "共 _PAGES_ 页，当前第 _PAGE_ 页",
                    "infoEmpty": "无数据",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            });

        $('#file-list tbody').on( 'click', 'tr td a.dir-open', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            $.get('/project/filelist?projectId={$_GET['projectId']}&dir='+row.data().file, function(data){
                $.each(data.data, function(index, item){
                    idx = $.inArray(item.file, showFile);
                    if (idx === -1) {
                        showFile.push(item.file);
                        dt.row.add(item).draw(false);
                    }
                });
                
            }, 'json');
        });


        $('#file-list tbody').on( 'click', 'tr td a.file-diff', function () {
            var tdFile = $(this).closest('tr').find('td.file-name');
            var file = tdFile.html();
            var commitId = $('#task-commit_id').val();

            $.get('/project/filediff', {projectId:{$_GET['projectId']}, commitId: commitId, file:file}, function(data) {
                var tableData = [],
                    options = {
                        insert: {tag: 'ins', class: 'ChangeInsert'},
                        delete: {tag: 'del', class: 'ChangeDelete'},
                        replace: {tag: 'span', class: 'ChangeReplace'},
                        equal: {tag: 'span', class: 'ChangeEqual'},
                    },
                    idx_b = 0,
                    idx_c = 0;

                $.each(data, function(i, section) {
                    $.each(section, function(j, item) {
                        idx_b = item.base.offset;
                        idx_c = item.changed.offset;
                        var tag = options[item.tag] ? options[item.tag].tag : 'span',
                            cssClass = options[item.tag] ? options[item.tag].class : '';
                        if (item.base.lines.length > 0) {
                            $.each(item.base.lines, function(k, line){
                                var _row = [];
                                _row['class'] = cssClass;
                                _row['idx_b'] = ++ idx_b;
                                _row['b'] = '<' + tag + '>' + line + '</' + tag + '>';
                                if (item.changed.lines.length > 0) {
                                    _row['idx_c'] = ++ idx_c;
                                    _row['c'] = '<' + tag + '>' + item.changed.lines.shift() + '</' + tag + '>';
                                } else {
                                    _row['c'] = '';
                                    _row['idx_c'] = '';
                                }
                                tableData.push(_row);
                            });
                        }
                        if (item.changed.lines.length > 0){
                            $.each(item.changed.lines, function(k, line) {
                                var _row = [];
                                _row['class'] = cssClass;
                                _row['idx_b'] = '';
                                _row['b'] = '';
                                _row['idx_c'] = ++ idx_c;
                                _row['c'] = '<' + tag + '>' + line + '</' + tag + '>';
                                tableData.push(_row);
                            });
                        }
                    });
                    var _row = {class: '', idx_b: '...', b: '', idx_c: '...', c: ''};
                    tableData.push(_row);
                });

                $('#diff-view').dataTable().fnClearTable();
                if (tableData.length > 0) {
                    $('#diff-view').dataTable().fnAddData(tableData);
                }

                $('#diff-view_info').html('当前文件: ' + file);
                //modalBody.html(data);
            }, 'json');
        });
            

        // 用户上次选择的分支作为转为分支
        var project_id = {$_GET['projectId']};
        var branch_name = 'pre_branch_' + project_id;
        var pre_branch = ace.cookie.get(branch_name);
        if (pre_branch) {
            var option = '<option value="' + pre_branch + '" selected>' + pre_branch + '</option>';
            $('#branch').html(option);
        }

        function getBranchList() {
            $('.get-branch').show();
            $('.tip').hide();
            $('.show-tip').hide();
            $.get("/walle/get-branch?projectId=" + {$_GET['projectId']}, function (data) {
                // 获取分支失败
                if (data.code) {
                    showError(data.msg);
                }
                var select = '';
                $.each(data.data, function (key, value) {
                    // 默认选中 master 分支
                    var checked = value.id == 'master' ? 'selected' : '';
                    select += '<option value="' + value.id + '"' + checked + '>' + value.message + '</option>';
                });
                $('#branch').html(select);
                $('.get-branch').hide();
                $('.show-tip').show();
                if(data.data.length == 1 || ace.cookie.get(branch_name) != 'master') {
                    // 获取分支完成后, 一定条件重新获取提交列表
                    $('#branch').change();
                }

            });
        }

        function getCommitList() {
            $('.get-history').show();
            $.get("/walle/get-commit-history?projectId=" + {$_GET['projectId']} +"&branch=" + $('#branch').val(), function (data) {
                // 获取commit log失败
                if (data.code) {
                    showError(data.msg);
                }

                var select = '';
                $.each(data.data, function (key, value) {
                    select += '<option value="' + value.id + '">' + value.message + '</option>';
                });
                $('#task-commit_id').html(select);
                $('.get-history').hide()

                getFileList();
                
                $('#task-title').val($('#task-commit_id').find('option:selected').text());
            });
        }

        function getFileList() {
            var commitId = $('#task-commit_id').val();
            $.get("/project/filelist?projectId={$_GET['projectId']}&commitId=" + commitId, function(data){
                $('#file-list').dataTable().fnClearTable();
                if (data.data.length > 0) {
                    $('#file-list').dataTable().fnAddData(data.data);
                }
            }, 'json');
                
        }

        $('#branch').change(function() {
            // 添加cookie记住最近使用的分支名字
            ace.cookie.set(branch_name, $(this).val(), 86400*30)
            getCommitList();
        });

        $('#task-commit_id').change(function(){
            getFileList();
            $('#task-title').val($(this).find('option:selected').text());
        });

        // 页面加载完默认拉取master的commit log
        getCommitList();

        // 查看所有分支提示
        $('.show-tip')
            .hover(
            function() {
                $('.tip').show()
            },
            function() {
                $('.tip').hide()
            })
            .click(function() {
                getBranchList();
            });

        // 错误提示
        function showError(msg) {
            $('.modal-body').html(msg);
            $('#myModal').modal({
                backdrop: true,
                keyboard: true,
                show: true
            });
        }

        // 清除提示框内容
        $("#myModal").on("hidden.bs.modal", function () {
            $(this).removeData("bs.modal");
        });

        // 公共提示
        $('[data-rel=tooltip]').tooltip({container:'body'});
        $('[data-rel=popover]').popover({container:'body'});

        // 切换显示文件列表
        $('body').on('click', '#transmission-full-ctl', function() {
            //$('#file-list').hide();
            //$('label[for="task-file-list"]').hide();
        }).on('click', '#transmission-part-ctl', function() {
            //$('#file-list').show();
            //$('label[for="task-file-list"]').show();
        });

    })
JS
, \yii\web\View::POS_READY);
?>
