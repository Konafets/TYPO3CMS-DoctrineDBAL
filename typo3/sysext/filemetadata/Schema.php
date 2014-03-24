<?php

$schema = new Doctrine\DBAL\Schema\Schema();

$sysFileMetadata = $schema->createTable('sys_file_metadata');
$sysFileMetadata->addColumn('visible', 'integer', array('unsigned' => TRUE, 'default' => '1', 'notnull' => TRUE));
$sysFileMetadata->addColumn('status', 'string', array('length' => 24, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('keywords', 'text', array('length' => 65535, 'notnull' => TRUE));
$sysFileMetadata->addColumn('caption', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('creator_tool', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('download_name', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('creator', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('publisher', 'string', array('length' => 45, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('source', 'string', array('length' => 255, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('location_country', 'string', array('length' => 45, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('location_region', 'string', array('length' => 45, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('location_city', 'string', array('length' => 45, 'default' => '', 'notnull' => TRUE));
$sysFileMetadata->addColumn('latitude', 'decimal', array('precision' => 24, 'scale' => 14, 'default' => '0.00000000000000', 'notnull' => TRUE));
$sysFileMetadata->addColumn('longitude', 'decimal', array('precision' => 24, 'scale' => 14, 'default' => '0.00000000000000', 'notnull' => TRUE)); 
$sysFileMetadata->addColumn('ranking', 'integer', array('unsigned' => TRUE, 'default' => '0'));
$sysFileMetadata->addColumn('content_creation_date', 'integer', array('unsigned' => TRUE, 'default' => '0'));
$sysFileMetadata->addColumn('content_modification_date', 'integer', array('unsigned' => TRUE, 'default' => '0'));
$sysFileMetadata->addColumn('note', 'text', array('length' => 65535, 'notnull' => TRUE));
// px,mm,cm,m,p, ...
$sysFileMetadata->addColumn('unit', 'string', array('length' => 3, 'fixed' => TRUE, 'default' => '', 'notnull' => TRUE));
// AUDIO + VIDEO
$sysFileMetadata->addColumn('duration', 'float', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE));
// RGB,sRGB,YUV, ...
$sysFileMetadata->addColumn('color_space', 'string', array('length' => 4, 'default' => '', 'notnull' => TRUE));
// TEXT ASSET
// text document include x pages
$sysFileMetadata->addColumn('pages', 'integer', array('unsigned' => TRUE, 'default' => '0', 'notnull' => TRUE)); 
// TEXT + AUDIO + VIDEO
// correspond to the language of the document
$sysFileMetadata->addColumn('language', 'string', array('length' => 12, 'default' => '', 'notnull' => TRUE));
// FE permissions
$sysFileMetadata->addColumn('fe_groups', 'text', array('length' => 255, 'notnull' => TRUE));

return $schema;

