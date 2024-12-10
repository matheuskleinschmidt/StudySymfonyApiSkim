<?php

namespace App\Enum;

enum PhotoStorageTypeEnum: string
{
    case LOCAL = 'LOCAL';
    case FIREBASE = 'FIREBASE';
    case EXTERNAL_LINK = 'EXTERNAL_LINK';
    case BASE64 = 'BASE64'; 
}
