<?php
namespace App\Models;
use CodeIgniter\Model;

class TrainingmanualModel extends Model
{
    protected $table = 'ci_training_manuals';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'job_position', 'employee_number', 'pob_dob', 'address', 'phone_number',
        'education_data', 'training_data', 
        'license_ame_no', 'license_ame_exp', 'license_ame_rating',
        'license_coma_no', 'license_coma_exp', 'license_coma_rating',
        'license_cofc_no', 'license_cofc_exp', 'license_cofc_rating',
        'basic_cert_a', 'basic_cert_c',
        'prepared_by', 'employee_signed', 'approved_by', 'company_id',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
