<?php

namespace App\Tbuy\User\Constants;

enum Permission: string
{
    case VIEW_ANY = 'view any';

    case VIEW_LOCALE = 'view locale';
    case UPDATE_LOCALE = 'update locale';
    case CREATE_LOCALE = 'create locale';
    case DELETE_LOCALE = 'delete locale';

    case VIEW_PRODUCT_LIST = 'view product list';
    case VIEW_REJECTED_PRODUCT_LIST = 'view rejected product list';
    case VIEW_ZERO_AMOUNT_PRODUCT_LIST = 'view zero amount product list';
    case UPDATE_PRODUCT = 'update product';
    case TOGGLE_PRODUCT_STATUS = 'toggle product status';
    case SET_PRODUCT_ATTRIBUTE = 'set product attribute';
    case STORE_PRODUCT_VISIBLE_FIELDS = 'store product visible fields';
    case VIEW_PRODUCT_VISIBLE_FIELDS = 'view product visible fields';

    case MENU_SET_USER = 'menu set user';
    case VIEW_MENU = 'view menu';
    case CREATE_MENU = 'create menu';
    case UPDATE_MENU = 'update menu';
    case DELETE_MENU = 'delete menu';

    case VIEW_BRAND = 'view brand';
    case CREATE_BRAND = 'create brand';
    case UPDATE_BRAND = 'update brand';
    case DELETE_BRAND = 'delete brand';
    case BRAND_ATTACH_PRODUCT = 'attach brand product';
    case BRAND_STATUS_EDIT = 'status update brand';
    case SET_BRAND_ATTRIBUTE = 'set brand attribute';
    case SUBSCRIBE_BRAND = 'subscribe brand';
    case UNSUBSCRIBE_BRAND = 'unsubscribe brand';

    case VIEW_REASON_LIST = 'view reason list';

    case VIEW_ATTRIBUTE = 'view attribute';
    case CREATE_ATTRIBUTE = 'create attribute';
    case UPDATE_ATTRIBUTE = 'update attribute';
    case DELETE_ATTRIBUTE = 'delete attribute';

    case VIEW_ATTRIBUTE_VALUE = 'view attribute value';
    case CREATE_ATTRIBUTE_VALUE = 'create attribute value';
    case UPDATE_ATTRIBUTE_VALUE = 'update attribute value';
    case DELETE_ATTRIBUTE_VALUE = 'delete attribute value';
    case BRAND_ATTACH_CATEGORY = 'brand attach category';

    case VIEW_CATEGORY = 'view category';
    case STORE_CATEGORY = 'store category';
    case SHOW_CATEGORY = 'show category';
    case UPDATE_CATEGORY = 'update category';
    case DELETE_CATEGORY = 'delete category';
    case RATIO_CATEGORY = 'ratio category';

    case VIEW_COMPANY = 'view company';
    case VIEW_COMPANY_EMPLOYEES = 'view company employees';
    case STORE_COMPANY = 'store company';
    case SHOW_COMPANY = 'show company';
    case UPDATE_COMPANY = 'update company';
    case DELETE_COMPANY = 'delete company';
    case SUBSCRIBE_COMPANY = 'subscribe company';
    case UNSUBSCRIBE_COMPANY = 'unsubscribe company';
    case TOGGLE_STATUS_COMPANY = 'toggle status company';
    case SCORE_COMPANY = 'score compnay';

    case VIEW_COMPANY_FILIAL = 'view company filial';
    case CREATE_COMPANY_FILIAL = 'create company filial';
    case UPDATE_COMPANY_FILIAL = 'edit company filial';
    case DELETE_COMPANY_FILIAL = 'delete company filial';
    case DATA_CONFIRMATION = 'data confirmation';

    case ViEW_COMPANY_EMPLOYEE = 'view company employee';
    case STORE_COMPANY_EMPLOYEE = 'store company employee';
    case SHOW_COMPANY_EMPLOYEE = 'show company employee';
    case UPDATE_COMPANY_EMPLOYEE = 'update company employee';
    case DELETE_COMPANY_EMPLOYEE = 'delete company employee';

    case VIEW_USER = 'view user';
    case STORE_USER = 'store user';
    case SHOW_USER = 'show user';
    case UPDATE_USER = 'update user';
    case DELETE_USER = 'delete user';

    case VIEW_SETTINGS = 'view settings';
    case SHOW_SETTINGS = 'show settings';
    case UPDATE_SETTINGS = 'update settings';

    case VIEW_VACANCY_LIST = 'view vacancy list';
    case CREATE_VACANCY = 'create vacancy';
    case UPDATE_VACANCY = 'update vacancy';
    case DELETE_VACANCY = 'delete vacancy';

    case VIEW_VACANCY_CATEGORY_LIST = 'view vacancy category list';
    case CREATE_VACANCY_CATEGORY = 'create vacancy category';
    case UPDATE_VACANCY_CATEGORY = 'update vacancy category';
    case DELETE_VACANCY_CATEGORY = 'delete vacancy category';

    case VIEW_SEARCHABLE_FIELD = 'view searchable field';
    case STORE_SEARCHABLE_FIELD = 'store searchable field';
    case SHOW_SEARCHABLE_FIELD = 'show searchable field';
    case UPDATE_SEARCHABLE_FIELD = 'update searchable field';
    case DELETE_SEARCHABLE_FIELD = 'delete searchable field';

    case VIEW_SEARCHABLE_MODEL = 'view searchable model';
    case STORE_SEARCHABLE_MODEL = 'store searchable model';
    case SHOW_SEARCHABLE_MODEL = 'show searchable model';
    case UPDATE_SEARCHABLE_MODEL = 'update searchable model';
    case DELETE_SEARCHABLE_MODEL = 'delete searchable model';

    case STORE_QUESTION = 'store question';
    case UPDATE_QUESTION = 'update question';
    case DELETE_QUESTION = 'delete question';

    case VIEW_REJECTIONS = 'view rejections';
    case UPDATE_REJECTION = 'update rejections';

    case VIEW_AUDIENCE_LIST = 'view audience list';
    case CREATE_AUDIENCE = 'create audience';
    case UPDATE_AUDIENCE = 'update audience';
    case DELETE_AUDIENCE = 'delete audience';

    case INVITE_CREATE = 'invite create';

    case INVITE_ACTIVATE = 'invite activate';

    case VIEW_BANNER = 'view banner';
    case CREATE_BANNER = 'create banner';
    case UPDATE_BANNER = 'update banner';
    case DELETE_BANNER = 'delete banner';

    case VIEW_TARGET_LIST = 'view target list';
    case CREATE_TARGET = 'create target';
    case UPDATE_TARGET = 'update target';
    case DELETE_TARGET = 'delete target';
    case CHANGE_TARGET_STATUS = 'change target status';

    case VIEW_TARIFF_LIST = 'view tariff list';
    case CREATE_TARIFF = 'create tariff';
    case UPDATE_TARIFF = 'update tariff';
    case DELETE_TARIFF = 'delete tariff';
    case BUY_TARIFF = 'buy tariff';
    case VIEW_TARIFF_LOG = 'view tariff log';

    public function toString(): string
    {
        return "permission:$this->value";
    }
}
