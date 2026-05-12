<?php
namespace App\Controllers\Erp;
use App\Controllers\BaseController;
use App\Models\SystemModel;
use App\Models\RolesModel;
use App\Models\UsersModel;
use App\Models\TrainingmanualModel;

class Trainingmanual extends BaseController {

	public function index()
	{		
		$SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		
		$xin_system = $SystemModel->where('setting_id', 1)->first();
		$user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();

		$data['title'] = 'Training Program Manuals | '.$xin_system['application_name'];
		$data['path_url'] = 'training_manual';
		$data['breadcrumbs'] = 'Training Program Manuals';

		$data['subview'] = view('erp/training/training_manual_list', $data);
		return view('erp/layout/layout_main', $data);
	}

    public function training_manual_list() {
        $session = \Config\Services::session();
		$usession = $session->get('sup_username');
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
        
        $TrainingmanualModel = new TrainingmanualModel();
        $UsersModel = new UsersModel();
        $user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
        
        if($user_info['user_type'] == 'staff'){
            $get_data = $TrainingmanualModel->where('company_id', $user_info['company_id'])->orderBy('id', 'DESC')->findAll();
        } else {
            $get_data = $TrainingmanualModel->where('company_id', $usession['sup_user_id'])->orderBy('id', 'DESC')->findAll();
        }
        
        $data = array();
        
        foreach($get_data as $r) {
            $edit = '<a href="'.site_url().'erp/training-manual-edit/'.uencode($r['id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-primary waves-effect waves-light" title="Edit"><i class="feather icon-edit"></i></button></a>';
            $delete = '<button type="button" class="btn icon-btn btn-sm btn-light-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. uencode($r['id']) . '" title="Delete"><i class="feather icon-trash-2"></i></button>';
            $print = '<a target="_blank" href="'.site_url().'erp/training-manual-print/'.uencode($r['id']).'"><button type="button" class="btn icon-btn btn-sm btn-light-info waves-effect waves-light" title="Print PDF"><i class="feather icon-printer"></i></button></a>';
            
            $combhr = $edit . '&nbsp;' . $print . '&nbsp;' . $delete;	
			$t_type = '
				<strong>'.$r['name'].'</strong>
				<div class="overlay-edit">
					'.$combhr.'
				</div>';
            
            $data[] = array(
                $t_type,
                $r['employee_number'],
                $r['job_position'],
                date('d M Y', strtotime($r['created_at']))
            );
        }
        
        $output = array(
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function create() {
        $SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
		
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		
		$xin_system = $SystemModel->where('setting_id', 1)->first();

		$data['title'] = 'Create Training Manual | '.$xin_system['application_name'];
		$data['path_url'] = 'training_manual';
		$data['breadcrumbs'] = 'Create Training Manual';

		$data['subview'] = view('erp/training/training_manual_add', $data);
		return view('erp/layout/layout_main', $data);
    }

    public function edit() {
        $SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
        $TrainingmanualModel = new TrainingmanualModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
        $request = \Config\Services::request();
		
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		
		$xin_system = $SystemModel->where('setting_id', 1)->first();
        $id = udecode($request->uri->getSegment(3));

		$data['title'] = 'Edit Training Manual | '.$xin_system['application_name'];
		$data['path_url'] = 'training_manual';
		$data['breadcrumbs'] = 'Edit Training Manual';
        $data['record'] = $TrainingmanualModel->where('id', $id)->first();

		$data['subview'] = view('erp/training/training_manual_edit', $data);
		return view('erp/layout/layout_main', $data);
    }

    public function store() {
        $session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
        $UsersModel = new UsersModel();
        
        if ($this->request->getPost('type') === 'add_record') {
            $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
            
            $user_info = $UsersModel->where('user_id', $usession['sup_user_id'])->first();
            $company_id = ($user_info['user_type'] == 'staff') ? $user_info['company_id'] : $usession['sup_user_id'];

            // Prepare Education Data
            $education = [];
            $edu_degree = $this->request->getPost('edu_degree');
            if(is_array($edu_degree)) {
                $edu_inst = $this->request->getPost('edu_institutions');
                $edu_major = $this->request->getPost('edu_major');
                $edu_grad = $this->request->getPost('edu_graduate');
                for($i = 0; $i < count($edu_degree); $i++) {
                    if(!empty($edu_degree[$i])) {
                        $education[] = [
                            'degree' => $edu_degree[$i],
                            'institutions' => $edu_inst[$i],
                            'major' => $edu_major[$i],
                            'graduate' => $edu_grad[$i]
                        ];
                    }
                }
            }

            // Prepare Training Data
            $training = [];
            $train_course = $this->request->getPost('train_course');
            if(is_array($train_course)) {
                $train_obj = $this->request->getPost('train_objective');
                $train_date = $this->request->getPost('train_date');
                $train_result = $this->request->getPost('train_result');
                $train_hours = $this->request->getPost('train_hours');
                $train_loc = $this->request->getPost('train_location');
                $train_inst = $this->request->getPost('train_instructor');
                for($i = 0; $i < count($train_course); $i++) {
                    if(!empty($train_course[$i])) {
                        $training[] = [
                            'course' => $train_course[$i],
                            'objective' => $train_obj[$i],
                            'date' => $train_date[$i],
                            'result' => $train_result[$i],
                            'hours' => $train_hours[$i],
                            'location' => $train_loc[$i],
                            'instructor' => $train_inst[$i]
                        ];
                    }
                }
            }

            $basic_cert_a = $this->request->getPost('basic_cert_a');
            $basic_cert_c = $this->request->getPost('basic_cert_c');

            $data = [
                'company_id' => $company_id,
                'name' => $this->request->getPost('name'),
                'job_position' => $this->request->getPost('job_position'),
                'employee_number' => $this->request->getPost('employee_number'),
                'pob_dob' => $this->request->getPost('pob_dob'),
                'address' => $this->request->getPost('address'),
                'phone_number' => $this->request->getPost('phone_number'),
                
                'education_data' => json_encode($education),
                'training_data' => json_encode($training),
                
                'license_ame_no' => $this->request->getPost('license_ame_no'),
                'license_ame_exp' => $this->request->getPost('license_ame_exp'),
                'license_ame_rating' => $this->request->getPost('license_ame_rating'),
                
                'license_coma_no' => $this->request->getPost('license_coma_no'),
                'license_coma_exp' => $this->request->getPost('license_coma_exp'),
                'license_coma_rating' => $this->request->getPost('license_coma_rating'),
                
                'license_cofc_no' => $this->request->getPost('license_cofc_no'),
                'license_cofc_exp' => $this->request->getPost('license_cofc_exp'),
                'license_cofc_rating' => $this->request->getPost('license_cofc_rating'),
                
                'basic_cert_a' => is_array($basic_cert_a) ? implode(',', $basic_cert_a) : '',
                'basic_cert_c' => is_array($basic_cert_c) ? implode(',', $basic_cert_c) : '',
                
                'prepared_by' => $this->request->getPost('prepared_by'),
                'employee_signed' => $this->request->getPost('employee_signed'),
                'approved_by' => $this->request->getPost('approved_by'),
            ];

            $TrainingmanualModel = new TrainingmanualModel();
            $result = $TrainingmanualModel->insert($data);
            if ($result) {
                $Return['result'] = 'Training Manual Record Added.';
            } else {
                $Return['error'] = 'Error adding record.';
            }
            $this->output($Return);
            exit;
        }
    }

    public function update() {
        $session = \Config\Services::session();
		$request = \Config\Services::request();
		$usession = $session->get('sup_username');
        
        if ($this->request->getPost('type') === 'edit_record') {
            $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$Return['csrf_hash'] = csrf_hash();
            
            $id = udecode($this->request->getPost('token'));

            // Prepare Education Data
            $education = [];
            $edu_degree = $this->request->getPost('edu_degree');
            if(is_array($edu_degree)) {
                $edu_inst = $this->request->getPost('edu_institutions');
                $edu_major = $this->request->getPost('edu_major');
                $edu_grad = $this->request->getPost('edu_graduate');
                for($i = 0; $i < count($edu_degree); $i++) {
                    if(!empty($edu_degree[$i])) {
                        $education[] = [
                            'degree' => $edu_degree[$i],
                            'institutions' => $edu_inst[$i],
                            'major' => $edu_major[$i],
                            'graduate' => $edu_grad[$i]
                        ];
                    }
                }
            }

            // Prepare Training Data
            $training = [];
            $train_course = $this->request->getPost('train_course');
            if(is_array($train_course)) {
                $train_obj = $this->request->getPost('train_objective');
                $train_date = $this->request->getPost('train_date');
                $train_result = $this->request->getPost('train_result');
                $train_hours = $this->request->getPost('train_hours');
                $train_loc = $this->request->getPost('train_location');
                $train_inst = $this->request->getPost('train_instructor');
                for($i = 0; $i < count($train_course); $i++) {
                    if(!empty($train_course[$i])) {
                        $training[] = [
                            'course' => $train_course[$i],
                            'objective' => $train_obj[$i],
                            'date' => $train_date[$i],
                            'result' => $train_result[$i],
                            'hours' => $train_hours[$i],
                            'location' => $train_loc[$i],
                            'instructor' => $train_inst[$i]
                        ];
                    }
                }
            }

            $basic_cert_a = $this->request->getPost('basic_cert_a');
            $basic_cert_c = $this->request->getPost('basic_cert_c');

            $data = [
                'name' => $this->request->getPost('name'),
                'job_position' => $this->request->getPost('job_position'),
                'employee_number' => $this->request->getPost('employee_number'),
                'pob_dob' => $this->request->getPost('pob_dob'),
                'address' => $this->request->getPost('address'),
                'phone_number' => $this->request->getPost('phone_number'),
                
                'education_data' => json_encode($education),
                'training_data' => json_encode($training),
                
                'license_ame_no' => $this->request->getPost('license_ame_no'),
                'license_ame_exp' => $this->request->getPost('license_ame_exp'),
                'license_ame_rating' => $this->request->getPost('license_ame_rating'),
                
                'license_coma_no' => $this->request->getPost('license_coma_no'),
                'license_coma_exp' => $this->request->getPost('license_coma_exp'),
                'license_coma_rating' => $this->request->getPost('license_coma_rating'),
                
                'license_cofc_no' => $this->request->getPost('license_cofc_no'),
                'license_cofc_exp' => $this->request->getPost('license_cofc_exp'),
                'license_cofc_rating' => $this->request->getPost('license_cofc_rating'),
                
                'basic_cert_a' => is_array($basic_cert_a) ? implode(',', $basic_cert_a) : '',
                'basic_cert_c' => is_array($basic_cert_c) ? implode(',', $basic_cert_c) : '',
                
                'prepared_by' => $this->request->getPost('prepared_by'),
                'employee_signed' => $this->request->getPost('employee_signed'),
                'approved_by' => $this->request->getPost('approved_by'),
            ];

            $TrainingmanualModel = new TrainingmanualModel();
            $result = $TrainingmanualModel->update($id, $data);
            if ($result) {
                $Return['result'] = 'Training Manual Record Updated.';
            } else {
                $Return['error'] = 'Error updating record.';
            }
            $this->output($Return);
            exit;
        }
    }

    public function delete() {
        if($this->request->getPost('type')=='delete_record') {
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			$id = udecode($this->request->getPost('_token'));
			$Return['csrf_hash'] = csrf_hash();
			$TrainingmanualModel = new TrainingmanualModel();
			$result = $TrainingmanualModel->where('id', $id)->delete($id);
			if ($result) {
				$Return['result'] = 'Record Deleted.';
			} else {
				$Return['error'] = 'Error deleting record.';
			}
			$this->output($Return);
		}
    }

    public function print_manual() {
        $SystemModel = new SystemModel();
		$UsersModel = new UsersModel();
        $TrainingmanualModel = new TrainingmanualModel();
		$session = \Config\Services::session();
		$usession = $session->get('sup_username');
        $request = \Config\Services::request();
		
		if(!$session->has('sup_username')){ 
			return redirect()->to(site_url('erp/login'));
		}
		
        $id = udecode($request->uri->getSegment(3));
        $data['record'] = $TrainingmanualModel->where('id', $id)->first();

		return view('erp/training/training_manual_print', $data);
    }
}
