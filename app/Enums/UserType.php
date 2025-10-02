<?php

namespace App\Enums;
enum UserType: string
{

    // const Type Array
    case ADMIN = 'ADMIN';
    case PATIENT = 'PATIENT';
    case DOCTOR = 'DOCTOR';
    case NURSE = 'NURSE';


    public function label() : string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::PATIENT => 'Patient',
            self::DOCTOR => 'Doctor',
            self::NURSE => 'Nurse',
            default => 'Unknown',
        };
    }

    /**
     * Get all types as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
    /**
     * Get all types with labels
     */
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($type) => [
            $type->value => $type->label()
        ])->toArray();
    }


}
