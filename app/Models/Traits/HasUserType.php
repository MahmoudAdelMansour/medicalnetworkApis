<?php

namespace App\Models\Traits;
use App\Enums\UserType;

trait HasUserType
{
    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->type === UserType::ADMIN;
    }

    /**
     * Check if user is doctor
     */
    public function isDoctor(): bool
    {
        return $this->type === UserType::DOCTOR;
    }

    /**
     * Check if user is nurse
     */
    public function isNurse(): bool
    {
        return $this->type === UserType::NURSE;
    }

    /**
     * Check if user is patient
     */
    public function isPatient(): bool
    {
        return $this->type === UserType::PATIENT;
    }

    /**
     * Get user type label
     */
    public function getTypeLabel(): string
    {
        return $this->type->label();
    }

    /**
     * Check if user has any of the given types
     */
    public function hasType(UserType ...$types): bool
    {
        return in_array($this->type, $types, true);
    }

    /**
     * Scope to filter users by type
     */
    public function scopeOfType($query, UserType $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('type', UserType::ADMIN);
    }

    /**
     * Scope to filter doctors
     */
    public function scopeDoctors($query)
    {
        return $query->where('type', UserType::DOCTOR);
    }

    /**
     * Scope to filter nurses
     */
    public function scopeNurses($query)
    {
        return $query->where('type', UserType::NURSE);
    }

    /**
     * Scope to filter patients
     */
    public function scopePatients($query)
    {
        return $query->where('type', UserType::PATIENT);
    }


}
