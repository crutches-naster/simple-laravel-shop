<?php

namespace App\Enums;

enum RoleNames: string
{
    case ADMIN = "admin";
    case MANAGER = "manager";
    case CUSTOMER = "customer";
}
