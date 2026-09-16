<?php
declare(strict_types=1);

/**
 * phpMyAdmin configuration for local development
 */

/* 32-character blowfish secret for cookie authentication encryption */
$cfg['blowfish_secret'] = 'h9F7zQ2w8K3mP5rT1xY6uV0cB4nE7sJ2';

$cfg['PmaAbsoluteUri'] = '';
$cfg['ForceSSL'] = false;
$cfg['ExecTimeLimit'] = 300;

$i = 0;
$i++;

/* Authentication type */
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['password'] = '';

/* Server parameters */
$cfg['Servers'][$i]['host'] = '127.0.0.1';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;

/* Pre-fill username and allow empty password */
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['AllowNoPassword'] = true;

/* STRICT DATABASE ISOLATION: ONLY SHOW FORTUNES COLLECTION E-COMMERCE DATABASE */
$cfg['Servers'][$i]['verbose'] = 'Fortunes Collection (E-Commerce DB)';
$cfg['Servers'][$i]['only_db'] = ['fortunes_collection'];

/* Directories for saving/loading files from server */
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';
$cfg['TempDir'] = __DIR__ . '/tmp';

/* Default language */
$cfg['DefaultLang'] = 'en';

/* Console and general features */
$cfg['SendErrorReports'] = 'never';
