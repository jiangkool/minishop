<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;
use Encore\Admin\Admin;

class ApplyTool extends BatchAction
{
    protected $id;
    protected $action;

    public function __construct($id = 1, $action = 0)
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function script()
    {
        return <<<EOT

        $('.btn').on('click', function () {

            console.log($(this).data('id'));
            var id = $(this).data('id');
            var action = $(this).data('action');

            $.ajax({
                method: 'post',
                url: '/admin/apply/operate/'+id,
                data: {
                    _token:LA.token,
                    action:action
                },
                success: function (res) {
                    $.pjax.reload('#pjax-container');
                    if (res.status == 1) {
                      toastr.success(res.message);
                    } else {
                      toastr.warning(res.message);
                    }
                }
            });

        });

EOT;
    }

    protected function render()
    {
        Admin::script($this->script());
        if ($this->action == 1) {
            return '<button type="button" class="btn btn-info btn-xs " data-id="'. $this->id .'" data-action="'. $this->action .'"><i class="fa fa-save"></i>&nbsp;同意</button>';
        } else if ($this->action == 2) {
            return '&nbsp;<button type="button" class="btn btn-warning btn-xs jujue" data-id="'. $this->id .'" data-action="'. $this->action .'"><i class="fa fa-save"></i>&nbsp;拒绝</button>';
        }else{
             return '<button type="button" class="btn btn-info btn-xs " data-id="'. $this->id .'" data-action="1"><i class="fa fa-save"></i>&nbsp;同意</button>&nbsp;<button type="button" class="btn btn-warning btn-xs jujue" data-id="'. $this->id .'" data-action="2"><i class="fa fa-save"></i>&nbsp;拒绝</button>';
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}
