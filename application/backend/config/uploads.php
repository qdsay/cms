<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['upbase_path'] = '../';
$config['upload_path'] = 'uploads/';

$config['types'] = array(
    'zip' => '|zip|rar|7z|tgz|tar|gz',
    'docs' => 'doc|docx|rtf|pdf',
    'image' => 'jpg|jpeg|png|gif'
);

$config['article'] = array(
    'image' => array(
        'directory' => 'sub',
        'upload_config' => array(
            'allowed_types' => $config['types']['image'],
            'max_size' => '2048',
            'encrypt_name' => TRUE
        ),
        'resize_config' => array(
            'create_thumb' => TRUE,
            'maintain_ratio' => TRUE,
            'scale' => array(
                's' => array(
                    'width' => 600,
                    'height' => 450
                ),
                't' => array(
                    'width' => 200, 
                    'height' => 150
                )
            )
        )
    ),
    'origin' => array(
        'directory' => 'sub',
        'upload_config' => array(
            'allowed_types' => $config['types']['image'],
            'max_size' => '2048',
            'encrypt_name' => TRUE
        )
    )
);
