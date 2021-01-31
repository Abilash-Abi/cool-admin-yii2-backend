<?php
//Patterns
const REGX_NAME = '/^[A-z \s]+$/i';
const REGX_MOBILE = '/^([+]?([0-9 -]{10,13})+)$/';

const MSG_MOBILE = 'Please enter valid phone number';
const MSG_NAME = 'Allowed charecters are aphabet and space.';



const NO_REPLAY_MAIL = 'no-replay@yopmail.com';
const ERROR = 'error';
const SUCCESS = 'success';
const ACTIONS = 'actions';
const DB_DATETIME  = 'Y/m/d';
const MODEL = 'model';
const TEMPLATE = 'template';
const FORM_OPTIONS = ['class'=>'row form-group'];
const FORM_TEMPLATE  = '<div class="col col-md-3"><label for="email-input" class=" form-control-label">{label}</label></div><div class="col-12 col-md-9">{input}<small class="help-block form-text">{error}{hint}</small></div>';
const DATETIME = 'Y:m:d';
const APP_CONTENTS = 'users/contents';
//Data Listing
const TABLE_LAYOUT ='<div class="table-responsive m-b-40">{summary}{items}<nav class="pt-2">{pager}</nav></div>';
const EMPTY_TEXT_OPTIONS =['class'=>'text-center'];
const TABLE_OPTIONS =['class'=>'table table-borderless table-striped table-earning'];
const PAGINATION  =[
    'linkContainerOptions'=>['class'=>'page-item'],
    'linkOptions'=>['class'=>'page-link'],
    'options' => [
    'class' => 'pagination  pull-right pt-2',
]];
const EMPTY_TEXT ='Record Not Found';
const SUPER_ADMIN = 'Super Admin';
const HIDE_ROLE_LIST = ['Super Admin'];
//Permissions

const MANAGE_USER_ROLES = 'User Roles';
const MANAGE_ADMIN_USERS = 'Admin Users';
const MANAGE_CATEGORY = 'Category';

