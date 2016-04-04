<?php 
 //WARNING: The contents of this file are auto-generated


$dictionary["Project"]["fields"]["aos_quotes_project"] = array (
  'name' => 'aos_quotes_project',
  'type' => 'link',
  'relationship' => 'aos_quotes_project',
  'source' => 'non-db',
);


 // created: 2015-12-20 09:59:37
$dictionary['Project']['fields']['jjwg_maps_lat_c']['inline_edit']=1;

 

 // created: 2015-12-20 09:59:38
$dictionary['Project']['fields']['jjwg_maps_address_c']['inline_edit']=1;

 


$dictionary['Project']['fields']['SecurityGroups'] = array (
  	'name' => 'SecurityGroups',
    'type' => 'link',
	'relationship' => 'securitygroups_project',
	'module'=>'SecurityGroups',
	'bean_name'=>'SecurityGroup',
    'source'=>'non-db',
	'vname'=>'LBL_SECURITYGROUPS',
);






 // created: 2015-12-20 09:59:36
$dictionary['Project']['fields']['jjwg_maps_lng_c']['inline_edit']=1;

 

 // created: 2015-12-20 09:59:37
$dictionary['Project']['fields']['jjwg_maps_geocode_status_c']['inline_edit']=1;

 

// created: 2014-06-04 23:46:40
$dictionary["Project"]["fields"]["am_projecttemplates_project_1"] = array (
  'name' => 'am_projecttemplates_project_1',
  'type' => 'link',
  'relationship' => 'am_projecttemplates_project_1',
  'source' => 'non-db',
  'module' => 'AM_ProjectTemplates',
  'bean_name' => 'AM_ProjectTemplates',
  'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
  'id_name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
);
$dictionary["Project"]["fields"]["am_projecttemplates_project_1_name"] = array (
  'name' => 'am_projecttemplates_project_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_AM_PROJECTTEMPLATES_TITLE',
  'save' => true,
  'id_name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
  'link' => 'am_projecttemplates_project_1',
  'table' => 'am_projecttemplates',
  'module' => 'AM_ProjectTemplates',
  'rname' => 'name',
);
$dictionary["Project"]["fields"]["am_projecttemplates_project_1am_projecttemplates_ida"] = array (
  'name' => 'am_projecttemplates_project_1am_projecttemplates_ida',
  'type' => 'link',
  'relationship' => 'am_projecttemplates_project_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AM_PROJECTTEMPLATES_PROJECT_1_FROM_PROJECT_TITLE',
);


// created: 2014-06-20 12:06:29
$dictionary["Project"]["fields"]["project_users_1"] = array (
  'name' => 'project_users_1',
  'type' => 'link',
  'relationship' => 'project_users_1',
  'source' => 'non-db',
  'module' => 'Users',
  'bean_name' => 'User',
  'vname' => 'LBL_PROJECT_USERS_1_FROM_USERS_TITLE',
);


// created: 2014-06-24 15:48:56
$dictionary["Project"]["fields"]["project_contacts_1"] = array (
  'name' => 'project_contacts_1',
  'type' => 'link',
  'relationship' => 'project_contacts_1',
  'source' => 'non-db',
  'module' => 'Contacts',
  'bean_name' => 'Contact',
  'vname' => 'LBL_PROJECT_CONTACTS_1_FROM_CONTACTS_TITLE',
);

?>