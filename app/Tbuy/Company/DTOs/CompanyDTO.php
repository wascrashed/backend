<?php

namespace App\Tbuy\Company\DTOs;

use App\DTOs\BaseDTO;
use App\Tbuy\Company\Enums\CompanyType;
use Illuminate\Http\UploadedFile;

class CompanyDTO extends BaseDTO
{
    /**
     * Создать новый экземпляр класса CompanyDTO.
     *
     * @param array $name Название компании.
     * @param CompanyType $type Тип компании (юридическое или физическое лицо).
     * @param string $inn ИНН компании.
     * @param string $status Статус компании (например, "active", "pending", "rejected" и т. д.).
     * @param DirectorDTO $director Информация о директоре компании (DTO).
     * @param PhonesDTO $phones Телефоны компании.
     * @param string $email Email компании.
    //     * @param string $slug Уникальный идентификатор компании (слаг).
     * @param UploadedFile|null $brand_document Документ с логотипом компании (необязательно).
     * @param UploadedFile|null $inn_document Документ с ИНН компании (необязательно).
     * @param UploadedFile|null $passport_document Документ с паспортом компании (необязательно).
     * @param UploadedFile|null $state_register_document Документ с государственной регистрацией компании (необязательно).
     * @param int|null $parent_id Идентификатор родительской компании, если это дочерняя компания (необязательно).
     * @param bool $legal_entity Является ли компания юридическим лицом (по умолчанию true).
     */
    public function __construct(
        public readonly array         $name,
        public readonly CompanyType   $type,
        public readonly DirectorDTO   $director,
        public readonly PhonesDTO     $phones,
        public readonly string        $email,
        public readonly string        $inn,
        public readonly string        $status,
        public readonly ?string       $slug = null,
        public readonly ?UploadedFile $brand_document = null,
        public readonly ?UploadedFile $inn_document = null,
        public readonly ?UploadedFile $passport_document = null,
        public readonly ?UploadedFile $state_register_document = null,
        public readonly ?int          $parent_id = null,
        public readonly bool          $legal_entity = true,
        public ?int                   $user_id = null
    )
    {
    }
}
