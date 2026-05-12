<?php
use CodeIgniter\I18n\Time;
use App\Models\SystemModel;
use App\Models\UsersModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');
$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5>Training Program Manuals</h5>
        <div class="card-header-right">
          <a href="<?= site_url('erp/training-manual-add');?>" class="btn btn-primary btn-sm"><i class="feather icon-plus"></i> Add New Manual</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered dataTable" id="xin_training_manual_table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Employee Number</th>
                <th>Job Position</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var xin_training_manual_table = $('#xin_training_manual_table').DataTable({
        "bDestroy": true,
        "ajax": {
            url : "<?= site_url("erp/trainingmanual/training_manual_list") ?>",
            type : 'GET'
        },
        "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
        }
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
});
</script>
