<?php

namespace WeDevBr\Celcoin\Enums;

enum OwnerTypeEnum: string
{
    case REPRESENTATIVE_OWNER = 'REPRESENTANTE';
    case PARTNER_OWNER = 'SOCIO';
    case OTHER_PARTNER_OWNER = 'DEMAIS_SOCIOS';
}
