<?php

require_once('../config.php');
global $CFG, $DB, $USER;
require_once($CFG->dirroot . '/test/form.php');

$redirect = $CFG->wwwroot . '/test/index.php';

echo $OUTPUT->header();

$mform = new simplehtml_form();
if ($mform->is_cancelled()) {
    echo 'You Clicked Cancel';
} else if ($fromform = $mform->get_data()) {
    $context = \core\context\system::instance();
    $data = new stdClass;
    //
    $data->email = $fromform->email;
    $data->added_time = time();
    $data->added_by = $USER->id;
    //
    $file_name = $mform->get_new_filename('userfile');
    $fullpath = "upload/".$file_name;
    $success = $mform->save_file('userfile', $fullpath,false);
    // add file
    // $data->file_path = $fullpath;
    if(!$success)
    {
        echo 'something wrong';
    }
    $insertId = $DB->insert_record('email_list',$data);

    file_save_draft_area_files(
        $fromform->attachments,
        $context->id,
        'ram_component',
        'ram_filearea',
        $insertId
    );

    redirect($redirect,'Record Created Sucessfully',null,\core\output\notification::NOTIFY_SUCCESS);

} else {
    // Set anydefault data (if any).
    $mform->set_data($toform);
    // Display the form.
    $mform->display();
}

echo $OUTPUT->footer();