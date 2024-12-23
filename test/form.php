<?php

require_once("$CFG->libdir/formslib.php");

class simplehtml_form extends moodleform
{
    public function definition()
    {
        global $CFG;
        $mform = $this->_form;

        $mform->addElement('text', 'email', get_string('email'));
        $mform->setType('email', PARAM_NOTAGS);
        $mform->setDefault('email', 'Please enter email');

        $maxbytes = get_max_upload_sizes();
        $mform->addElement(
            'filemanager',
            'attachments',
            'Attachment 1',
            null,
            [
                'subdirs' => 0,
                'maxbytes' => $maxbytes,
                'areamaxbytes' => 10485760,
                'maxfiles' => 2,
                'accepted_types' => ['document'],
                'return_types' => FILE_INTERNAL | FILE_EXTERNAL,
            ]
        );
        /*
        $mform->addElement(
            'filepicker',
            'userfile',
            get_string('file'),
            null,
            [
                'maxbytes' => 1024,
                'accepted_types' => [ 
                    // لو في تايب مش شغال روح ضيفو في ال server file type
                    // 'document' => .doc .docx .epub .gdoc .odt .oth .ott .pdf .rtf
                ],
            ]
        );
        */

        $this->add_action_buttons();
    }

    // Custom validation should be added here.
    function validation($data, $files)
    {
        return [];
    }
}
