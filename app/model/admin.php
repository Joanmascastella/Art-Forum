<?php

namespace model;

class Admin
{
    public int $AdminID;
    public string $AdminUsername;
    public string $AdminPassword;
    public string $AdminRole;
    public ?string $AdminEmail;


    public function __construct()
    {
    }

    public function getAdminID(): int
    {
        return $this->AdminID;
    }

    public function getAdminUsername(): string
    {
        return $this->AdminUsername;
    }

    public function getAdminPassword(): string
    {
        return $this->AdminPassword;
    }

    public function getAdminRole(): string
    {
        return $this->AdminRole;
    }

    public function getAdminEmail(): ?string
    {
        return $this->AdminEmail;
    }

    public function setAdminID(int $AdminID): void
    {
        $this->AdminID = $AdminID;
    }

    public function setAdminUsername(string $AdminUsername): void
    {
        $this->AdminUsername = $AdminUsername;
    }

    public function setAdminPassword(string $AdminPassword): void
    {
        $this->AdminPassword = $AdminPassword;
    }

    public function setAdminRole(string $AdminRole): void
    {
        $this->AdminRole = $AdminRole;
    }

    public function setAdminEmail(?string $AdminEmail): void
    {
        $this->AdminEmail = $AdminEmail;
    }


}