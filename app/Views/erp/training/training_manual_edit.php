<?php
use App\Models\SystemModel;
use App\Models\UsersModel;

$SystemModel = new SystemModel();
$UsersModel = new UsersModel();

$session = \Config\Services::session();
$usession = $session->get('sup_username');

$education_data = json_decode($record['education_data'], true);
$training_data = json_decode($record['training_data'], true);

$cert_a = explode(',', $record['basic_cert_a']);
$cert_c = explode(',', $record['basic_cert_c']);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Training Program Manual</h5>
            </div>
            <div class="card-body">
                <?php $attributes = array('name' => 'edit_training_manual', 'id' => 'edit_training_manual', 'autocomplete' => 'off', 'class' => 'form'); ?>
                <?php $hidden = array('user_id' => 0, 'token' => uencode($record['id'])); ?>
                <?= form_open('erp/training-manual-update', $attributes, $hidden); ?>
                
                <h6 class="mb-3">A. Personal</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" value="<?= $record['name'] ?>" name="name" type="text" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Job Position</label>
                            <input class="form-control" value="<?= $record['job_position'] ?>" name="job_position" type="text" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Employee Number</label>
                            <input class="form-control" value="<?= $record['employee_number'] ?>" name="employee_number" type="text" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Place, Date of Birth</label>
                            <input class="form-control" value="<?= $record['pob_dob'] ?>" name="pob_dob" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input class="form-control" value="<?= $record['phone_number'] ?>" name="phone_number" type="text">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" rows="2"><?= $record['address'] ?></textarea>
                        </div>
                    </div>
                </div>

                <hr>
                <h6 class="mb-3">B. Education</h6>
                <div id="education-wrapper">
                    <?php if(!empty($education_data)): ?>
                        <?php foreach($education_data as $edu): ?>
                        <div class="row edu-item mt-3">
                            <div class="col-md-3">
                                <div class="form-group"><label>Degree</label><input type="text" class="form-control" value="<?= $edu['degree'] ?>" name="edu_degree[]"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Institutions</label><input type="text" class="form-control" value="<?= $edu['institutions'] ?>" name="edu_institutions[]"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Major</label><input type="text" class="form-control" value="<?= $edu['major'] ?>" name="edu_major[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Graduate</label><input type="text" class="form-control" value="<?= $edu['graduate'] ?>" name="edu_graduate[]"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="row edu-item">
                            <div class="col-md-3">
                                <div class="form-group"><label>Degree</label><input type="text" class="form-control" name="edu_degree[]"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group"><label>Institutions</label><input type="text" class="form-control" name="edu_institutions[]"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Major</label><input type="text" class="form-control" name="edu_major[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Graduate</label><input type="text" class="form-control" name="edu_graduate[]"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-sm btn-info mb-4" id="add-edu">Add Education</button>

                <hr>
                <h6 class="mb-3">C. Training</h6>
                <div id="training-wrapper">
                    <?php if(!empty($training_data)): ?>
                        <?php foreach($training_data as $train): ?>
                        <div class="row train-item mt-3">
                            <div class="col-md-3">
                                <div class="form-group"><label>Course Title</label><input type="text" class="form-control" value="<?= $train['course'] ?>" name="train_course[]"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Course Objective</label><input type="text" class="form-control" value="<?= $train['objective'] ?>" name="train_objective[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Date Completed</label><input type="text" class="form-control" value="<?= $train['date'] ?>" name="train_date[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Test Resulted</label><input type="text" class="form-control" value="<?= $train['result'] ?>" name="train_result[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Total Hours</label><input type="text" class="form-control" value="<?= $train['hours'] ?>" name="train_hours[]"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Location of Training</label><input type="text" class="form-control" value="<?= $train['location'] ?>" name="train_location[]"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Name of Instructor</label><input type="text" class="form-control" value="<?= $train['instructor'] ?>" name="train_instructor[]"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="row train-item">
                            <div class="col-md-3">
                                <div class="form-group"><label>Course Title</label><input type="text" class="form-control" name="train_course[]"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group"><label>Course Objective</label><input type="text" class="form-control" name="train_objective[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Date Completed</label><input type="text" class="form-control" name="train_date[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Test Resulted</label><input type="text" class="form-control" name="train_result[]"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"><label>Total Hours</label><input type="text" class="form-control" name="train_hours[]"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Location of Training</label><input type="text" class="form-control" name="train_location[]"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>Name of Instructor</label><input type="text" class="form-control" name="train_instructor[]"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-sm btn-info mb-4" id="add-train">Add Training</button>

                <hr>
                <h6 class="mb-3">Licenses & Basic Certificate</h6>
                <div class="row">
                    <div class="col-md-4">
                        <b>AME License</b>
                        <div class="form-group mt-2"><label>No.</label><input type="text" class="form-control" value="<?= $record['license_ame_no'] ?>" name="license_ame_no"></div>
                        <div class="form-group"><label>Expired</label><input type="text" class="form-control" value="<?= $record['license_ame_exp'] ?>" name="license_ame_exp"></div>
                        <div class="form-group"><label>Rating</label><input type="text" class="form-control" value="<?= $record['license_ame_rating'] ?>" name="license_ame_rating"></div>
                    </div>
                    <div class="col-md-4">
                        <b>COMA</b>
                        <div class="form-group mt-2"><label>No.</label><input type="text" class="form-control" value="<?= $record['license_coma_no'] ?>" name="license_coma_no"></div>
                        <div class="form-group"><label>Expired</label><input type="text" class="form-control" value="<?= $record['license_coma_exp'] ?>" name="license_coma_exp"></div>
                        <div class="form-group"><label>Rating</label><input type="text" class="form-control" value="<?= $record['license_coma_rating'] ?>" name="license_coma_rating"></div>
                    </div>
                    <div class="col-md-4">
                        <b>C of C</b>
                        <div class="form-group mt-2"><label>No.</label><input type="text" class="form-control" value="<?= $record['license_cofc_no'] ?>" name="license_cofc_no"></div>
                        <div class="form-group"><label>Expired</label><input type="text" class="form-control" value="<?= $record['license_cofc_exp'] ?>" name="license_cofc_exp"></div>
                        <div class="form-group"><label>Rating</label><input type="text" class="form-control" value="<?= $record['license_cofc_rating'] ?>" name="license_cofc_rating"></div>
                    </div>
                </div>
                
                <b class="mt-3 d-block">Basic Certificate (Checklist)</b>
                <div class="row mt-2">
                    <div class="col-md-12 mb-2">
                        <label class="mr-3"><input type="checkbox" name="basic_cert_a[]" value="A1" <?= in_array('A1',$cert_a)?'checked':'' ?>> A1</label>
                        <label class="mr-3"><input type="checkbox" name="basic_cert_a[]" value="A2" <?= in_array('A2',$cert_a)?'checked':'' ?>> A2</label>
                        <label class="mr-3"><input type="checkbox" name="basic_cert_a[]" value="A3" <?= in_array('A3',$cert_a)?'checked':'' ?>> A3</label>
                        <label class="mr-3"><input type="checkbox" name="basic_cert_a[]" value="A4" <?= in_array('A4',$cert_a)?'checked':'' ?>> A4</label>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="mr-3"><input type="checkbox" name="basic_cert_c[]" value="C1" <?= in_array('C1',$cert_c)?'checked':'' ?>> C1</label>
                        <label class="mr-3"><input type="checkbox" name="basic_cert_c[]" value="C2" <?= in_array('C2',$cert_c)?'checked':'' ?>> C2</label>
                        <label class="mr-3"><input type="checkbox" name="basic_cert_c[]" value="C4" <?= in_array('C4',$cert_c)?'checked':'' ?>> C4</label>
                    </div>
                </div>

                <hr>
                <h6 class="mb-3">Signatures</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group"><label>Prepared By (Name)</label><input type="text" class="form-control" value="<?= $record['prepared_by'] ?>" name="prepared_by"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>Employee Signed (Name)</label><input type="text" class="form-control" value="<?= $record['employee_signed'] ?>" name="employee_signed"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><label>Approved By (Name)</label><input type="text" class="form-control" value="<?= $record['approved_by'] ?>" name="approved_by"></div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Update & Continue</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#add-edu').click(function() {
        var html = '<div class="row edu-item mt-3"><div class="col-md-3"><div class="form-group"><label>Degree</label><input type="text" class="form-control" name="edu_degree[]"></div></div><div class="col-md-4"><div class="form-group"><label>Institutions</label><input type="text" class="form-control" name="edu_institutions[]"></div></div><div class="col-md-3"><div class="form-group"><label>Major</label><input type="text" class="form-control" name="edu_major[]"></div></div><div class="col-md-2"><div class="form-group"><label>Graduate</label><input type="text" class="form-control" name="edu_graduate[]"></div></div></div>';
        $('#education-wrapper').append(html);
    });

    $('#add-train').click(function() {
        var html = '<div class="row train-item mt-3"><div class="col-md-3"><div class="form-group"><label>Course Title</label><input type="text" class="form-control" name="train_course[]"></div></div><div class="col-md-3"><div class="form-group"><label>Course Objective</label><input type="text" class="form-control" name="train_objective[]"></div></div><div class="col-md-2"><div class="form-group"><label>Date Completed</label><input type="text" class="form-control" name="train_date[]"></div></div><div class="col-md-2"><div class="form-group"><label>Test Resulted</label><input type="text" class="form-control" name="train_result[]"></div></div><div class="col-md-2"><div class="form-group"><label>Total Hours</label><input type="text" class="form-control" name="train_hours[]"></div></div><div class="col-md-6"><div class="form-group"><label>Location of Training</label><input type="text" class="form-control" name="train_location[]"></div></div><div class="col-md-6"><div class="form-group"><label>Name of Instructor</label><input type="text" class="form-control" name="train_instructor[]"></div></div></div>';
        $('#training-wrapper').append(html);
    });

    $("#edit_training_manual").submit(function(e) {
        e.preventDefault();
        var obj = $(this);
        $.ajax({
            type: "POST",
            url: e.target.action,
            data: obj.serialize() + "&is_ajax=1&type=edit_record",
            cache: false,
            success: function(JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                } else {
                    toastr.success(JSON.result);
                    window.location = "<?= site_url('erp/training-manual-list') ?>";
                }
            }
        });
    });
});
</script>
