<?php
$education_data = json_decode($record['education_data'], true);
$training_data = json_decode($record['training_data'], true);

$cert_a = explode(',', $record['basic_cert_a']);
$cert_c = explode(',', $record['basic_cert_c']);

function chkbox($val, $arr) {
    if(in_array($val, $arr)) {
        return '&#9745;'; // Checked box
    }
    return '&#9744;'; // Unchecked box
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Program Manual</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #525659;
            display: flex; justify-content: center;
        }
        .page-a4 {
            width: 210mm; min-height: 297mm;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 20px auto; padding: 8mm 8mm;
            display: flex; flex-direction: column;
        }
        h1.main-title { font-family: "Arial Black", Arial, sans-serif; font-size: 20px; margin: 0; text-transform: uppercase; letter-spacing: -0.5px; }
        .sub-title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 5px; }
        .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .top-header img { height: 65px; }
        hr.thick-line { border: none; border-top: 4px solid black; margin: 0 0 15px 0; }
        table.main-table { width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 12px; }
        table.main-table>tbody>tr>td { border: 1px solid black; }
        .company-logo-cell { width: 20%; text-align: center; padding: 8px; }
        .company-logo-cell img { height: 45px; }
        .company-name-cell { width: 50%; text-align: center; font-weight: bold; font-size: 11px; padding: 5px; }
        .company-contact-cell { width: 30%; font-size: 9.5px; padding: 5px; }
        .contact-table { width: 100%; border-collapse: collapse; border: none; }
        .contact-table td { padding: 1px 0; border: none !important; vertical-align: top; }
        .section-title { font-size: 14px; font-weight: bold; padding: 4px 8px; background-color: white; }
        .center-title { text-align: center; font-size: 15px; font-weight: bold; padding: 5px; text-transform: uppercase; }
        .personal-layout { width: 100%; border-collapse: collapse; border: none; }
        .personal-fields { width: 70%; padding: 8px; vertical-align: top; }
        .personal-photo { width: 30%; border-left: 1px solid black; text-align: center; vertical-align: middle; font-size: 14px; }
        .field-table { width: 100%; border-collapse: collapse; border: none; line-height: 2; font-size: 12px; }
        .field-table td { border: none !important; padding: 0; vertical-align: top; }
        .field-label { width: 150px; }
        .field-colon { width: 15px; }
        .edu-wrapper { padding: 15px; }
        .edu-table { width: 90%; margin: 0 auto; border-collapse: collapse; text-align: center; border: 1px solid black; }
        .edu-table th { border: 1px solid black; font-weight: normal; padding: 5px; }
        .edu-table td { border: 1px solid black; padding: 12px; height: 25px; }
        .train-table { width: 100%; border-collapse: collapse; text-align: center; border: none; }
        .train-table th { border-right: 1px solid black; border-bottom: 1px solid black; font-weight: normal; padding: 6px 4px; font-size: 12px; vertical-align: middle; }
        .train-table th:last-child { border-right: none; }
        .train-table td { border-right: 1px solid black; height: 220px; vertical-align: top; padding: 5px;}
        .train-table td:last-child { border-right: none; }
        .license-header-table { width: 100%; border-collapse: collapse; text-align: center; border: none; }
        .license-header-table td { width: 25%; border-right: 1px solid black; border-bottom: 1px solid black; padding: 3px; }
        .license-header-table td:last-child { border-right: none; }
        .license-body-table { width: 100%; border-collapse: collapse; border: none; }
        .license-body-table td.col-box { width: 25%; border-right: 1px solid black; padding: 5px 8px; vertical-align: top; }
        .license-body-table td.col-box:last-child { border-right: none; padding: 0; }
        .lic-field-table { width: 100%; border-collapse: collapse; border: none; line-height: 2; font-size: 12px; }
        .lic-field-table td { border: none !important; padding: 0; vertical-align: top; }
        .lic-label { width: 50px; }
        .lic-colon { width: 10px; }
        .checkbox-table { width: 100%; height: 100%; border-collapse: collapse; border: none; }
        .checkbox-table td { border: none !important; padding: 8px 5px; text-align: center; font-size: 12px; }
        .checkbox-table tr:first-child td { border-bottom: 1px solid black !important; }
        .chk-box { font-size: 16px; margin-right: 2px; vertical-align: text-bottom; }
        .sig-table { width: 100%; border-collapse: collapse; text-align: center; border: none; }
        .sig-table td { width: 33.33%; border-right: 1px solid black !important; padding: 5px; vertical-align: top; height: 80px; }
        .sig-table td:last-child { border-right: none !important; }
        .sig-line-text { margin-top: 50px; }
        .footer-no { margin-top: 5px; font-size: 13px; }
        .print-btn { position: fixed; top: 20px; right: 20px; padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px;}
        
        .dyn-item { text-align: left; margin-bottom: 5px; border-bottom: 1px dashed #ccc; padding-bottom: 5px;}

        @media print {
            body { background: none; }
            .page-a4 { margin: 0; box-shadow: none; padding: 10mm; border: none; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print PDF</button>
    <div class="page-a4">
        <!-- Top Header Outside Table -->
        <div class="top-header">
            <img src="https://gis.globalmaintenance.co.id/public/uploads/logo/other/GMF Logo 2021.png" alt="GMF Logo">
            <h1 class="main-title">TRAINING PROGRAM MANUAL</h1>
        </div>
        <hr class="thick-line">
        <div class="sub-title">APPENDIX 12 &ndash; EMPLOYEE TRAINING RECORD</div>

        <!-- MAIN BORDERED TABLE -->
        <table class="main-table">
            <!-- Company Details Row -->
            <tr>
                <td class="company-logo-cell">
                    <img src="https://gis.globalmaintenance.co.id/public/uploads/logo/other/GMF Logo 2021.png" alt="GMF Logo">
                </td>
                <td class="company-name-cell">
                    <div style="margin-bottom: 4px;">PT Global Maintenance Facility</div>
                    <div style="margin-bottom: 4px;">Approved Maintenance Organization</div>
                    <div>DGCA No: 145D-376</div>
                </td>
                <td class="company-contact-cell">
                    <table class="contact-table">
                        <tr><td style="width: 35px;">Phone</td><td>: +62 21 809 2019</td></tr>
                        <tr><td>Fax</td><td>: +62 21 809 1993</td></tr>
                        <tr><td>Email</td><td>: info@globalmaintenancefacility.co.id</td></tr>
                    </table>
                </td>
            </tr>

            <!-- Title Row -->
            <tr><td colspan="3" class="center-title">EMPLOYEE TRAINING RECORD</td></tr>

            <!-- A. Personal -->
            <tr><td colspan="3" class="section-title">A. Personal</td></tr>
            <tr>
                <td colspan="3" style="padding: 0;">
                    <table class="personal-layout">
                        <tr>
                            <td class="personal-fields">
                                <table class="field-table">
                                    <tr><td class="field-label">Name</td><td class="field-colon">:</td><td><?= $record['name'] ?></td></tr>
                                    <tr><td class="field-label">Job Position</td><td class="field-colon">:</td><td><?= $record['job_position'] ?></td></tr>
                                    <tr><td class="field-label">Employee Number</td><td class="field-colon">:</td><td><?= $record['employee_number'] ?></td></tr>
                                    <tr><td class="field-label">Place, Date of Birth</td><td class="field-colon">:</td><td><?= $record['pob_dob'] ?></td></tr>
                                    <tr><td class="field-label">Address</td><td class="field-colon">:</td><td><?= $record['address'] ?></td></tr>
                                    <tr><td class="field-label">Phone Number</td><td class="field-colon">:</td><td><?= $record['phone_number'] ?></td></tr>
                                </table>
                            </td>
                            <td class="personal-photo">Photo</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- B. Education -->
            <tr><td colspan="3" class="section-title">B. Education</td></tr>
            <tr>
                <td colspan="3" class="edu-wrapper">
                    <table class="edu-table">
                        <tr>
                            <th style="width: 25%;">Degree</th>
                            <th style="width: 25%;">Institutions</th>
                            <th style="width: 25%;">Major</th>
                            <th style="width: 25%;">Graduate</th>
                        </tr>
                        <?php if(!empty($education_data)): foreach($education_data as $edu): ?>
                        <tr>
                            <td><?= $edu['degree'] ?></td>
                            <td><?= $edu['institutions'] ?></td>
                            <td><?= $edu['major'] ?></td>
                            <td><?= $edu['graduate'] ?></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td></td><td></td><td></td><td></td></tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>

            <!-- C. Training -->
            <tr><td colspan="3" class="section-title">C. Training</td></tr>
            <tr>
                <td colspan="3" style="padding: 0;">
                    <table class="train-table">
                        <tr>
                            <th style="width: 15%;">Course Tittle</th>
                            <th style="width: 18%;">Course Objective</th>
                            <th style="width: 15%;">Date Completed</th>
                            <th style="width: 12%;">Test Resulted</th>
                            <th style="width: 12%;">Total Hours<br>of Training</th>
                            <th style="width: 13%;">Location<br>of<br>Training</th>
                            <th style="width: 15%;">Name of<br>Instructor</th>
                        </tr>
                        <tr>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['course'].'</div>'; ?></td>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['objective'].'</div>'; ?></td>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['date'].'</div>'; ?></td>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['result'].'</div>'; ?></td>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['hours'].'</div>'; ?></td>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['location'].'</div>'; ?></td>
                            <td><?php if(!empty($training_data)) foreach($training_data as $t) echo '<div class="dyn-item">'.$t['instructor'].'</div>'; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Licenses & Certificates -->
            <tr>
                <td colspan="3" style="padding: 0;">
                    <table class="license-header-table">
                        <tr>
                            <td>AME License</td>
                            <td>COMA</td>
                            <td>C of C</td>
                            <td>Basic Certificate</td>
                        </tr>
                    </table>
                    <table class="license-body-table">
                        <tr>
                            <td class="col-box">
                                <table class="lic-field-table">
                                    <tr><td class="lic-label">No</td><td class="lic-colon">:</td><td><?= $record['license_ame_no'] ?></td></tr>
                                    <tr><td class="lic-label">Expired</td><td class="lic-colon">:</td><td><?= $record['license_ame_exp'] ?></td></tr>
                                    <tr><td class="lic-label">Rating</td><td class="lic-colon">:</td><td><?= $record['license_ame_rating'] ?></td></tr>
                                </table>
                            </td>
                            <td class="col-box">
                                <table class="lic-field-table">
                                    <tr><td class="lic-label">No</td><td class="lic-colon">:</td><td><?= $record['license_coma_no'] ?></td></tr>
                                    <tr><td class="lic-label">Expired</td><td class="lic-colon">:</td><td><?= $record['license_coma_exp'] ?></td></tr>
                                    <tr><td class="lic-label">Rating</td><td class="lic-colon">:</td><td><?= $record['license_coma_rating'] ?></td></tr>
                                </table>
                            </td>
                            <td class="col-box">
                                <table class="lic-field-table">
                                    <tr><td class="lic-label">No</td><td class="lic-colon">:</td><td><?= $record['license_cofc_no'] ?></td></tr>
                                    <tr><td class="lic-label">Expired</td><td class="lic-colon">:</td><td><?= $record['license_cofc_exp'] ?></td></tr>
                                    <tr><td class="lic-label">Rating</td><td class="lic-colon">:</td><td><?= $record['license_cofc_rating'] ?></td></tr>
                                </table>
                            </td>
                            <td class="col-box">
                                <table class="checkbox-table">
                                    <tr>
                                        <td>
                                            <span class="chk-box"><?= chkbox('A1',$cert_a) ?></span> A1 &nbsp;&nbsp;
                                            <span class="chk-box"><?= chkbox('A2',$cert_a) ?></span> A2 &nbsp;&nbsp;
                                            <span class="chk-box"><?= chkbox('A3',$cert_a) ?></span> A3 &nbsp;&nbsp;
                                            <span class="chk-box"><?= chkbox('A4',$cert_a) ?></span> A4
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="chk-box"><?= chkbox('C1',$cert_c) ?></span> C1 &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="chk-box"><?= chkbox('C2',$cert_c) ?></span> C2 &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="chk-box"><?= chkbox('C4',$cert_c) ?></span> C4
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Signatures -->
            <tr>
                <td colspan="3" style="padding: 0;">
                    <table class="sig-table">
                        <tr>
                            <td>
                                Prepared By
                                <div class="sig-line-text"><?= !empty($record['prepared_by']) ? '( &nbsp; <b>'.$record['prepared_by'].'</b> &nbsp; )' : '(_____________________)' ?></div>
                            </td>
                            <td>
                                Employee Signed
                                <div class="sig-line-text"><?= !empty($record['employee_signed']) ? '( &nbsp; <b>'.$record['employee_signed'].'</b> &nbsp; )' : '(_____________________)' ?></div>
                            </td>
                            <td>
                                Approved By
                                <div class="sig-line-text"><?= !empty($record['approved_by']) ? '( &nbsp; <b>'.$record['approved_by'].'</b> &nbsp; )' : '(_____________________)' ?></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- Footer Note -->
        <div class="footer-no">Form No. : TPM/003/24</div>
    </div>
</body>
</html>