<?php

namespace App\Util;

class RuleManager
{

    const SYSTEM_ADMIN_ROLE = 1;
    const SYSTEM_COMPANY_ACCOUNT = 1;
    const FIELD_NAME_STATE = 'estado';
    const ACTIVE_STATE = 'A';
    const DISABLED_STATE = 'E';
    const ACTIVE_STATE_NAME = 'Activo';
    const DISABLED_STATE_NAME = 'Eliminado';
    const ADMINISTRATORS_ACCESS = [1, 2];
    const UNATTENDED_STATE_TYPE = 1;
    const STANDARD_ACCESS = [3];
    const ASESOR_ACCESS = [5];
    const EMPRESAS_ACESS = [6];

    public static function getStateName($state = self::DISABLED_STATE)
    {
        return $state == self::ACTIVE_STATE ? self::ACTIVE_STATE_NAME : self::DISABLED_STATE_NAME;
    }

    public static function getIsActive($state = self::DISABLED_STATE)
    {
        return $state == self::ACTIVE_STATE ? true : false;
    }

}
