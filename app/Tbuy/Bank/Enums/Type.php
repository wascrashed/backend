<?php

namespace App\Tbuy\Bank\Enums;

enum Type: string
{
    case CREATED_APPLICATION = "created";
    case SELECTED_APPLICATION = "selected";
    case PROFITABLE_LOAN = "profitable";
}
