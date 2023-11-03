<?php

namespace App\Tbuy\MediaLibrary\Enums;

enum MediaLibraryCollection: string
{
    case BRAND_LOGO = 'logo';
    case PRODUCT_MEDIA = 'product-media';
    case PRODUCT_MEDIA_MAIN = 'product-media-main';
    case MENU_IMAGE = 'menu-image';
    case VACANCY_MEDIA = 'vacancy-media';
    case COMPANY_BRAND_DOCUMENT = 'company-brand-document';
    case COMPANY_INN_DOCUMENT = 'company-inn-document';
    case COMPANY_PASSPORT_DOCUMENT = 'company-passport-document';
    case COMPANY_STATE_REGISTER_DOCUMENT = 'company-state-register-document';
    case COMPANY_LOGO = 'company-logo';
    case BRAND_CERTIFICATE = 'brand-certificate';
}
