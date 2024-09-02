<?php

namespace App\Enums;

enum LicenceEnum: string
{
    case BASIC = 'basic';
    case PREMIUM = 'premium';
    case ENTERPRISE = 'enterprise';
    case ADMIN = 'admin';
}
